<?php

namespace App\Controller\Admin;

use App\Entity\TicketType;
use App\Entity\Ticket;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Doctrine\ORM\EntityManagerInterface;

class TicketTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TicketType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('event'),
            TextField::new('name'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('description'),
            IntegerField::new('stock'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof TicketType) return;

        parent::persistEntity($entityManager, $entityInstance);

        for ($i = 0; $i < $entityInstance->getStock(); $i++) {
            $ticket = new Ticket();
            $ticket->setEvent($entityInstance->getEvent());
            $ticket->setTicketType($entityInstance);
            $ticket->setCode('TICKET_' . bin2hex(random_bytes(8)));
            $ticket->setStatus('disponible');
            $ticket->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($ticket);
        }

        $entityManager->flush();
    }

}
