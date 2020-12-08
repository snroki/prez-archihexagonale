<?php

declare(strict_types=1);

namespace Book\Domain;

class GoodReadsBook
{
    private string $isbn;
    private string $title;
    private string $summary;
    private string $authorFirstname;
    private string $authorLastname;

    public function __construct(string $isbn, string $title, string $summary, string $authorFirstname, string $authorLastname)
    {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->summary = $summary;
        $this->authorFirstname = $authorFirstname;
        $this->authorLastname = $authorLastname;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getAuthorFirstname(): string
    {
        return $this->authorFirstname;
    }

    public function getAuthorLastname(): string
    {
        return $this->authorLastname;
    }
}
