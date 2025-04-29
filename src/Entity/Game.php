<?php

namespace App\Entity;

use App\Entity\Puzzle;
use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Student;
#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


     #[ORM\ManyToOne(targetEntity: Student::class)]
     #[ORM\JoinColumn(name:"student_id", referencedColumnName:"id")]

    private ?Student $student = null;

     #[ORM\ManyToOne(targetEntity:Puzzle::class)]
     #[ORM\JoinColumn(name:"puzzle_id", referencedColumnName:"id")]

    private ?Puzzle $puzzle = null;

    #[ORM\Column(nullable: true)]
    private ?float $score = null;

    #[ORM\Column(name:"remaining_string", length: 255, nullable: true)]
    private ?string $remainingString = null;

    #[ORM\Column(name:"created_at", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name:"is_done", type: Types::SMALLINT)]
    private ?int $isDone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getPuzzle(): ?Puzzle
    {
        return $this->puzzle;
    }

    public function setPuzzle(Puzzle $puzzle): static
    {
        $this->puzzle = $puzzle;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getRemainingString(): ?string
    {
        return $this->remainingString;
    }

    public function setRemainingString(?string $remainingString): static
    {
        $this->remainingString = $remainingString;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsDone(): ?int
    {
        return $this->isDone;
    }

    public function setIsDone(int $isDone): static
    {
        $this->isDone = $isDone;

        return $this;
    }
}
