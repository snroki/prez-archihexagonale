<?php

declare(strict_types=1);

namespace Book\Infrastructure;

use Book\Application\Query\GetBooksQuery;
use Book\Domain\Book;
use Book\Domain\BookNotFound;
use Book\Domain\BookRepository as BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function getBook(string $isbn): Book
    {
        $book = $this->doctrine->find($isbn);

        if (null === $book) {
            throw new BookNotFound();
        }

        return $book;
    }

    public function getBooks(GetBooksQuery $booksQuery): array
    {
        return $this->doctrine->findBy([
            'title' => $booksQuery->getTitle(),
            'author.firstname' => $booksQuery->getAuthor(),
            'author.lastname' => $booksQuery->getAuthor(),
            'offset' => $booksQuery->getOffset(),
            'limit' => $booksQuery->getLimit(),
        ]);
    }

    public function saveBook(Book $book): Book
    {
        // Do some saving operation

        return $book;
    }

    public function deleteBook(Book $book): void
    {
        // Doctrine request to delete a book
    }
}
