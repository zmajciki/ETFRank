<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use ETFRank\CandidateBundle\Crawler\CrawlerService;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/crawler")
 */
class CrawlerController extends Controller
{
    /**
     * List all groups.
     *
     * @Route("/run/{group}", name="crawler_run")
     * @Template()
     */
    public function runAction(Request $request, CandidateGroup $group)
    {
        $crawlerService = new CrawlerService();

        $form = $this->createFormBuilder()
            ->add('crawler', 'choice', array(
                    'constraints' => new NotBlank(),
                    'choices' => $crawlerService->getCrawlers(),
                ))
            ->add('runCrawler', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $candidates = $crawlerService->crawl($group, $form->get('crawler')->getData());

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            foreach ($candidates as $c) {
                $em->persist($c);
            }
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')
                ->success('Crawler has finished successfully.');
            return $this->redirect($this->generateUrl('group_view', array('group' => $group->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
