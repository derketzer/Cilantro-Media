<?php

namespace Cilantro\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cilantro\AdminBundle\Entity\User'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, Array $options)
    {
        $builder->add('email', EmailType::class, ['label'=>' ',
            'required' => true,
            'attr'=>['class'=>'col-xs-10 col-sm-5']])
            ->add('username', TextType::class, ['label'=>' ',
                'required' => true,
                'attr'=>['class'=>'col-xs-10 col-sm-5']])
            ->add('name', TextType::class, ['label'=>' ',
                'required' => true,
                'attr'=>['class'=>'col-xs-10 col-sm-5']])
            ->add('lastname', TextType::class, ['label'=>' ',
                'required' => true,
                'attr'=>['class'=>'col-xs-10 col-sm-5']])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'Las contraseñas deben coincidir.',
                'first_options'  => ['label' => ' ', 'attr'=>['class'=>'col-xs-10 col-sm-5']],
                'second_options' => ['label' => ' ', 'attr'=>['class'=>'col-xs-10 col-sm-5']],
                ]
            )
            ->add('Guardar', SubmitType::class)
        ;
    }
}
