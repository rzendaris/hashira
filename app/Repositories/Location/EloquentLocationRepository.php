<?php

namespace App\Repositories\Location;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Location;

class EloquentLocationRepository implements LocationRepository
{

    public function fetchLocation()
    {
        $locations = Location::get();
        return $locations;
    }
}