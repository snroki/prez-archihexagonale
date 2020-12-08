<?php

declare(strict_types=1);

namespace Book\Application\Command;

use Book\Domain\BookRepository;

class DeleteBookCommandHandler
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(DeleteBookCommand $bookCommand): void
    {
        $this->bookRepository->deleteBook($this->bookRepository->getBook($bookCommand->getIsbn()));
    }
}
