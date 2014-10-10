<?php

namespace ETFRank\CandidateBundle\Rank;


use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use ETFRank\CandidateBundle\Entity\CandidateRank;
use ETFRank\CandidateBundle\Entity\RankList;

class StandardRankAlgorithm implements RankAlgorithmInterface
{
    const ER_LIMIT = 400;
    const SI_LIMIT = 10;

    public function rank(CandidateGroup $group)
    {
        $candidates = $group->getCandidates();

        /** @var Candidate[] $er */
        $er = array();
        /** @var Candidate[] $si */
        $si = array();

        /** @var Candidate $c */
        foreach ($candidates as $c) {
            if ($c->isERChosen()) {
                $er[] = $c;
            } else {
                $si[] = $c;
            }
        }

        $this->sortER($er);
        $this->sortSI($si);

        $uplimitER = 0;
        $uplimitSI = 0;
        do {
            $downlimitER = $uplimitER;
            $uplimitER = isset($er[self::ER_LIMIT - 1]) ? $er[self::ER_LIMIT - 1]->getERScore() : $downlimitER;
            $exchangeER = array();
            for ($i = self::ER_LIMIT; $i < count($er); $i++) {
                if ($er[$i]->getERScore() < $uplimitER && $er[$i]->getERScore() >= $downlimitER) {
                    $exchangeER[] = $er[$i];
                }
            }
            $si = array_merge($si, $exchangeER);
            $si = array_unique($si);
            $this->sortSI($si);

            $downlimitSI = $uplimitSI;
            $uplimitSI = isset($si[self::SI_LIMIT - 1]) ? $si[self::SI_LIMIT - 1]->getSIScore() : $downlimitSI;
            $exchangeSI = array();
            for ($i = self::SI_LIMIT; $i < count($si); $i++) {
                if ($si[$i]->getSIScore() < $uplimitSI && $si[$i]->getSIScore() >= $downlimitSI) {
                    $exchangeSI[] = $si[$i];
                }
            }
            $er = array_merge($er, $exchangeSI);
            $er = array_unique($er);
            $this->sortER($er);
        } while (!(empty($exchangeER) && empty($exchangeSI)));

        $rankListER = new RankList($group, 'ER');
        $rankListSI = new RankList($group, 'SI');

        foreach ($er as $key => $c) {
            $rank = new CandidateRank($c, $key, $rankListER);
            $rankListER->getRanks()->add($rank);
        }

        foreach ($si as $key => $c) {
            $rank = new CandidateRank($c, $key, $rankListSI);
            $rankListSI->getRanks()->add($rank);
        }

        return array($rankListER, $rankListSI);
    }

    public function sortER(&$er)
    {
        usort(
            $er,
            function (Candidate $a, Candidate $b) {
                $as = $a->getERScore();
                $bs = $b->getERScore();

                if ($as > $bs) {
                    return -1;
                } elseif ($as < $bs) {
                    return 1;
                } else {
                    return 0;
                }
            }
        );
    }

    private function sortSI(&$si) {
        usort(
            $si,
            function (Candidate $a, Candidate $b) {
                $as = $a->getSIScore();
                $bs = $b->getSIScore();

                if ($as > $bs) {
                    return -1;
                } elseif ($as < $bs) {
                    return 1;
                } else {
                    return 0;
                }
            }
        );
    }
}
