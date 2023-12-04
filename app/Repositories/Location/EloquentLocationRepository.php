<?php

namespace App\Repositories\Location;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Location;
use App\Http\Requests\LocationRequest;

class EloquentLocationRepository implements LocationRepository
{

    public function fetchLocation()
    {
        $locations = Location::get();
        return $locations;
    }

    public function insertLocation(LocationRequest $request)
    {
        $location = new Location;
        $location->name = $request->name;
        $location->price = $request->price;
        $location->save();
        return $location;
    }
}