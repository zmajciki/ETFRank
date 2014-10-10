<?php

namespace ETFRank\CandidateBundle\Rank;


use ETFRank\CandidateBundle\Entity\CandidateGroup;

class RankService
{
    public function getRankAlgorithms()
    {
        return array(
            'standard' => 'ETFRank\CandidateBundle\Rank\StandardRankAlgorithm',
            'simple' => 'ETFRank\CandidateBundle\Rank\SimpleRankAlgorithm',
        );
    }

    /**
     * @param string $algorithmId
     *
     * @return null|RankAlgorithmInterface
     */
    public function getRankAlgorithmInstance($algorithmId)
    {
        $algorithms = $this->getRankAlgorithms();
        if (isset($algorithms[$algorithmId])) {
            return new $algorithms[$algorithmId]();
        } else {
            return null;
        }
    }

    public function rank(CandidateGroup $group, $algorithmId)
    {
        $algorithm = $this->getRankAlgorithmInstance($algorithmId);
        return $algorithm->rank($group);
    }
}
