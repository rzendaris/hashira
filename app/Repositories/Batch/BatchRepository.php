<?php

namespace App\Repositories\Batch;
use App\Http\Requests\BatchRequest;

interface BatchRepository {
    public function fetchBatch();
    public function insertBatch(BatchRequest $request);
}
