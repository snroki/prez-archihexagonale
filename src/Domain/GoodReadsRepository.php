<?php

declare(strict_types=1);

namespace Book\Domain;

interface GoodReadsRepository
{
    public function getBookFromIsbn(string $isbn): GoodReadsBook;
}
