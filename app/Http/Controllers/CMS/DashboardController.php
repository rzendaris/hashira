<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Payment\EloquentPaymentRepository;
use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Repositories\Student\EloquentStudentRepository;

class DashboardController extends Controller
{
    protected $paymentRepository;
    protected $studentRepository;
    protected $locationRepository;
    protected $batchRepository;

    public function __construct(
        EloquentPaymentRepository $paymentRepository,
        EloquentStudentRepository $studentRepository,
        EloquentLocationRepository $locationRepository,
        EloquentBatchRepository $batchRepository
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->studentRepository = $studentRepository;
        $this->batchRepository = $batchRepository;
        $this->locationRepository = $locationRepository;
    }

    public function index()
    {
        $locations = $this->locationRepository->fetchLocation();
        $series = [];
        $data_batchs = [];
        foreach($locations as $location){
            $series_data = array(
                "name" => $location->name,
                "data" => []
            );

            $batchs = $this->batchRepository->fetchBatchBuilder()->orderBy('id', 'ASC')->get();
            foreach($batchs as $batch){
                $number_of_student = $this->studentRepository->fetchStudent()->where('location_id', $location->id)->where('batch_id', $batch->id)->count();
                $series_data['data'][] = $number_of_student;
                if(in_array($batch->name, $data_batchs) === false){
                    $data_batchs[] = $batch->name;
                }
            }
            $series[] = $series_data;
        }
        $data = array(
            "x" => json_encode($series),
            "y" => json_encode($data_batchs)
        );
        return view('menu.dashboard')->with('data', $data);
    }

    public function calendar()
    {
        $events = [];
        $invoices = $this->paymentRepository->fetchPayment()->where('status', 0)->get();
        foreach($invoices as $invoice){
            $events[] = [
                'title' => $invoice->transaction->student->name." Invoice: ".$invoice->installment,
                'start' => $invoice->start_date,
                'url'   => "url",
            ];
        }
        return view('menu.calendar', compact('events'));
    }
}
