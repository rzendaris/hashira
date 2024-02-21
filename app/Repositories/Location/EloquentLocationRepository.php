<?php

namespace App\Repositories\Location;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Location;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\LocationUpdateRequest;

class EloquentLocationRepository implements LocationRepository
{

    public function fetchLocationBuilder()
    {
        $query_builder = Location::where('id', '!=', NULL);
        return $query_builder;
    }

    public function fetchLocation()
    {
        $locations = $this->fetchLocationBuilder()->get();
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

    public function updateLocation(LocationUpdateRequest $request)
    {
        $location = Location::where('id', $request->id)->first();
        $location->name = $request->name;
        $location->price = $request->price;
        $location->save();
        return $location;
    }
}