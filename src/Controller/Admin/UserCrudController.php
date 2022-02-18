<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LocaleField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class UserCrudController extends AbstractCrudController
{    public const PRODUCTS_BASE_PATH = 'upload/images/users';
    public const PRODUCTS_UPLOAD_DIR = 'public/upload/images/users';
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Username'),
            EmailField::new('Email'),
            TextField::new('password'),
            TextField::new('Firstname'),
            TextField::new('Lastname'),
            TelephoneField::new('Phone'),
            TextEditorField::new('Address'),
            ImageField::new('avartar')
            ->setBasepath(self::PRODUCTS_BASE_PATH )
            ->setUploadDir(self::PRODUCTS_UPLOAD_DIR),
            ArrayField::new('roles'),
            DateTimeField::new('crearted')
        ];
    }
    
}
