<?php

namespace App\Http\Controllers;

use App\Http\Requests\addLocationInProfileRequest;
use App\Http\Requests\updateLocationInProfileRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function getAuthUserProfile(): JsonResponse
    {
        $user = Auth::user();
        $locations = $user->locations;

        return response()->json([
            'locations' => $locations,
            'user' => $user,
        ]);
    }


    public function addLocationInProfile(addLocationInProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        $location = Location::query()->create([$request->validated()]);
        $location->user_id = $user->id;
        $location->save();

        return response()->json([
                'message' => 'Location added.',
                'location' => $location]
        );
    }

    public function updateAuthUserLocation(updateLocationInProfileRequest $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $location = Location::query()->findOrFail($id);
        if ($location->user_id !== $user->id) {
            return response()->json(['messege' => 'У вас нет такой записи'], Response::HTTP_NOT_FOUND);
        }
        $location->update([$request->validated()]);

        return response()->json([
                'message' => 'Location updated.',
                'location' => $location]
        );
    }
    }
