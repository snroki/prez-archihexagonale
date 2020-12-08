<?php

declare(strict_types=1);

namespace Book\Infrastructure;

use Book\Domain\BookNotFound;
use Book\Domain\GoodReadsBook;
use Book\Domain\GoodReadsRepository as GoodReadsRepositoryInterface;

class GoodReadsGuzzleRepository implements GoodReadsRepositoryInterface
{
    public function getBookFromIsbn(string $isbn): GoodReadsBook
    {
        try {
            $response = $this->guzzle->get('/books/' . $isbn);
        } catch (RequestException) {
            throw new BookNotFound();
        }

        return $this->denormalize(\json_decode($response->getContent()->getBody(), true));
    }

    private function denormalize(array $rawBook): GoodReadsBook
    {
        return new GoodReadsBook(
            $rawBook['isbn'],
            $rawBook['title'],
            $rawBook['summary'],
            $rawBook['author']['firstname'],
            $rawBook['author']['lastname']
        );
    }
}
