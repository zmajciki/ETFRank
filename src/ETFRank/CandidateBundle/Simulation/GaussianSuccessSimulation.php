<?php

namespace ETFRank\CandidateBundle\Simulation;

use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;

class GaussianSuccessSimulation implements SimulationInterface
{
    const simulationTarget = 'Physics';
    //const simulationTarget = 'Mathematics';

    const STD_DEV = 29;
    const MIN = 0;
    const MAX = 100;

    public function run(CandidateGroup $group)
    {
        $candidates = $group->getCandidates();

        /** @var Candidate $c */
        foreach ($group->getCandidates() as $c) {
            if ($c->isSubscribedForPhysics()) {
                $method = 'setEntranceExam' . self::simulationTarget;
                $c->$method($this->gaussianRand(self::MIN, self::MAX, self::STD_DEV));
            }
        }

        return $candidates;
    }

    public function gaussianRand($min,$max,$std_deviation,$step=0.01) {
        $rand1 = (float)mt_rand()/(float)mt_getrandmax();
        $rand2 = (float)mt_rand()/(float)mt_getrandmax();
        $gaussian_number = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
        $mean = ($max + $min) / 2;
        $random_number = ($gaussian_number * $std_deviation) + $mean;
        $random_number = round($random_number / $step) * $step;
        if($random_number < $min || $random_number > $max) {
            $random_number = $this->gaussianRand($min, $max,$std_deviation);
        }
        return $random_number;
    }
}
