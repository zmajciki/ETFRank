<?php

namespace ETFRank\CandidateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * Show homepage.
     *
     * @Route("/", name="homepage")
     * @Template()
     */
    public function homepageAction()
    {
        return array();
    }
}
