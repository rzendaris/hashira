<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Student\EloquentStudentRepository;
use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $locationRepository;
    protected $batchRepository;

    public function __construct(
        EloquentStudentRepository $studentRepository,
        EloquentLocationRepository $locationRepository,
        EloquentBatchRepository $batchRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->locationRepository = $locationRepository;
        $this->batchRepository = $batchRepository;
    }

    public function index(): View
    {
        $students = $this->studentRepository->fetchStudent()->get();
        $locations = $this->locationRepository->fetchLocation();
        $batchs = $this->batchRepository->fetchBatch();

        $data = array(
            "students" => $students,
            "locations" => $locations,
            "batchs" => $batchs
        );
        return view('menu.students.student')->with('data', $data);
    }

    public function detail($id): View
    {
        $student = $this->studentRepository->fetchStudentById($id);
        $data = array(
            "student" => $student
        );
        return view('menu.students.student-detail')->with('data', $data);
    }

    public function detailInstallment($id): View
    {
        $student = $this->studentRepository->fetchStudentById($id);
        $data = array(
            "student" => $student
        );
        return view('menu.students.student-detail-installment')->with('data', $data);
    }

    public function create(StudentRequest $request): RedirectResponse
    {
        $this->studentRepository->insertStudent($request);
        return redirect()->route('student-view');
    }

    public function update(StudentUpdateRequest $request): RedirectResponse
    {
        $this->studentRepository->updateStudent($request);
        return redirect()->route('student-view');
    }

    public function delete(StudentUpdateRequest $request): RedirectResponse
    {
        $this->studentRepository->deleteStudent($request->id);
        return redirect()->route('student-view');
    }

    public function potentialStudent(): View
    {
        $students = $this->studentRepository->fetchStudent()->get();
        $data = array(
            "students" => $students
        );
        return view('menu.students.potential-student')->with('data', $data);
    }
}
