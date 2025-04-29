<?php

namespace App\Service;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
class ScoreCalculatorService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    /**
     * Method to init score calculation
     *
     * @param int $gameId
     *
     * @return mixed
     */
    public function init(int $gameId)
    {
        return $this->entityManager->getRepository(Game::class)->handleScore($gameId);
    }
}