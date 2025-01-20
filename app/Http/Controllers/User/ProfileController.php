<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\DTO\LocationDTO;
use App\Http\Requests\addLocationInProfileRequest;
use App\Http\Requests\updateLocationInProfileRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserResource;
use App\Http\Services\LocationService;
use App\Models\Location;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __construct(protected LocationService $locationService)
    {
    }

    /**
     * @throws AuthorizationException
     */
    public function getAuthUserProfile(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            throw new AuthorizationException();
        }
        $locations = $user->locations()->where('deleted', false)->get();

        return response()->json(
            [
            'user' => new UserResource($user),
            'locations' => LocationResource::collection($locations),
            ]
        )->setStatusCode(Response::HTTP_OK);

    }


    /**
     * @throws AuthorizationException
     */
    public function addLocationInProfile(addLocationInProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            throw new AuthorizationException();
        }

        $locationFromRequest = new LocationDTO(
            user_id: $user->id,
            city: $request->validated()['city'],
            street: $request->validated()['street'],
            house_number: $request->validated()['house_number'],
            floor: $request->validated()['floor'],
            apartment: $request->validated()['apartment'],
        );

        $location = $this->locationService->createLocation($locationFromRequest);
        return (new LocationResource($location))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateAuthUserLocation(updateLocationInProfileRequest $request, int $id): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            throw new AuthorizationException();
        }
        $location = Location::query()->findOrFail($id);

        $this->authorize('update', $location);

        $locationFromRequest = new LocationDTO(
            user_id: $user->id,
            city: $request->validated()['city'],
            street: $request->validated()['street'],
            house_number: $request->validated()['house_number'],
            floor: $request->validated()['floor'],
            apartment: $request->validated()['apartment'],
            deleted: $request->validated()['deleted'] ?? false
        );

        $updatedLocation = $this->locationService->updateLocation($location, $locationFromRequest);
        return (new LocationResource($updatedLocation))->response()->setStatusCode(Response::HTTP_OK);

    }
}
