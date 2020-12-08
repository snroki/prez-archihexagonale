<?php

declare(strict_types=1);

namespace Book\Application\Command;

use Book\Domain\Author;
use Book\Domain\Book;
use Book\Domain\BookRepository;
use Book\Domain\InvalidBook;
use Book\Domain\GoodReadsRepository;

class CreateBookCommandHandler
{
    private BookRepository $bookRepository;
    private GoodReadsRepository $goodReadsRepository;

    public function __construct(BookRepository $bookRepository, GoodReadsRepository $goodReadsRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->goodReadsRepository = $goodReadsRepository;
    }

    public function handle(CreateBookCommand $bookCommand): Book
    {
        $goodReadBook = $this->goodReadsRepository->getBookFromIsbn($bookCommand->getIsbn());

        $book = new Book(
            $goodReadBook->getIsbn(),
            new Author($goodReadBook->getAuthorFirstname(), $goodReadBook->getAuthorLastname()),
            $goodReadBook->getTitle(),
            $goodReadBook->getSummary()
        );

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            throw new InvalidBook($errors);
        }

        return $this->bookRepository->saveBook($book);
    }
}
