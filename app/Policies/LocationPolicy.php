<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;

class LocationPolicy
{

    public function update(User $user, Location $location){
        return !$location->deleted  && ($user->id === $location->user_id || $user->is_admin);
    }
}
