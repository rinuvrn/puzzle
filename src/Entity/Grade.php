<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private ?int $student = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Puzzle")
     * @ORM\JoinColumn(name="puzzle_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private ?int $puzzle = null;

    #[ORM\Column]
    private ?float $score = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getStudent(): ?int
    {
        return $this->student;
    }

    public function setStudent(int $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getPuzzle(): ?int
    {
        return $this->puzzle;
    }

    public function setPuzzle(int $puzzle): static
    {
        $this->puzzle = $puzzle;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
