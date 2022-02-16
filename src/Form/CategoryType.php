<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('name', TextType::class, [
                'label' => "Nom de la Category",
                'required' => true,
                'attr' => [
                    'placeholder' => "Entrez le nom de la Category",
                ],
                'constraints'=>[
                    new NotBlank([
                        'message'=>"ce champs ne doit pas être vide"
                    ]),
                    new Length([
                        'min'=>5,
                        'minMessage'=>"Erreur MIN",
                    ])
                ]
                    ])
            ->add('description', TextareaType::class, [
                'label' => "Description de la Category",
                'required' => false,
                'attr' => [
                    'placeholder' => "Description",
                    "rows" => 4,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
