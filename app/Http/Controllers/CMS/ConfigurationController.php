<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\StudentUpdateRequest;

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

    // public function create(StudentRequest $request): RedirectResponse
    // {
    //     $this->studentRepository->insertStudent($request);
    //     return redirect()->route('student-view');
    // }

    // public function update(StudentUpdateRequest $request): RedirectResponse
    // {
    //     $this->studentRepository->updateStudent($request);
    //     return redirect()->route('student-view');
    // }

    // public function delete(StudentUpdateRequest $request): RedirectResponse
    // {
    //     $this->studentRepository->deleteStudent($request->id);
    //     return redirect()->route('student-view');
    // }
}
