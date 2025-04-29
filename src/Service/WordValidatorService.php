<?php

namespace App\Service;
use ApiPlatform\ApiResource\Error;
use http\Exception\RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Words;
class WordValidatorService
{
    private const DICTIONARY_API_URL = 'https://api.dictionaryapi.dev/api/v2/entries/en/';
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager
    )
    {

    }
    public function init(int $gameId, string $word)
    {
        try {
            $isValid = $this->doValidate($gameId, $word);
            $this->addWord($gameId, $word, $isValid);
        }catch (\Throwable $e)
        {
             throw new RuntimeException('Word validation failed');
        }
        return true;
    }
    private function doValidate(int $gameId, string $word): bool
    {
        return $this->isValidEnglishWord($word);
    }

    /**
     * Method to validate word submitted
     *
     * @param string $word
     *
     * @return bool
     * @throws Error
     */
    private function isValidEnglishWord(string $word): bool
    {
        $word = strtolower(trim($word));

        if (empty($word)) {
            return false;
        }
        try {
            $response = $this->client->request('GET', self::DICTIONARY_API_URL . $word);

            if ($response->getStatusCode() === 200) {
                return true;
            }
        } catch (\Throwable $ex) {
            throw new Error('Word validation with API failed');
        }
        return false;
    }

    /**
     * Method to add word
     *
     * @param int $gameId
     * @param string $word
     * @param bool $isValid
     * @return bool
     * @throws RuntimeException
     */
    private function addWord(int $gameId, string $word, bool $isValid) : bool
    {
        try {
            $this->entityManager->getRepository(Words::class)
                ->createWord($gameId, $word, $isValid);
        }catch(\Throwable $ex)
        {
            throw new RuntimeException('DB entry of word failed');
        }
        return true;
    }
}