<?php

declare(strict_types=1);

namespace Book\Application\Query;

use Book\Domain\Book;
use Book\Domain\BookRepository;

class GetBooksQueryHandler
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(GetBooksQuery $booksQuery): array
    {
        return $this->bookRepository->getBooks($booksQuery);
    }
}
