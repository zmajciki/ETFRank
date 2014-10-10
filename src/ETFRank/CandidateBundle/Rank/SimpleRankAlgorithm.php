<?php

namespace ETFRank\CandidateBundle\Rank;


use ETFRank\CandidateBundle\Entity\CandidateGroup;
use ETFRank\CandidateBundle\Entity\CandidateRank;
use ETFRank\CandidateBundle\Entity\RankList;

class SimpleRankAlgorithm implements RankAlgorithmInterface
{
    public function rank(CandidateGroup $group)
    {
        $rankList = new RankList();
        $rankList->setGroup($group);
        $rankList->setName('TEST');

        $candidates = $group->getCandidates();
        $ranks = $rankList->getRanks();
        foreach ($candidates as $key => $c) {
            $rank = new CandidateRank($c, $key, $rankList);
            $ranks->add($rank);
        }

        return array($rankList);
    }
}
