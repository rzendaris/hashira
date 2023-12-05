<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Requests\BatchRequest;

class ConfigurationController extends Controller
{
    protected $locationRepository;
    protected $batchRepository;

    public function __construct(
        EloquentLocationRepository $locationRepository,
        EloquentBatchRepository $batchRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->batchRepository = $batchRepository;
    }

    public function indexLocation(): View
    {
        $locations = $this->locationRepository->fetchLocation();

        $data = array(
            "locations" => $locations
        );
        return view('menu.configurations.location')->with('data', $data);
    }

    public function indexBatch(): View
    {
        $batchs = $this->batchRepository->fetchBatch();

        $data = array(
            "batchs" => $batchs
        );
        return view('menu.configurations.batch')->with('data', $data);
    }

    public function createLocation(LocationRequest $request): RedirectResponse
    {
        $this->locationRepository->insertLocation($request);
        return redirect()->route('location-view');
    }

    public function updateLocation(LocationUpdateRequest $request): RedirectResponse
    {
        $this->locationRepository->updateLocation($request);
        return redirect()->route('location-view');
    }

    public function createBatch(BatchRequest $request): RedirectResponse
    {
        $this->batchRepository->insertBatch($request);
        return redirect()->route('batch-view');
    }
}
