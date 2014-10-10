<?php

namespace ETFRank\CandidateBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Candidate data entry', array('route' => 'homepage'));
        $menu->addChild('Create rank list', array('route' => 'homepage'));
        $menu->addChild('Simulation', array('route' => 'homepage'));

        return $menu;
    }
}
