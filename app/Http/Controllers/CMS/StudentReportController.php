<?php

namespace App\Http\Controllers\CMS;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\StudentReportExcel;
use App\Http\Requests\MaterialRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Http\Requests\StudentReportRequest;
use App\Repositories\Material\EloquentMaterialRepository;
use App\Repositories\Report\EloquentStudentReportRepository;
use App\Repositories\Student\EloquentStudentRepository;
use App\Repositories\Batch\EloquentBatchRepository;

class StudentReportController extends Controller
{
    protected $studentReportRepository;
    protected $materialRepository;
    protected $studentRepository;
    protected $batchRepository;

    public function __construct(
        EloquentStudentReportRepository $studentReportRepository,
        EloquentMaterialRepository $materialRepository,
        EloquentStudentRepository $studentRepository,
        EloquentBatchRepository $batchRepository
    ) {
        $this->studentReportRepository = $studentReportRepository;
        $this->materialRepository = $materialRepository;
        $this->studentRepository = $studentRepository;
        $this->batchRepository = $batchRepository;
    }

    public function index(): View
    {
        $batch = $this->batchRepository->fetchActiveBatch()->first();
        $students = $this->studentRepository->fetchStudent()
        ->where('batch_id', $batch->id)
        ->where('location_id', Auth::user()->location_id)
        ->whereRelation('batch', 'start_date', '<=', Carbon::now())->whereRelation('batch', 'end_date', '>=', Carbon::now())->get();
        $material = $this->materialRepository->fetchMaterialByUser(Auth::user()->id);

        foreach($students as $student){
            $student->score = "-";
            if(isset($material)){
                $student_score = $this->studentReportRepository->fetchStudentReport()->where('student_id', $student->id)->where('material_id', $material->id)->first();
                if(isset($student_score)){
                    $student->score = $student_score->score;
                }
            }
        }
        $data = array(
            "students" => $students,
            "batch" => $batch,
            "material" => $material
        );
        return view('menu.students-report.student')->with('data', $data);
    }

    public function create(MaterialRequest $request): RedirectResponse
    {
        $this->materialRepository->insertMaterial($request);
        return redirect()->route('student-report-view');
    }

    public function update(MaterialUpdateRequest $request): RedirectResponse
    {
        $this->materialRepository->updateMaterial($request);
        return redirect()->route('student-report-view');
    }

    public function createReportScore(StudentReportRequest $request): RedirectResponse
    {
        $this->studentReportRepository->insertStudentReport($request);
        return redirect()->route('student-report-view');
    }

    public function download()
    {
        $batch = $this->batchRepository->fetchActiveBatch()->first();
        $filename = 'Laporan '.Auth::user()->location->name.' Batch '.$batch->name.'.xlsx';
        return Excel::download(new StudentReportExcel($this->materialRepository, $this->studentReportRepository, $batch), $filename);
    }
}
