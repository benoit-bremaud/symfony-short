<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author')]
    private Collection $recipient;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author')]
    private Collection $sentMessages;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'recipient')]
    private Collection $receiveMessages;

    public function __construct()
    {
        $this->recipient = new ArrayCollection();
        $this->sentMessages = new ArrayCollection();
        $this->receiveMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getRecipient(): Collection
    {
        return $this->recipient;
    }

    public function addRecipient(Message $recipient): static
    {
        if (!$this->recipient->contains($recipient)) {
            $this->recipient->add($recipient);
            $recipient->setAuthor($this);
        }

        return $this;
    }

    public function removeRecipient(Message $recipient): static
    {
        if ($this->recipient->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getAuthor() === $this) {
                $recipient->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSentMessages(): Collection
    {
        return $this->sentMessages;
    }

    public function addSentMessage(Message $sentMessage): static
    {
        if (!$this->sentMessages->contains($sentMessage)) {
            $this->sentMessages->add($sentMessage);
            $sentMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeSentMessage(Message $sentMessage): static
    {
        if ($this->sentMessages->removeElement($sentMessage)) {
            // set the owning side to null (unless already changed)
            if ($sentMessage->getAuthor() === $this) {
                $sentMessage->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getReceiveMessages(): Collection
    {
        return $this->receiveMessages;
    }

    public function addReceiveMessage(Message $receiveMessage): static
    {
        if (!$this->receiveMessages->contains($receiveMessage)) {
            $this->receiveMessages->add($receiveMessage);
            $receiveMessage->setRecipient($this);
        }

        return $this;
    }

    public function removeReceiveMessage(Message $receiveMessage): static
    {
        if ($this->receiveMessages->removeElement($receiveMessage)) {
            // set the owning side to null (unless already changed)
            if ($receiveMessage->getRecipient() === $this) {
                $receiveMessage->setRecipient(null);
            }
        }

        return $this;
    }
}
