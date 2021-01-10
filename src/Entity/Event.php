<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $player_1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $player_2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $player_3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $player_4;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="date")
     */
    private $createdDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getPlayer1(): ?int
    {
        return $this->player_1;
    }

    public function setPlayer1(?int $player_1): self
    {
        $this->player_1 = $player_1;

        return $this;
    }

    public function getPlayer2(): ?int
    {
        return $this->player_2;
    }

    public function setPlayer2(?int $player_2): self
    {
        $this->player_2 = $player_2;

        return $this;
    }

    public function getPlayer3(): ?int
    {
        return $this->player_3;
    }

    public function setPlayer3(?int $player_3): self
    {
        $this->player_3 = $player_3;

        return $this;
    }

    public function getPlayer4(): ?int
    {
        return $this->player_4;
    }

    public function setPlayer4(?int $player_4): self
    {
        $this->player_4 = $player_4;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->User;
    }

    public function setIdUser(?User $user): self
    {
        $this->User = $user;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }
}
