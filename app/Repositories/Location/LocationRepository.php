<?php

namespace App\Repositories\Location;

use App\Http\Requests\LocationRequest;

interface LocationRepository {
    public function fetchLocation();
    public function insertLocation(LocationRequest $request);
}
