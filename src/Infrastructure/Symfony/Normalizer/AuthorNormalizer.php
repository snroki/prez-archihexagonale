<?php

declare(strict_types=1);

namespace Book\Infrastructure\Symfony\Normalizer;

use Book\Domain\Author;

class AuthorNormalizer
{
    public function normalize(Author $author): array
    {
        return [
            'firstname' => $author->getFirstname(),
            'lastname' => $author->getLastname(),
        ];
    }
}
