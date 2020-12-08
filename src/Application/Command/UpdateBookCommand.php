<?php

declare(strict_types=1);

namespace Book\Application\Command;

class UpdateBookCommand
{
    /**
     * @Assert\Isbn
     */
    private string $isbn;

    /**
     * @Assert\NotBlank
     */
    private string $title;

    /**
     * @Assert\NotBlank
     */
    private string $summary;

    public function __construct(string $isbn, string $title, string $summary)
    {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->summary = $summary;
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
}
