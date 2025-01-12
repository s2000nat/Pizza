<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\DTO\LocationDTO;
use App\Http\Requests\addLocationInProfileRequest;
use App\Http\Requests\updateLocationInProfileRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Services\LocationService;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __construct(protected LocationService $locationService)
    {
    }

    public function getAuthUserProfile(): JsonResponse
    {
        $user = Auth::user();
        $locations = $user->locations()->where('deleted', false)->get();

        return response()->json([
            'user' => New UserResource($user),
            'locations' => LocationResource::collection($locations),
        ])->setStatusCode(Response::HTTP_OK);

    }


    public function addLocationInProfile(addLocationInProfileRequest $request): JsonResponse
    {
        $user = Auth::user();

        $locationFromRequest = new LocationDTO(
            city: $request->validated()['city'],
            street: $request->validated()['street'],
            house_number: $request->validated()['house_number'],
            floor: $request->validated()['floor'],
            apartment: $request->validated()['apartment'],
            user_id: $user->id
        );

        $newLocation = $this->locationService->createLocation($locationFromRequest);

        return response()->json([
                'message' => 'Location added.',
                'location' => $newLocation]
        );
    }

    public function updateAuthUserLocation(updateLocationInProfileRequest $request, int $id): JsonResponse
    {
        $user = Auth::user();

        $location = Location::query()->findOrFail($id);

        $this->authorize('update', $location);

        $locationFromRequest = new LocationDTO(
            city: $request->validated()['city'],
            street: $request->validated()['street'],
            house_number: $request->validated()['house_number'],
            floor: $request->validated()['floor'],
            apartment: $request->validated()['apartment'],
            user_id: $user->id,
            deleted: $request->validated()['deleted']
        );

        $updatedLocation = $this->locationService->updateLocation($location, $locationFromRequest);
        return (new LocationResource($updatedLocation))->response()->setStatusCode(Response::HTTP_OK);

    }
}
