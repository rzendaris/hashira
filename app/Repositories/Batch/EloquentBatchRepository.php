<?php

namespace App\Repositories\Batch;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Batch;
use App\Http\Requests\BatchRequest;

class EloquentBatchRepository implements BatchRepository
{

    public function fetchBatch()
    {
        $batchs = Batch::get();
        return $batchs;
    }

    public function fetchActiveBatch()
    {
        $query_builder = Batch::whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today());
        return $query_builder;
    }

    public function insertBatch(BatchRequest $request)
    {
        $batch = new Batch();
        $batch->name = $request->name;
        $batch->start_date = $request->start_date;
        $batch->end_date = $request->end_date;
        $batch->save();
        return $batch;
    }
}