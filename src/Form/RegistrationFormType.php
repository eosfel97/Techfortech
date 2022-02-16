<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('username', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Username",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre unsername.",
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Email",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "L'email {{ valeur }} n'est pas un email valide.",
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de famille",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre nom.",
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Prénom",
                ],'constraints'=>[

                 new NotBlank([
                            'message' => "Vous devez indiquer votre prénom.",
                        ]),
                ]
            ])
            
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Mot de passe",
                    'autocomplete' => 'new-password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer un mot de passe.",
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => "Votre mot de passe doit comporter au moins {{ limite }} caractères.",
                    ]),
                ],
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Numéro de téléphone",
                ],
                 'constraints' => [

                     new NotBlank([
                        'message' => "Vous devez indiquer votre numéro de téléphone.",
                    ]),
                 ]
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Adresse postale",
                ],     'constraints' => [
                    new NotBlank([
                           'message' => "Vous devez indiquer votre adresse postale.",
                       ]),
                    ]
                     
            ])
            


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
