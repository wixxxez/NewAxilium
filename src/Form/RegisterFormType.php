<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            
            ->add('email', EmailType::class, array(
                'label'=>'Input your Email'
            ))
           
            ->add('plainPassword', RepeatedType::class , array(
                'type'=>PasswordType::class,
                'first_options'=>array(
                    'label'=>'Input password'
                ),
                'second_options'=>array(
                    "label"=>"Repeat Password"
                )
            ))
            ->add('save',SubmitType::class, array(
                'label'=>'Register'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
