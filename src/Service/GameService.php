<?php

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Game;
use App\Entity\Puzzle;
use App\Entity\Student;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\WordValidationMessage;
class GameService
{

    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface    $bus,
        private string                 $projectDir
    )
    {

    }

    /**
     * Initiates game and return remaining string in puzzle
     *
     * @param int $puzzleId
     * @param array $data
     *
     * @return
     */
    public function initiate(int $puzzleId, array $data)
    {
        $err = [];
        $studentObj = $this->checkStudent($data['username']);
        $puzzleObj = $this->em->getRepository(Puzzle::class)->find($puzzleId);
        $gameObj = $this->em->getRepository(Game::class)
            ->findOneBy(['student' => $studentObj, 'puzzle' => $puzzleObj]);
        if ($gameObj && $gameObj->getIsDone() == 1) {
            return ['error' => 'This puzzle has already completed!!!'];
        }
        if (!isset($data['gameId']) && !$gameObj) {
            $data['remainingString'] = $puzzleObj->getPuzzleString();
            $gameObj = $this->startGame($puzzleObj, $studentObj, $data);
        }
        foreach (str_split($data['word']) as $letter) {
            $index = array_search($letter, str_split($gameObj->getRemainingString()));
            if ($index === false) {
                $err[$letter] = $letter;
            }
        }
        if (count($err) > 0) {
            return ['error' => implode(',', array_values($err)) . ' not present in remaining string'];
        }
        $this->bus->dispatch(new WordValidationMessage($gameObj->getId(), $data['word']));
        $remainingString = $this->buildAndUpdateRemainingString($gameObj, $data['word']);
        return ["gameId" => $gameObj->getId(), "remainingString" => $remainingString];
    }

    /**
     * Mark game completed
     *
     * @param int $gameId
     *
     * @return bool
     */
    public function markCompleted(int $gameId): bool
    {
        return $this->em->getRepository(Game::class)->setCompleted($gameId);
    }

    /**
     * Start game if new student submit word in a puzzle
     *
     * @param Puzzle $puzzleObj
     * @param Student $studentObj
     * @param array $data
     *
     * @return Game
     */
    private function startGame(Puzzle $puzzleObj, Student $studentObj, array $data): Game
    {
        return $this->em->getRepository(Game::class)->createGame($puzzleObj, $studentObj, $data);
    }

    /**
     * Check any student exists with name, if not create new student
     *
     * @param string $username
     *
     * @return Student|object|null
     */
    private function checkStudent(string $username)
    {
        $studentObj = $this->em->getRepository(Student::class)
            ->findOneBy(['name' => $username]);
        if (!$studentObj) {
            $studentObj = $this->em->getRepository(Student::class)->createStudent($username);
        }
        return $studentObj;
    }

    /**
     * Builds remaining string to return on submission
     *
     * @param string $remainingString
     * @param string $word
     *
     * @return string|string[]
     */
    private function buildRemainingString(string $remainingString, string $word)
    {
        $remainingStringArray = str_split($remainingString); // Convert $remainingString into array of characters

        foreach (str_split($word) as $charToRemove) {
            $index = array_search($charToRemove, $remainingStringArray);

            if ($index !== false) {
                unset($remainingStringArray[$index]); // Remove only first matching character
            } else {
                return ['error' => $charToRemove . ' not present in remaining string'];
            }
        }
        $resultantString = implode('', $remainingStringArray); // Convert array back to string
        return $resultantString;
    }

    /**
     * Build and updates remaining string in game entity
     *
     * @param Game $gameObj
     * @param string $word
     * @return void
     */
    private function buildAndUpdateRemainingString(Game $gameObj, string $word)
    {
        $remainingString = $gameObj->getRemainingString() ?? '';
        if ($remainingString == '') {
            return;
        }
        $remainingString = $this->buildRemainingString($remainingString, $word);
        if (is_string($remainingString)) {
            return $this->updateRemainingString($gameObj, $remainingString);

        }
        return $remainingString;
    }

    /**
     * Updates remaining string to DB
     *
     * @param Game $gameObj
     * @param string $remainingString
     *
     * @return mixed
     */
    private function updateRemainingString(Game $gameObj, string $remainingString)
    {
        return $this->em->getRepository(Game::class)->updateRemainingString($gameObj, $remainingString);
    }
}