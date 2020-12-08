<?php

declare(strict_types=1);

namespace Book\Infrastructure\Symfony\Normalizer;

use Book\Domain\Book;

class BookNormalizer
{
    private AuthorNormalizer $authorNormalizer;

    public function __construct(AuthorNormalizer $authorNormalizer)
    {
        $this->authorNormalizer = $authorNormalizer;
    }

    public function normalize(Book $book): array
    {
        return [
            'isbn' => $book->getIsbn(),
            'title' => $book->getTitle(),
            'summary' => $book->getSummary(),
            'author' => $this->authorNormalizer->normalize($book->getAuthor()),
        ];
    }

    public function normalizeList(array $books): array
    {
        $normalizedBooks = [];
        foreach ($books as $book) {
            $normalizedBooks[] = $this->normalize($book);
        }

        return $normalizedBooks;
    }
}
