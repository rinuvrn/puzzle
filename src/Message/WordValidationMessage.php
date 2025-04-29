<?php

namespace App\Message;

use phpDocumentor\Reflection\Types\Integer;

class WordValidationMessage
{
    private int $gameId;
    private string $word;

    public function __construct(int $gameId, string $word)
    {
        $this->word = $word;
        $this->gameId = $gameId;
    }

    /**
     * Method to fetch data
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            'word' => $this->word,
            'gameId' => $this->gameId
        ];
    }
}