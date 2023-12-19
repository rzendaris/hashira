<?php

namespace App\Repositories\Material;
use App\Http\Requests\MaterialRequest;
use App\Http\Requests\MaterialUpdateRequest;

interface MaterialRepository {
    public function fetchMaterial();
    public function fetchMaterialByUser($user_id);
    public function insertMaterial(MaterialRequest $request);
    public function updateMaterial(MaterialUpdateRequest $request);
}
