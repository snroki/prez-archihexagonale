<?php

declare(strict_types=1);

namespace Book\Domain;

use Book\Application\Query\GetBooksQuery;

interface BookRepository
{
    public function getBook(string $isbn): Book;

    /**
     * @param GetBooksQuery $booksQuery
     *
     * @return Book[]
     */
    public function getBooks(GetBooksQuery $booksQuery): array;

    public function saveBook(Book $book): Book;

    public function deleteBook(Book $book): void;
}
