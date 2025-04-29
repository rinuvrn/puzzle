<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Words;
use App\Entity\Puzzle;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * Create a game with user inputted data
     *
     * @param Puzzle $puzzleObj
     * @param Student $studentObj
     * @param array $data
     * @return Game
     */
    public function createGame(Puzzle $puzzleObj, Student $studentObj, array $data): Game
    {
        $gameObj = new Game();
        $gameObj->setPuzzle($puzzleObj)
            ->setStudent($studentObj)
            ->setScore(NULL)
            ->setRemainingString($puzzleObj->getPuzzleString())
            ->setCreatedAt(new \DateTime())
            ->setIsDone(0);
        $this->getEntityManager()->persist($gameObj);
        $this->getEntityManager()->flush();

        return $gameObj;
    }

    /**
     * Updates remaining string in game entity
     *
     * @param Game $gameObj
     * @param string $remainingString
     *
     * @return string
     */
    public function updateRemainingString(Game $gameObj, string $remainingString): string
    {
        $gameObj->setRemainingString($remainingString);
        $this->getEntityManager()->persist($gameObj);
        $this->getEntityManager()->flush();

        return $remainingString;

    }

    /**
     * Method to calculate and update score
     *
     * @param int $gameId
     *
     * @return float
     */
    public function handleScore(int $gameId)
    {
        $score = $this->calculateScore($gameId) ?? 0;
        return $this->updateScore($gameId, $score);
    }

    /**
     * Calculate score of game
     *
     * @param int $gameId
     * @return float
     */
    public function calculateScore(int $gameId): float
    {
        $query = $this->createQueryBuilder('g');

        return $query->select('SUM(w.score)')
            ->innerJoin(Words::class, 'w', 'WITH', 'w.game = g.id')
            ->where('g.id = :gameId')
            ->andWhere('g.isDone = :isDone')
            ->andWhere('w.isValid = :valid')
            ->setParameters(
                new ArrayCollection([
                    new Parameter('gameId', $gameId),
                    new Parameter('isDone', 1),
                    new Parameter('valid', 1),
                ])
            )
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Update score of game
     *
     * @param int $gameId
     * @param float $score
     *
     * @return float
     */
    public function updateScore(int $gameId, float $score): float
    {
        $qry = $this->createQueryBuilder('g');
        $qry->update(Game::class, 'g')
            ->set('g.score', ':score')
            ->where('g.id = :gameId')
            ->setParameters(
                new ArrayCollection([
                    new Parameter('gameId', $gameId),
                    new Parameter('score', $score),
                ])
            )
            ->getQuery()
            ->execute();

        return $score;
    }

    /**
     * Method to mark game completed
     *
     * @param int $gameId
     *
     * @return bool
     */
    public function setCompleted(int $gameId): bool
    {
        $gameObj = $this->find($gameId);
        $gameObj->setIsDone(1);
        $this->getEntityManager()->persist($gameObj);
        $this->getEntityManager()->flush();

        return true;
    }
}
