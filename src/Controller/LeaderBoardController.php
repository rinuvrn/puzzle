<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Words;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class LeaderBoardController extends AbstractController
{
    /**
     * Leader board controller
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     */
    #[Route('/api/puzzle/leaderboard', name: 'app_leader_board')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $result = $entityManager->getRepository(Words::class)->findTopTenWords();
        return new JsonResponse(['data' => $result], JsonResponse::HTTP_OK);

    }
}
