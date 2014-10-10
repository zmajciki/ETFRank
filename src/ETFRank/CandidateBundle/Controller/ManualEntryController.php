<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use ETFRank\CandidateBundle\Form\CandidateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for manual candidate entry
 *
 * @Route("/manual")
 */
class ManualEntryController extends CRUDController
{
    /**
     * Create new candidate.
     *
     * @Route("/create/{group}", name="manual_entry_create")
     */
    public function createCandidateAction(Request $request, CandidateGroup $group)
    {
        $candidate = new Candidate();
        $candidate->setGroup($group);
        $formType = new CandidateType();
        $redirect = $this->generateUrl('group_view', array('group' => $group->getId()));

        return $this->createAction(
            $request,
            $candidate,
            $formType,
            $redirect,
            'Candidate saved successfully',
            array('pageName' => 'Create new candidate')
        );
    }

    /**
     * Update candidate.
     *
     * @Route("/update/{candidate}", name="manual_entry_update")
     */
    public function updateCandidateAction(Request $request, Candidate $candidate)
    {
        $formType = new CandidateType();
        $redirect = $this->generateUrl('group_view', array('group' => $candidate->getGroup()->getId()));

        return $this->updateAction(
            $request,
            $candidate,
            $formType,
            $redirect,
            'Candidate saved successfully',
            array('pageName' => "Update candidate '{$candidate->getName()}'")
        );
    }

    /**
     * Remove candidate.
     *
     * @Route("/remove/{candidate}", name="manual_entry_remove")
     */
    public function removeCandidateAction(Request $request, Candidate $candidate)
    {
        $redirect = $this->generateUrl('group_view', array('group' => $candidate->getGroup()->getId()));

        return $this->removeAction(
            $request,
            $candidate,
            $redirect,
            'Confirm deletion of this candidate.',
            'Candidate removed successfully',
            array('pageName' => "Remove candidate '{$candidate->getName()}'")
        );
    }

    /**
     * Update candidate.
     *
     * @Route("/confirm/{candidate}", name="manual_entry_confirm")
     */
    public function confirmCandidateAction(Request $request, Candidate $candidate)
    {
        $entity = new Candidate();
        $entity->setGroup($candidate->getGroup());
        $form = $this->createForm(new CandidateType(), $entity);

        $form->handleRequest($request);

        $session = $this->get('session');
        if ($form->isValid()) {
            $accessor = new PropertyAccessor();
            $validateFields = array(
                'name',
                'parentName'
            );
            $candidateKey = 'confirmed_candidate_' . $candidate->getId();
            if ($session->has($candidateKey)) {
                $session->remove($candidateKey);
                foreach ($validateFields as $field) {
                    if ($accessor->getValue($entity, $field) != $accessor->getValue($candidate, $field)) {
                        $accessor->setValue($candidate, $field, $accessor->getValue($entity, $field));
                    }
                }
                return $this->confirmCandidate($candidate);
            } else {
                foreach ($validateFields as $field) {
                    if ($accessor->getValue($entity, $field) != $accessor->getValue($candidate, $field)) {
                        $form->get($field)->addError(
                            new FormError(
                                'Fields are not equal. Original value: "' . $accessor->getValue(
                                    $candidate,
                                    $field
                                ) . '"'
                            )
                        );
                    }
                }

                if ($form->isValid()) {
                    return $this->confirmCandidate($candidate);
                } else {
                    $session->set($candidateKey, true);
                }
            }
        }

        return $this->render('ETFRankCandidateBundle:CRUD:form.html.twig', array(
            'form' => $form->createView(),
            'pageName' => "Confirm candidate '{$candidate->getName()}'"
        ));
    }

    /**
     * @param Candidate $candidate
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function confirmCandidate(Candidate $candidate)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $candidate->setConfirmed(true);
        $em->flush();

        $this->get('braincrafted_bootstrap.flash')
            ->success('Candidate successfully confirmed');

        return $this->redirect($this->generateUrl('group_view', array('group' => $candidate->getGroup()->getId())));
    }
}
