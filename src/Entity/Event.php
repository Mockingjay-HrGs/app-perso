<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    /**
     * @var Collection<int, TicketType>
     */
    #[ORM\OneToMany(targetEntity: TicketType::class, mappedBy: 'event')]
    private Collection $user;

    /**
     * @var Collection<int, TicketType>
     */
    #[ORM\OneToMany(targetEntity: TicketType::class, mappedBy: 'event')]
    private Collection $ticketTypes;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'Event')]
    private Collection $tickets;

    public function __construct()
    {
        $this->ticketTypes = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }


    public function getSlug(): ?string { return $this->slug; }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }


    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }

    public function getDate(): ?\DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): self { $this->date = $date; return $this; }

    public function getLocation(): ?string { return $this->location; }
    public function setLocation(string $location): self { $this->location = $location; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self { $this->image = $image; return $this; }

    public function getCategory(): ?Category { return $this->category; }
    public function setCategory(?Category $category): self { $this->category = $category; return $this; }

    /**
     * @return Collection<int, TicketType>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function __toString(): string
    {
        return $this->title;
    }


    public function addUser(TicketType $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setEvent($this);
        }

        return $this;
    }

    public function removeUser(TicketType $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEvent() === $this) {
                $user->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TicketType>
     */
    public function getTicketTypes(): Collection
    {
        return $this->ticketTypes;
    }

    public function addTicketType(TicketType $ticketType): static
    {
        if (!$this->ticketTypes->contains($ticketType)) {
            $this->ticketTypes->add($ticketType);
            $ticketType->setEvent($this);
        }

        return $this;
    }

    public function removeTicketType(TicketType $ticketType): static
    {
        if ($this->ticketTypes->removeElement($ticketType)) {
            // set the owning side to null (unless already changed)
            if ($ticketType->getEvent() === $this) {
                $ticketType->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setEvent($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getEvent() === $this) {
                $ticket->setEvent(null);
            }
        }

        return $this;
    }
}
