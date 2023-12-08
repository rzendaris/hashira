<?php

namespace App\Repositories\Material;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Traits\Upload;
use App\Models\Material;
use App\Http\Requests\MaterialRequest;

class EloquentMaterialRepository implements MaterialRepository
{
    use Upload;

    public function fetchMaterial()
    {
        $query_builder = Material::where('status', 1);
        return $query_builder;
    }

    public function fetchMaterialByUser($user_id)
    {
        $material = $this->fetchMaterial()->where('user_id', $user_id)->whereDate('created_at', Carbon::today())->first();
        return $material;
    }

    public function insertMaterial(MaterialRequest $request)
    {
        $material = new Material();
        $material->name = $request->name;
        $material->task = $request->task;
        $material->note = $request->note;
        $material->batch_id = $request->batch_id;
        $material->location_id = Auth::user()->location_id;
        $material->user_id = Auth::user()->id;
        $material->save();
        return $material;
    }
}