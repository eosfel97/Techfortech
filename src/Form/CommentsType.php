<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre pseudo',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'titre du commantaire',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => "Contenu du commentaire",
                'attr' => [

                    "rows" => 3,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
