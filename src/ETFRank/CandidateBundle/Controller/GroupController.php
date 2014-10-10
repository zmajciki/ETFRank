<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use ETFRank\CandidateBundle\Form\CandidateGroupType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/group")
 */
class GroupController extends CRUDController
{
    /**
     * List all groups.
     *
     * @Route("/list", name="group_list")
     */
    public function listGroupsAction()
    {
        return $this->listAction(
            'ETFRankCandidateBundle:CandidateGroup',
            'ETFRankCandidateBundle:Group:list.html.twig',
            'All Groups',
            array(),
            array('name' => 'ASC')
        );
    }

    /**
     * Create new candidate group.
     *
     * @Route("/create", name="group_create")
     */
    public function createGroupAction(Request $request)
    {
        $group = new CandidateGroup();
        $formType = new CandidateGroupType();
        $redirect = $this->generateUrl('homepage');

        return $this->createAction(
            $request,
            $group,
            $formType,
            $redirect,
            'Group saved successfully',
            array('pageName' => 'Create new group')
        );
    }

    /**
     * Update candidate group.
     *
     * @Route("/update/{group}", name="group_update")
     */
    public function updateGroupAction(Request $request, CandidateGroup $group)
    {
        $formType = new CandidateGroupType();
        $redirect = $this->generateUrl('homepage');

        return $this->updateAction(
            $request,
            $group,
            $formType,
            $redirect,
            'Group saved successfully',
            array('pageName' => "Update group '{$group->getName()}'")
        );
    }

    /**
     * Remove candidate group.
     *
     * @Route("/remove/{group}", name="group_remove")
     */
    public function removeGroupAction(Request $request, CandidateGroup $group)
    {
        $redirect = $this->generateUrl('homepage');

        return $this->removeAction(
            $request,
            $group,
            $redirect,
            'Confirm deletion of this group.',
            'Group removed successfully',
            array('pageName' => "Remove group '{$group->getName()}'")
        );
    }

    /**
     * List all candidates from group.
     *
     * @Route("/view/{group}", name="group_view")
     */
    public function listCandidatesAction(Request $request, CandidateGroup $group)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('ETFRankCandidateBundle:Candidate')
            ->createQueryBuilder('e')
            ->where('e.group = :group')
            ->setParameter('group', $group->getId());

        return $this->listPaginatedFromQueryBuilderAction(
            $queryBuilder,
            $request->query->get('page', 1),
            1500,
            'ETFRankCandidateBundle:Group:listCandidates.html.twig',
            array(
                'pageName' => "Candidates from group '{$group->getName()}'",
                'group'    => $group,
            )
        );
    }
}
