<?php

namespace ETFRank\CandidateBundle\Simulation;

use ETFRank\CandidateBundle\Entity\CandidateGroup;

class SimulationService
{
    public function getSimulations()
    {
        return array(
            'maxSuccess' => 'ETFRank\CandidateBundle\Simulation\MaxSuccessSimulation',
            'gaussian' => 'ETFRank\CandidateBundle\Simulation\GaussianSuccessSimulation',
        );
    }

    /**
     * @param string $simulationId
     *
     * @return null|SimulationInterface
     */
    public function getSimulationInstance($simulationId)
    {
        $simulation = $this->getSimulations();
        if (isset($simulation[$simulationId])) {
            return new $simulation[$simulationId]();
        } else {
            return null;
        }
    }

    public function run(CandidateGroup $group, $simulationId)
    {
        $simulation = $this->getSimulationInstance($simulationId);
        return $simulation->run($group);
    }
}
