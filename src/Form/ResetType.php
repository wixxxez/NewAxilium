<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plain_password',RepeatedType::class,array(
                'first_options'=>[
                    'label'=>" ",
                    'attr'=>['class'=>'form-controll','placeholder'=>'Input your password']
                ],
                'second_options'=>[
                    'label'=>" ",
                    'attr'=>['class'=>'form-controll','placeholder'=>'Repeat your password']
                ]
            ))
            ->add('save',SubmitType::class,array(
                'label'=>"Change",
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
