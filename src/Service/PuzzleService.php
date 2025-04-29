<?php

namespace App\Service;

use App\Entity\Puzzle;
use App\Service\WordValidatorService;
use App\Service\ScoreCalculatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;


class PuzzleService
{
    private const PUZZLE_ID = 1;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface    $serializer,
        private WordValidatorService   $wordValidatorService,
        private ScoreCalculatorService $scoreCalculatorService,
        private GameService            $gameService,

    )
    {

    }

    /**
     * Fetches a puzzle by ID and returns it as serialized array.
     *
     * @return array
     *
     * @throws NotFoundHttpException If the puzzle is not found.
     */
    public function fetchPuzzles(): array
    {
        $puzzleObj = $this->getPuzzlefromDb(self::PUZZLE_ID);
        if (!$puzzleObj) {
            throw new NotFoundHttpException('Puzzle not found');
        }

        return $this->formatPuzzleData($puzzleObj);


    }

    /**
     * Method to complete game
     *
     * @param array $data
     *
     * @return mixed
     */
    public function completeGame(array $data)
    {
        if (!empty($data['word'])) {
            $this->wordValidatorService->init($data['gameId'], $data['word']);
        }
        $this->gameService->markCompleted($data['gameId']);

        return $this->scoreCalculatorService->init($data['gameId']);

    }

    /**
     * Fetches a Puzzle entity by its ID.
     *
     * @param int $puzzleId The ID of the puzzle to retrieve.
     *
     * @return \App\Entity\Puzzle|false Returns the Puzzle object if found, or false if not found.
     */
    private function getPuzzlefromDb(int $puzzleId): Puzzle|false
    {
        return $this->entityManager->getRepository(Puzzle::class)->find($puzzleId) ?? false;
    }

    /**
     * Format puzzle object and return serialised  array
     *
     * @param Puzzle $puzzleObj
     *
     * @return array
     */
    private function formatPuzzleData(Puzzle $puzzleObj): array
    {
        return $this->serializer->normalize($puzzleObj);
    }

}