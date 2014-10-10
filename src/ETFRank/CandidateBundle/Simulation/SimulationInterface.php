<?php

namespace ETFRank\CandidateBundle\Simulation;

use ETFRank\CandidateBundle\Entity\CandidateGroup;

interface SimulationInterface
{
    public function run(CandidateGroup $group);
}
