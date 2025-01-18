<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function render($request, \Throwable $e): Response
    {
        $response = [
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => $e->getMessage(),
        ];

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response['errors'] = $e->errors();
        }
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthenticated.';
        } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException || $e instanceof ModelNotFoundException) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $response['message'] = 'Not Found';
        } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException || $e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $statusCode = Response::HTTP_FORBIDDEN;
            $response['message'] = 'Forbidden';
        } elseif ($e instanceof InvalidArgumentException) {
            $statusCode = Response::HTTP_FORBIDDEN;
            $response['message'] = $e->getMessage();
        } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $e->getStatusCode();
            $response['message'] = $e->getMessage();
        } elseif ($e instanceof CartLimitException) {
            $response['message'] = $e->getMessage();
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($e instanceof WrongPriceCategoryException) {
            $response['message'] = $e->getMessage();
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($e instanceof EmptyCartException) {
            $response['message'] = $e->getMessage();
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return response()->json($response, $statusCode);

    }
}
