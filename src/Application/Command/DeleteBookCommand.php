<?php

declare(strict_types=1);

namespace Book\Application\Command;

class DeleteBookCommand
{
    /**
     * @Assert\Isbn
     */
    private string $isbn;

    public function __construct(string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}
