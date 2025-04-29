<?php

namespace App\Repository;

use App\Entity\Words;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Game;
/**
 * @extends ServiceEntityRepository<Words>
 */
class WordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Words::class);
    }

    /**
     * Method to create word in db
     *
     * @param int $gameId
     * @param string $word
     * @param bool $isValid
     *
     * @return Words
     */
    public function createWord(int $gameId, string $word, bool $isValid)
    {
        $gameObj = $this->getEntityManager()->getRepository(Game::class)->find($gameId);
        $wordsObj = new Words();
        $wordsObj->setGame($gameObj)
            ->setWord($word)
            ->setScore(strlen($word))
            ->setIsValid($isValid)
            ->setCreatedAt(new \DateTime());
        $this->getEntityManager()->persist($wordsObj);
        $this->getEntityManager()->flush();
        return $wordsObj;
    }

    /**
     * Methos to show top ten high scoring words
     *
     * @return mixed
     */
    public function findTopTenWords()
    {
        return $this->createQueryBuilder('w')
            ->select('w.word, MAX(w.score) AS max_score')
            ->where('w.isValid = :isValid')
            ->groupBy('w.word')
            ->orderBy('max_score', 'DESC')
            ->setParameter('isValid', 1)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
