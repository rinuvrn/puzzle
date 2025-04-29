<?php

namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use App\Service\GameService;
class GameServiceTest extends TestCase
{
    public function testInitiate()
    {
        $gameService = new GameService();

        $this->assertSame(["gameId" => 1, "remainingString" => "amrugocomeintowaitherecheckyou"], $gameService->initiate(1, ["username"=>"user1", "word"=>"in"]));
        $this->assertSame(["gameId" => 1, "remainingString" => "rugocomeintowaitherecheckyou"], $gameService->initiate(1, ["username"=>"user1", "word"=>"am"]));
        $this->assertSame(["gameId" => 1, "remainingString" => "rucomeintowaitherecheckyou"], $gameService->initiate(1, ["username"=>"user1", "word"=>"go"]));
        $this->assertSame(["gameId" => 1, "remainingString" => "ruintowaitherecheckyou"], $gameService->initiate(1, ["username"=>"user1", "word"=>"come"]));

    }
}