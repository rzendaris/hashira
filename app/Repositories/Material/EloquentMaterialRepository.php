<?php

namespace App\Repositories\Material;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Traits\Upload;
use App\Models\Material;
use App\Http\Requests\MaterialRequest;
use App\Http\Requests\MaterialUpdateRequest;

class EloquentMaterialRepository implements MaterialRepository
{
    use Upload;

    public function fetchMaterial()
    {
        $query_builder = Material::with(['batch'])->where('status', 1);
        return $query_builder;
    }

    public function fetchMaterialByUser($user_id)
    {
        $material = $this->fetchMaterial()->where('user_id', $user_id)->whereDate('created_at', Carbon::today())->first();
        return $material;
    }

    public function fetchMaterialByUserBatch($user_id)
    {
        $material = $this->fetchMaterial()->where('user_id', $user_id)->whereRelation('batch', 'start_date', '<=', Carbon::now())->whereRelation('batch', 'end_date', '>=', Carbon::now());
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

    public function updateMaterial(MaterialUpdateRequest $request)
    {
        $material = $this->fetchMaterial()->where('id', $request->material_id)->first();
        $material->name = $request->name;
        $material->task = $request->task;
        $material->note = $request->note;
        $material->save();
        return $material;
    }
}