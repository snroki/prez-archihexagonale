<?php

declare(strict_types=1);

namespace Book\Application\Command;

use Book\Domain\Author;
use Book\Domain\Book;
use Book\Domain\BookRepository;
use Book\Domain\InvalidBook;
use Book\Infrastructure\GoodReadsGuzzleRepository;

class UpdateBookCommandHandler
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(UpdateBookCommand $bookCommand): Book
    {
        $book = $this->bookRepository->getBook($bookCommand->getIsbn());

        $book->update($bookCommand->getTitle(), $bookCommand->getSummary());

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            throw new InvalidBook($errors);
        }

        return $this->bookRepository->saveBook($book->update());
    }
}
