<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\String\Slugger\SluggerInterface;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Event) return;

        if (empty($entityInstance->getSlug())) {
            $slug = $this->slugger->slug($entityInstance->getTitle())->lower();
            $entityInstance->setSlug($slug);
        }

        parent::persistEntity($em, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            DateTimeField::new('date')
                ->setFormat('dd MMMM yyyy à HH:mm')
                ->setTimezone('Europe/Paris'),
            TextField::new('location'),
            TextField::new('image'),
            AssociationField::new('category'),
        ];
    }
}
