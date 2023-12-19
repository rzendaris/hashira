<?php

namespace App\Http\Controllers\CMS;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Student\EloquentStudentRepository;
use App\Repositories\Student\EloquentPotentialStudentRepository;
use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Requests\PotentialStudentRequest;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $locationRepository;
    protected $batchRepository;
    protected $potentialStudentRepository;

    public function __construct(
        EloquentStudentRepository $studentRepository,
        EloquentLocationRepository $locationRepository,
        EloquentBatchRepository $batchRepository,
        EloquentPotentialStudentRepository $potentialStudentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->locationRepository = $locationRepository;
        $this->batchRepository = $batchRepository;
        $this->potentialStudentRepository = $potentialStudentRepository;
    }

    public function index(): View
    {
        $students = $this->studentRepository->fetchStudent();
        if(Auth::user()->role_id == 4 || Auth::user()->role_id == 5){
            $students = $students->where('location_id', Auth::user()->location_id)->get();
        } else {
            $students = $students->get();
        }
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
        $students = $this->potentialStudentRepository->fetchPotentialStudent()->get();
        $data = array(
            "students" => $students
        );
        return view('menu.students.potential-student')->with('data', $data);
    }

    public function potentialStudentCreate(PotentialStudentRequest $request): RedirectResponse
    {
        $this->potentialStudentRepository->insertPotentialStudent($request);
        return redirect()->route('potential-student-view');
    }
}
