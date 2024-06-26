<?php

namespace App\Http\Controllers\CMS;

use Auth;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Repositories\Student\EloquentStudentRepository;
use App\Repositories\Student\EloquentPotentialStudentRepository;
use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Repositories\User\EloquentUserRepository;
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
        EloquentUserRepository $userRepository,
        EloquentPotentialStudentRepository $potentialStudentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->locationRepository = $locationRepository;
        $this->batchRepository = $batchRepository;
        $this->potentialStudentRepository = $potentialStudentRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): View
    {
        $students = $this->studentRepository->fetchStudent();
        $locations = $this->locationRepository->fetchLocation();
        $batchs = $this->batchRepository->fetchBatch();
        $teachers = $this->userRepository->fetchTeacher();

        if(Auth::user()->role_id == 4){
            $students = $students->where('teacher_id', Auth::user()->id);
        } else if (Auth::user()->role_id == 5) {
            $students = $students->where('location_id', Auth::user()->location_id);
        }

        if($request->batch_filter){
            $students = $students->where('batch_id', $request->batch_filter);
        }
        if($request->location_id){
            $students = $students->where('location_id', $request->location_id);
        }
        if($request->teacher_id){
            $students = $students->where('teacher_id', $request->teacher_id);
        }

        $data = array(
            "students" => $students->get(),
            "locations" => $locations,
            "batchs" => $batchs,
            "teachers" => $teachers
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

    public function detailReport($id): View
    {
        $student = $this->studentRepository->fetchStudentById($id);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($student->batch->start_date, $interval, $student->batch->end_date);
        $date_range = [];

        foreach ($period as $dt) {
            $period_date = $dt->format("Y-m-d");
            $report = [];
            foreach($student->report as $student_report){
                if(Carbon::parse($student_report->created_at)->format('Y-m-d') === $period_date){
                    $report = $student_report;
                }
            }
            $data = array(
                "date" => $period_date,
                "report" => $report
            );
            $date_range[] = $data;
        }
        $data = array(
            "student" => $student,
            "date_range" => $date_range
        );
        return view('menu.students.student-detail-report')->with('data', $data);
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
