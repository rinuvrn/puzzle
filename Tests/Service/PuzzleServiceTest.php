<?php

namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use App\Service\PuzzleService;
class PuzzleServiceTest extends TestCase
{
    public function testFetchPuzzles()
    {
        $puzzleService = new PuzzleService();
        $this->assertSame([
            "id" => 1,
            "puzzleString" => "iamrungocomeintowaitherecheckyou",
            "createdAt" => "2025-04-27T09:07:39+02:00",
            "message" => "Puzzle started!"
        ], $puzzleService->fetchPuzzles());

    }
}