<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $rollNo = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 40)]
    private ?string $fatherName = null;

    #[ORM\Column(length: 3)]
    private ?string $class = null;

    #[ORM\Column(length: 13)]
    private ?string $session = null;

    #[ORM\OneToOne(mappedBy: 'rollNo', cascade: ['persist', 'remove'])]
    private ?Marks $marks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRollNo(): ?int
    {
        return $this->rollNo;
    }

    public function setRollNo(int $rollNo): static
    {
        $this->rollNo = $rollNo;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(string $fatherName): static
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getMarks(): ?Marks
    {
        return $this->marks;
    }

    public function setMarks(?Marks $marks): static
    {
        // unset the owning side of the relation if necessary
        if ($marks === null && $this->marks !== null) {
            $this->marks->setRollNo(null);
        }

        // set the owning side of the relation if necessary
        if ($marks !== null && $marks->getRollNo() !== $this) {
            $marks->setRollNo($this);
        }

        $this->marks = $marks;

        return $this;
    }

    public function getTotal(){
        return $this->getMarks();
    }
}
