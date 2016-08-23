<?php

namespace Cilantro\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private $rolesHierarchy;
    private $roles;

    public function __construct($rolesHierarchy)
    {
        $this->rolesHierarchy = $rolesHierarchy;
    }

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
            ->add('enabled', CheckboxType::class, ['label'=>' ',
                'required' => true])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'Las contraseñas deben coincidir.',
                'first_options'  => ['label' => ' ', 'attr'=>['class'=>'col-xs-10 col-sm-5']],
                'second_options' => ['label' => ' ', 'attr'=>['class'=>'col-xs-10 col-sm-5']]
                ])
            ->add('roles', ChoiceType::class, ['choices'=>$this->getRoles(),
                'multiple'=>true,
                'label'=>' '
                ])
            ->add('Guardar', SubmitType::class)
        ;
    }

    private function getRoles()
    {
        if(!empty($this->roles))
            return array_unique($this->roles);

        $this->roles = array();
        array_walk_recursive($this->rolesHierarchy, function($val) use (&$roles) {
            $name = ucfirst(trim(strtolower(str_replace('_', ' ', str_replace('ROLE_', ' ', $val)))));
            $this->roles[$name] = $val;
        });

        return array_unique($this->roles);
    }
}
