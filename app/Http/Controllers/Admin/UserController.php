<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Получить список всех пользователей.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Получить конкретного пользователя по ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Создать нового пользователя.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::query()->create($validatedData);

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Обновить данные пользователя по ID.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        $validatedData = $request->validated();

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
        $user->update($validatedData);

        return response()->json($user,Response::HTTP_OK);
    }

    /**
     * Удалить пользователя по ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        $user->delete();

        return response()->json("User successfully deleted",Response::HTTP_OK );
    }
}
