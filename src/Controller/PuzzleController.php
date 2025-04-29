<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\{ JsonResponse, Request };
use App\Service\{ PuzzleService, GameService };

class PuzzleController extends AbstractController
{
    /**
     * Constructor
     *
     * @param PuzzleService $puzzleService
     * @param GameService $gameService
     */
    public function __construct(
        private PuzzleService $puzzleService,
        private GameService   $gameService,
    )
    {

    }

    /**
     * Api method to start puzzle
     *
     * @return JsonResponse
     */
    #[Route('/api/puzzle/start', name: 'start_puzzle')]
    public function startPuzzle(): JsonResponse
    {
        $response = $this->puzzleService->fetchPuzzles();
        $response['message'] = 'Puzzle started!';
        return new JsonResponse($response);
    }

    /**
     * Method to submit puzzle words
     *
     * @param int $puzzleId
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/api/puzzle/{puzzleId}/submit', name: 'submit_words')]
    public function submitWords(int $puzzleId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['word']) || empty($data['username'])) {
            return new JsonResponse(
                ['error' => 'username, word are required'],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $result = $this->gameService->initiate($puzzleId, $data);
        if (isset($result['error'])) {
            return new JsonResponse(['error' => $result['error']], JsonResponse::HTTP_BAD_REQUEST);
        }
        if ($result['remainingString'] === '') {
            $score = $this->puzzleService->completeGame($result);
            return new JsonResponse(['score' => $score], JsonResponse::HTTP_CREATED);
        }

        return new JsonResponse(['remainingString' => $result['remainingString']], JsonResponse::HTTP_CREATED);
    }

    /**
     * Method to stop puzzle
     *
     * @param int $gameId
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/api/puzzle/{gameId}/stop', name: 'stop_puzzle')]
    public function stopPuzzle(
        int     $gameId,
        Request $request
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $data['gameId'] = $gameId;
        $score = $this->puzzleService->completeGame($data);
        return new JsonResponse(['score' => $score], JsonResponse::HTTP_CREATED);
    }
}
