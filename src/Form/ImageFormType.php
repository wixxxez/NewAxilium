<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profile_photo',FileType::class, array(
                'label'=>'Choose your profile photo',
                'required'=>true,
                'mapped'=>false,
                'constraints'=> new File([
                    'mimeTypes'=>'image/*',
                    'mimeTypesMessage'=>'Please input are photo'
                ]),
                'attr'=>[ 'class'=>"custom-file-input"]
            ))
            ->add('save',SubmitType::class,array(
                'label'=>' ',
                
                'attr'=> [ 'class'=>'fa fa-upload', 'style'=>'background-color:#004bff;height:35px;width:35px;border-radius:50%;' ]
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
