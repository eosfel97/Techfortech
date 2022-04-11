<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\CategoryParent;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('name'),
            TextEditorField::new('description'),
            AssociationField::new('category', 'Categoryparent'),

        ];
    }

    // public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    // {
    //     if(!$entityInstance instanceof Category) return;
    //     foreach ($entityInstance->() as $product){
    //         $em->remove($product);
    //     }
    //     parent::deleteEntity($em,$entityInstance);
    // }
}
