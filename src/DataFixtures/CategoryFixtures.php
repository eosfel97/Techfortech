<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = [
            1 => [
                'name' => 'Boîtier',
                'description' => ""

            ],
            2 => [
                'name' => 'Carte mère',
                'description' => ""
            ],

            3 => [
                'name' => 'Processeur',
                'description' => ''
            ],
            4 => [
                'name' => 'Cartes graphique',
                'description' => ''
            ],
            5 => [
                'name' => 'Disque dur & SSD',
                'description' => ''
            ],
            6 => [
                'name' => 'Mémoire',
                'description' => ''
            ],
            7 => [
                'name' => 'Refroidissement PC',
                'description' => ''
            ],
            8 => [
                'name' => 'PC de bureau',
                'description' => ''
            ],
            9 => [
                'name' => 'Ordinateur Mac',
                'description' => ''
            ],
            10 => [
                'name' => 'Ecran ordinateur',
                'description' => ''
            ],
            11 => [
                'name' => 'Clavier, souris, saisie',
                'description' => ''
            ],
            12 => [
                'name' => 'Casque & micro',
                'description' => ''
            ],
            13 => [
                'name' => 'Webcam',
                'description' => ''
            ],
            14 => [
                'name' => 'Stockage externe',
                'description' => ''
            ],
            15 => [
                'name' => 'PC portable',
                'description' => ''
            ],
        ];
        foreach ($category as $keys => $values) {
            $category = new Category();
            $category->setName($values['name']);
            $category->setDescription($values['description']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
