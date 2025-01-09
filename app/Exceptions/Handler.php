<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
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
    public function render($request, \Throwable $exception): Response
    {
        $response = [
            'error' => 'Что-то пошло не так.',
            'message' => $exception->getMessage(),
            'code' => $exception->getCode()
        ];

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response['errors'] = $exception->errors();
            $response['message'] = 'Ошибка валидации';
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $response['message'] = 'Ресурс не найден';
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $exception->getStatusCode();
            $response['message'] = $exception->getMessage();
        } elseif ($exception instanceof CartLimitException) {
            $response['message'] = $exception->getMessage();
            $statusCode = Response::HTTP_BAD_REQUEST;
        } elseif ($exception instanceof WrongPriceCategoryException) {
            $response['message'] = $exception->getMessage();
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return response()->json($response, $statusCode);

    }
}
