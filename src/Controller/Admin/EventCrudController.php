<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\String\Slugger\SluggerInterface;

class EventCrudController extends AbstractCrudController
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Event) return;

        $this->setSlug($entityInstance);

        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Event) return;

        $this->setSlug($entityInstance);

        parent::updateEntity($em, $entityInstance);
    }

    private function setSlug(Event $event): void
    {
        if (empty($event->getSlug()) && $event->getTitle()) {
            $slug = $this->slugger->slug($event->getTitle())->lower();
            $event->setSlug($slug);
        }
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('description'),
            DateTimeField::new('date')
                ->setFormat('dd MMMM yyyy à HH:mm')
                ->setTimezone('Europe/Paris'),
            TextField::new('location'),
            TextField::new('image'),
            AssociationField::new('category'),
        ];
    }
}
