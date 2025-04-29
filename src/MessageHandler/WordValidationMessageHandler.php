<?php

namespace App\MessageHandler;

use App\Message\WordValidationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Service\WordValidatorService;

#[AsMessageHandler]
class WordValidationMessageHandler
{
    public function __construct(private WordValidatorService $validator)
    {

    }

    public function __invoke(WordValidationMessage $message)
    {
        $data = $message->getData();
        $this->validator->init($data['gameId'], $data['word']);
    }
}