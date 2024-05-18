<?php

namespace App\Repositories\Batch;
use App\Http\Requests\BatchRequest;
use App\Http\Requests\BatchUpdateRequest;

interface BatchRepository {
    public function fetchBatch();
    public function fetchActiveBatch();
    public function insertBatch(BatchRequest $request);
    public function updateBatch(BatchUpdateRequest $request);
}
