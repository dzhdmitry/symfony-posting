<?php

namespace AppBundle\Form;

use AppBundle\Entity\AuthorPost;
use AppBundle\Entity\AuthorPostDetails;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorPostType extends PostType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('authorPostDetails', AuthorPostDetailsType::class, [
                'data_class' => AuthorPostDetails::class
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AuthorPost::class
        ]);
    }
}
