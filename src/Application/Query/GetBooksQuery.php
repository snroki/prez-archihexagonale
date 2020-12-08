<?php

declare(strict_types=1);

namespace Book\Application\Query;

class GetBooksQuery
{
    public const GET_BOOKS_FIRST_PAGE = 1;
    public const GET_BOOKS_DEFAULT_LIMIT = 10;

    private ?string $title;
    private ?string $author;

    /**
     * @Assert\Positive
     */
    private int $page;

    /**
     * @Assert\Positive
     */
    private int $limit;

    public function __construct(?string $title, ?string $author, ?int $page, ?int $limit)
    {
        $this->title = $title;
        $this->author = $author;
        $this->page = $page ? $page : self::GET_BOOKS_FIRST_PAGE;
        $this->limit = $limit ? $limit : self::GET_BOOKS_DEFAULT_LIMIT;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getOffset(): ?int
    {
        if (1 === $this->page) {
            return 0;
        }

        return $this->page * $this->limit;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
