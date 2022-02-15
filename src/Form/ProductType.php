<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('name', TextType::class, [
                'label' => "Nom de l'item",
                'required' => true,
                'attr' => [
                    'placeholder' => "Entrez le nom de l'item",
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
            ->add('price', IntegerType::class, [
                'label' => "prix de l'item",
                'required' => true,
                'attr' => [
                    'placeholder' => "Entrez prix de l'item",
                ],
            ])
            ->add('reduct', IntegerType::class, [
                'label' => "reduction ?",
                'required' => false,
                'attr' => [
                    'placeholder' => "Entrez la reduction",
                ],
            ])
            
            ->add('description', TextareaType::class, [
                'label' => "description de l'item",
                'required' => false,
                'attr' => [
                    'placeholder' => "Ajouter une description",
                    "rows" => 3,
                ],
            ])
            ->add('category_id', EntityType::class, [
                'label' => "Choisir la catégorie",
                "placeholder" => "--choisir une catégorie --",
                "class" => Category::class,
                "choice_label" => "name",
                'required' => true,
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
