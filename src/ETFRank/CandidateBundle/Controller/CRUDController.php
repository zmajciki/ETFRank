<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class CRUDController extends Controller
{
    /**
     * List all entities.
     *
     * @param string $entity   Doctrine entity name
     * @param string $view     View name
     * @param null   $pageName
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($entity, $view, $pageName = null, $criteria = array(), $order = array())
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository($entity)->findBy($criteria, $order);

        return $this->render($view, array(
            'entities' => $entities,
            'pageName' => $pageName,
        ));
    }

    /**
     * List all entities using pagination.
     *
     * @param        $entity
     * @param int    $page
     * @param int    $maxPerPage
     * @param string $view
     * @param array  $additionalVars
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPaginatedAction($entity, $page, $maxPerPage, $view, $additionalVars = array())
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository($entity)
            ->createQueryBuilder('e');

        return $this->listPaginatedFromQueryBuilderAction(
            $queryBuilder,
            $entity,
            $page,
            $maxPerPage,
            $view,
            $additionalVars
        );
    }

    /**
     * List all entities using pagination.
     *
     * @param QueryBuilder $queryBuilder
     * @param int          $page
     * @param int          $maxPerPage
     * @param string       $view
     * @param array        $additionalVars
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPaginatedFromQueryBuilderAction(QueryBuilder $queryBuilder, $page, $maxPerPage, $view, $additionalVars = array())
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($queryBuilder, $page, $maxPerPage);

        $vars = array_merge($additionalVars, array('pagination' => $pagination));

        return $this->render($view, $vars);
    }

    /**
     * Create new entity.
     *
     * @param Request      $request
     * @param              $entity
     * @param AbstractType $formType
     * @param              $redirect
     * @param string       $successMessage
     * @param string       $view
     * @param array        $additionalVars
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(
        Request $request,
        $entity,
        AbstractType $formType,
        $redirect,
        $successMessage = 'Entity saved successfully',
        $additionalVars = array(),
        $view = 'ETFRankCandidateBundle:CRUD:form.html.twig')
    {
        $form = $this->createForm($formType, $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')
                ->success($successMessage);
            return $this->redirect($redirect);
        }

        $vars = array_merge($additionalVars, array('form' => $form->createView()));

        return $this->render($view, $vars);
    }

    /**
     * Update entity.
     *
     * @param Request      $request
     * @param mixed        $entity
     * @param AbstractType $formType
     * @param string       $redirect
     * @param string       $successMessage
     * @param array        $additionalVars
     * @param string       $view
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(
        Request $request,
        $entity,
        AbstractType $formType,
        $redirect,
        $successMessage = 'Entity saved successfully',
        $additionalVars = array(),
        $view = 'ETFRankCandidateBundle:CRUD:form.html.twig')
    {
        $form = $this->createForm($formType, $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')
                ->success($successMessage);
            return $this->redirect($redirect);
        }

        $vars = array_merge($additionalVars, array('form' => $form->createView()));

        return $this->render($view, $vars);
    }

    /**
     * Remove entity.
     *
     * @param Request $request
     * @param mixed   $entity
     * @param string  $redirect
     * @param string  $confirmText
     * @param string  $successMessage
     * @param array   $additionalVars
     * @param string  $view
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function removeAction(
        Request $request,
        $entity,
        $redirect,
        $confirmText = 'Confirm deletion of this entity.',
        $successMessage = 'Entity deleted successfully',
        $additionalVars = array(),
        $view = 'ETFRankCandidateBundle:CRUD:remove.html.twig')
    {
        $form = $this->createFormBuilder()
            ->add('delete', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')
                ->success($successMessage);
            return $this->redirect($redirect);
        }

        $vars = array_merge($additionalVars, array('form' => $form->createView(), 'confirmText' => $confirmText));

        return $this->render($view, $vars);
    }
}
