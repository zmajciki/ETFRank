<?php

namespace ETFRank\CandidateBundle\Controller;

use Doctrine\ORM\EntityManager;
use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use ETFRank\CandidateBundle\Import\CSVImporter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

/**
 * @Route("/import")
 */
class ImportController extends Controller
{
    /**
     * List all groups.
     *
     * @Route("/csv/{group}", name="import_csv_run")
     * @Template()
     */
    public function runAction(Request $request, CandidateGroup $group)
    {
        $form = $this->createFormBuilder()
            ->add('file', 'file', array(
                'constraints' => new File(array(
                    'maxSize' => '5M',
                    'mimeTypes' => array('text/csv', 'text/plain'),
                    'mimeTypesMessage' => 'Please upload a valid CSV file',
                ))
            ))
            ->add('runImport', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('file')->getData();
            $file = $uploadedFile->openFile('r');
            $importer = new CSVImporter();
            $candidates = $importer->import($file, $group);

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var Candidate $c */
            foreach ($candidates as $c) {
                $c->setConfirmed(true);
                $em->persist($c);
            }
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')
                ->success('Import has finished successfully.');
            return $this->redirect($this->generateUrl('group_view', array('group' => $group->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
