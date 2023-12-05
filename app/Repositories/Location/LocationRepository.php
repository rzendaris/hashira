<?php

namespace App\Repositories\Location;

use App\Http\Requests\LocationRequest;
use App\Http\Requests\LocationUpdateRequest;

interface LocationRepository {
    public function fetchLocation();
    public function insertLocation(LocationRequest $request);
    public function updateLocation(LocationUpdateRequest $request);
}
