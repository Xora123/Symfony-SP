<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fullname', TextType::class, [
            'label' => 'Nom/Prénom',
            'attr' => [
                'placeholder' => 'Nom/Prénom',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner votre Nom et Prénom',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'attr' => [
                'placeholder' => 'Email',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner votre email',
                ]),
            ],
        ])
        ->add('subject', TextType::class, [
            'label' => 'Subject',
            'attr' => [
                'placeholder' => 'Sujet',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner le Sujet',
                ]),
            ],
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message',
            'attr' => [
                'placeholder' => 'Message',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner le Message',
                ]),
            ],
        ])
        
        ->add('submit', SubmitType :: class, [
            'attr' =>[
                'class' => 'btn btn-primary mt-4'
            ],
            'label' => 'Envoyer'
        ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
