<?php

declare(strict_types=1);

namespace Book\Infrastructure\Symfony\Controller;

use Book\Application\Command\CreateBookCommand;
use Book\Application\Command\CreateBookCommandHandler;
use Book\Application\Command\DeleteBookCommand;
use Book\Application\Command\DeleteBookCommandHandler;
use Book\Application\Command\UpdateBookCommand;
use Book\Application\Command\UpdateBookCommandHandler;
use Book\Application\Query\GetBookQuery;
use Book\Application\Query\GetBookQueryHandler;
use Book\Application\Query\GetBooksQuery;
use Book\Application\Query\GetBooksQueryHandler;
use Book\Domain\BookNotFound;
use Book\Domain\InvalidBook;
use Book\Infrastructure\Symfony\Normalizer\BookNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController
{
    private BookNormalizer $bookNormalizer;
    private GetBookQueryHandler $bookQueryHandler;
    private GetBooksQueryHandler $booksQueryHandler;
    private CreateBookCommandHandler $createBookCommandHandler;
    private UpdateBookCommandHandler $updateBookCommandHandler;
    private DeleteBookCommandHandler $deleteBookCommandHandler;

    public function __construct(
        BookNormalizer $bookNormalizer,
        GetBookQueryHandler $bookQueryHandler,
        GetBooksQueryHandler $booksQueryHandler,
        CreateBookCommandHandler $createBookCommandHandler,
        UpdateBookCommandHandler $updateBookCommandHandler,
        DeleteBookCommandHandler $deleteBookCommandHandler
    ) {
        $this->bookNormalizer = $bookNormalizer;
        $this->bookQueryHandler = $bookQueryHandler;
        $this->booksQueryHandler = $booksQueryHandler;
        $this->createBookCommandHandler = $createBookCommandHandler;
        $this->updateBookCommandHandler = $updateBookCommandHandler;
        $this->deleteBookCommandHandler = $deleteBookCommandHandler;
    }

    public function getBook(string $isbn): JsonResponse
    {
        $bookQuery = new GetBookQuery($isbn);

        $this->validateObject($bookQuery);

        try {
            $book = $this->bookQueryHandler->handle($bookQuery);
        } catch (BookNotFound $e) {
            throw new NotFoundHttpException('Book not found');
        }

        return new JsonResponse($this->bookNormalizer->normalize($book));
    }

    public function getBooks(Request $request): JsonResponse
    {
        $booksQuery = new GetBooksQuery(
            $request->request->get('title'),
            $request->request->get('author'),
            $request->request->getInt('page', GetBooksQuery::GET_BOOKS_FIRST_PAGE),
            $request->request->getInt('limit', GetBooksQuery::GET_BOOKS_DEFAULT_LIMIT)
        );

        $this->validateObject($booksQuery);

        return new JsonResponse(
            $this->bookNormalizer->normalizeList(
                $this->booksQueryHandler->handle($booksQuery)
            )
        );
    }

    public function createBook(Request $request): JsonResponse
    {
        // Trick to add payload content to the request bag
        $request->request->add(\json_decode((string) $request->getContent(), true));

        $bookCommand = new CreateBookCommand($request->request->get('isbn', ''));

        $this->validateObject($bookCommand);

        try {
            $book = $this->createBookCommandHandler->handle($bookCommand);
        } catch (InvalidBook | BookNotFound $e) {
            throw new BadRequestHttpException($e->getMessage());
        } catch (\Throwable $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, 'Cannot save book');
        }

        return new JsonResponse($this->bookNormalizer->normalize($book));
    }

    public function updateBook(Request $request, string $isbn): JsonResponse
    {
        // Trick to add payload content to the request bag
        $request->request->add(\json_decode((string) $request->getContent(), true));

        $bookCommand = new UpdateBookCommand($isbn, $request->request->get('title', ''), $request->request->get('summary', ''));

        $this->validateObject($bookCommand);

        $this->updateBookCommandHandler->handle($bookCommand);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteBook(string $isbn): JsonResponse
    {
        $this->deleteBookCommandHandler->handle(new DeleteBookCommand($isbn));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function validateObject(object $object): void
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors);
        }
    }
}
