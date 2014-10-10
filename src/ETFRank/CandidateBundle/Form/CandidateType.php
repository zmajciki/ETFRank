<?php

namespace ETFRank\CandidateBundle\Form;

use ETFRank\CandidateBundle\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('parentName')
            ->add('highSchool')
            ->add('highSchoolScore')
            ->add('awardMathematics')
            ->add('awardPhysics')
            ->add('awardInformatics')
            ->add('chosenFieldOfStudy', 'choice', array(
                    'choices' => Candidate::getFieldsOfStudy(),
                    'empty_value' => '',
                ))
            ->add('entranceExamMathematics')
            ->add('entranceExamPhysics')
            ->add('Save', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ETFRank\CandidateBundle\Entity\Candidate',
            'required'   => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'etfrank_candidatebundle_candidate';
    }
}
