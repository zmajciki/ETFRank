<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use ETFRank\CandidateBundle\Simulation\SimulationService;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/simulation")
 */
class SimulationController extends Controller
{
    /**
     * List all groups.
     *
     * @Route("/run/{group}", name="simulation_run")
     * @Template()
     */
    public function runAction(Request $request, CandidateGroup $group)
    {
        $simulationService = new SimulationService();

        $form = $this->createFormBuilder()
            ->add('simulation', 'choice', array(
                    'constraints' => new NotBlank(),
                    'choices' => $simulationService->getSimulations(),
                ))
            ->add('runSimulation', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $candidates = $simulationService->run($group, $form->get('simulation')->getData());

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            foreach ($candidates as $c) {
                $em->persist($c);
            }
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')
                ->success('Simulation has finished successfully.');
            return $this->redirect($this->generateUrl('group_view', array('group' => $group->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
