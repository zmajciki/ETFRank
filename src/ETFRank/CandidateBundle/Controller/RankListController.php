<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use ETFRank\CandidateBundle\Entity\RankList;
use ETFRank\CandidateBundle\Rank\RankService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/rank")
 */
class RankListController extends CRUDController
{
    /**
     * List all rank lists.
     *
     * @Route("/list/{group}", name="rank_list_list")
     */
    public function listGroupsAction(Request $request, CandidateGroup $group)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('ETFRankCandidateBundle:RankList')
            ->createQueryBuilder('e')
            ->where('e.group = :group')
            ->setParameter('group', $group->getId());

        return $this->listPaginatedFromQueryBuilderAction(
            $queryBuilder,
            $request->query->get('page', 1),
            20,
            'ETFRankCandidateBundle:RankList:list.html.twig',
            array(
                'pageName' => "Rank lists for {$group->getName()}",
                'group'    => $group,
            )
        );
    }

    /**
     * Create new candidate group.
     *
     * @Route("/create/{group}", name="rank_list_create")
     * @Template()
     */
    public function createRankListAction(Request $request, CandidateGroup $group)
    {
        $rankService = new RankService();

        $form = $this->createFormBuilder()
            ->add('rankListName', 'text', array(
                'constraints' => new NotBlank(),
            ))
            ->add('algorithm', 'choice', array(
                'constraints' => new NotBlank(),
                'choices' => $rankService->getRankAlgorithms(),
            ))
            ->add('createRankList', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $rankLists = $rankService->rank($group, $form->get('algorithm')->getData());

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();

            /** @var RankList $rankList */
            foreach ($rankLists as $rankList) {
                $rankList->setName("{$form->get('rankListName')->getData()} [{$rankList->getName()}]");
                $ranks = $rankList->getRanks();
                $rankList->setRanks(null);
                $em->persist($rankList);
                $em->flush();

                foreach ($ranks as $r) {
                    $em->persist($r);
                }
                $em->flush();
            }

            $this->get('braincrafted_bootstrap.flash')
                ->success('Rank list has been created.');
            return $this->redirect($this->generateUrl('rank_list_list', array('group' => $group->getId())));
        }

        return array(
            'form' => $form->createView(),
            'group' => $group,
        );
    }

    /**
     * List all rank lists.
     *
     * @Route("/view/{rankList}", name="rank_list_view")
     */
    public function viewRankListAction(Request $request, RankList $rankList)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('ETFRankCandidateBundle:Candidate')
            ->createQueryBuilder('e')
            ->join('e.rank', 'r')
            ->where('r.rankList = :rankList')
            ->setParameter('rankList', $rankList->getId())
            ->orderBy('r.rank');

        return $this->listPaginatedFromQueryBuilderAction(
            $queryBuilder,
            $request->query->get('page', 1),
            1500,
            'ETFRankCandidateBundle:RankList:viewRankList.html.twig',
            array(
                'pageName' => $rankList->getName(),
            )
        );
    }

    /**
     * Remove rank list.
     *
     * @Route("/remove/{rankList}", name="rank_list_remove")
     */
    public function removeGroupAction(Request $request, RankList $rankList)
    {
        $redirect = $this->generateUrl('rank_list_list', array('group' => $rankList->getGroup()->getId()));

        return $this->removeAction(
            $request,
            $rankList,
            $redirect,
            'Do you want to delete this rank list?',
            'Rank list removed successfully',
            array('pageName' => "Remove rank list '{$rankList->getName()}'")
        );
    }
}
