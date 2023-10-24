<?php

namespace App\Repositories\Batch;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Batch;

class EloquentBatchRepository implements BatchRepository
{

    public function fetchBatch()
    {
        $batchs = Batch::get();
        return $batchs;
    }
}