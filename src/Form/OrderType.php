<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'required' => true,
                'attr' => [
                'placeholder' => "name",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre prenom.",
                    ]),
                ],
            ])
            ->add('firstname',TextType::class,[
                'required' => true,
                'attr' => [
                'placeholder' => "firstname",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre nom.",
                    ]),
                ],
            ])
            ->add('town',TextType::class,[
                'required' => true,
                'attr' => [
                'placeholder' => "Ville/Commune",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre Ville/Commune.",
                    ]),
                ],
            ])
            ->add('country',TextType::class,[
                'required' => true,
                'attr' => [
                'placeholder' => "Pays",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre Pays.",
                    ]),
                ],
            ])
            ->add('zip_code',TextType::class,[
                'required' => true,
                'attr' => [
                'placeholder' => "Code Postale",
                ],'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez indiquer votre Code Postale.",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
