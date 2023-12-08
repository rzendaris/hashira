<?php

namespace App\Repositories\Material;
use App\Http\Requests\MaterialRequest;

interface MaterialRepository {
    public function fetchMaterial();
    public function fetchMaterialByUser($user_id);
    public function insertMaterial(MaterialRequest $request);
}
