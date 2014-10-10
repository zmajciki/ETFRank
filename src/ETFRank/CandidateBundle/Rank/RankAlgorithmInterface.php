<?php

namespace ETFRank\CandidateBundle\Rank;


use ETFRank\CandidateBundle\Entity\CandidateGroup;

interface RankAlgorithmInterface
{
    public function rank(CandidateGroup $group);
}
