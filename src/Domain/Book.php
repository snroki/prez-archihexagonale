<?php

declare(strict_types=1);

namespace Book\Domain;

class Book
{
    /**
     * @Assert\Isbn
     */
    private string $isbn;

    /**
     * @Assert\Valid
     */
    private Author $author;
    private string $title;
    private string $summary;

    public function __construct(string $isbn, Author $author, string $title, string $summary)
    {
        Assert::that($isbn)->string('');

        $this->isbn = $isbn;
        $this->author = $author;
        $this->title = $title;
        $this->summary = $summary;
    }

    public function update(string $title, string $summary): Book
    {
        return new self(
            $this->isbn,
            $this->author,
            $title,
            $summary
        );
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }
}
