<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;




class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('name',TextType::class, array(
                'label'=>'NickName',
                'attr'=>['class' => 'form-control'],
                'required'=>false,
                
            ))
            ->add('hobby',TextType::class, array(
                'label'=>'Hobby',
                'attr'=>['class' => 'form-control'],
                'required'=>false
            ))
            ->add('email',EmailType::class,array(
                'label'=>'Email',
                'attr'=>['class' => 'form-control'],
                'required'=>false
            ))
            ->add('plainPassword', RepeatedType::class , array(
                'type'=>PasswordType::class,
                'first_options'=>array(
                    'label'=>'Input password',
                    'attr'=>['class' => 'form-control']
                ),
                'second_options'=>array(
                    "label"=>"Repeat Password",
                    'attr'=>['class' => 'form-control']
                ),
                'required'=>false
                )
                )
            
            ->add('save',SubmitType::class, array(
                'label'=>'Save changes',
                'attr'=>['class'=>'btn btn-primary']
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
