<?php

namespace App\Repositories\Batch;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Batch;
use App\Http\Requests\BatchRequest;
use App\Http\Requests\BatchUpdateRequest;

class EloquentBatchRepository implements BatchRepository
{

    public function fetchBatch()
    {
        $batchs = Batch::get();
        return $batchs;
    }

    public function fetchBatchBuilder()
    {
        $batchs = Batch::whereNotNull('name');
        return $batchs;
    }

    public function fetchActiveBatch()
    {
        $query_builder = Batch::whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today());
        if($query_builder->first() === null){
            $query_builder = $this->fetchBatchBuilder()->orderBy('id', 'DESC');
        }
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

    public function updateBatch(BatchUpdateRequest $request)
    {
        $batch = $this->fetchBatchBuilder()->where('id', $request->id)->first();
        if(isset($batch)){
            $batch->name = $request->name;
            $batch->start_date = $request->start_date;
            $batch->end_date = $request->end_date;
            $batch->save();
        }
        return $batch;
    }
}