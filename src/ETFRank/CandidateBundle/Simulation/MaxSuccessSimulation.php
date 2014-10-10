<?php

namespace ETFRank\CandidateBundle\Simulation;

use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;

class MaxSuccessSimulation implements SimulationInterface
{
    const simulationTarget = 'Physics';
    //const simulationTarget = 'Mathematics';

    const MAX = 100;

    public function run(CandidateGroup $group)
    {
        $candidates = $group->getCandidates();

        /** @var Candidate $c */
        foreach ($group->getCandidates() as $c) {
            if ($c->isSubscribedForPhysics()) {
                $method = 'setEntranceExam' . self::simulationTarget;
                $c->$method(self::MAX);
            }
        }

        return $candidates;
    }
}
