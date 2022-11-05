<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $nsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="float")
     */
    private $moyene;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creation_date;

    public function getNsc(): ?int
    {
        return $this->nsc;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getMoyene(): ?float
    {
        return $this->moyene;
    }

    public function setMoyene(float $moyene): self
    {
        $this->moyene = $moyene;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(?\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }
}
