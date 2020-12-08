<?php

declare(strict_types=1);

namespace Book\Application\Query;

use Book\Domain\Book;
use Book\Domain\BookRepository;

class GetBookQueryHandler
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(GetBookQuery $bookQuery): Book
    {
        return $this->bookRepository->getBook($bookQuery->getIsbn());
    }
}
