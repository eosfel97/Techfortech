<?php

namespace App\Controller\Admin;

use App\Entity\CategoryParent;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryParentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryParent::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
