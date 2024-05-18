<?php

namespace App\Http\Controllers\CMS;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Payment\EloquentPaymentRepository;
use App\Repositories\Batch\EloquentBatchRepository;
use App\Repositories\Location\EloquentLocationRepository;
use App\Repositories\Student\EloquentStudentRepository;
use App\Repositories\Event\EloquentEventRepository;
use App\Repositories\Material\EloquentMaterialRepository;
use App\Http\Requests\EventRequest;

class DashboardController extends Controller
{
    protected $paymentRepository;
    protected $studentRepository;
    protected $locationRepository;
    protected $batchRepository;
    protected $eventRepository;
    protected $materialRepository;

    public function __construct(
        EloquentPaymentRepository $paymentRepository,
        EloquentStudentRepository $studentRepository,
        EloquentLocationRepository $locationRepository,
        EloquentBatchRepository $batchRepository,
        EloquentEventRepository $eventRepository,
        EloquentMaterialRepository $materialRepository
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->studentRepository = $studentRepository;
        $this->batchRepository = $batchRepository;
        $this->locationRepository = $locationRepository;
        $this->eventRepository = $eventRepository;
        $this->materialRepository = $materialRepository;
    }

    public function index()
    {
        $locations = $this->locationRepository->fetchLocationBuilder();
        if(Auth::user()->location_id !== NULL){
            $locations = $locations->where('id', Auth::user()->location_id);
        }
        $locations = $locations->get();
        $series = [];
        $data_batchs = [];
        foreach($locations as $location){
            $series_data = array(
                "name" => $location->name,
                "data" => []
            );

            $batchs = $this->batchRepository->fetchBatchBuilder()->orderBy('id', 'ASC')->get();
            foreach($batchs as $batch){
                $number_of_student = $this->studentRepository->fetchStudent();
                if(Auth::user()->location_id !== NULL){
                    $number_of_student = $number_of_student->where('location_id', Auth::user()->location_id);
                } else {
                    $number_of_student = $number_of_student->where('location_id', $location->id);
                }
                $number_of_student = $number_of_student->where('batch_id', $batch->id)->count();
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

        $data['events'] = $this->eventRepository->fetchEventBuilder()->whereDate('start_date', '>=', Carbon::today())->orderBy('start_date')->get();
        if((int)Auth::user()->role_id === 4){
            $data['class'] = $this->materialRepository->fetchMaterial()->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();
        }
        
        $data['paid_pct'] = 0;
        $data['not_paid_pct'] = 0;
        if((int)Auth::user()->role_id === 3){
            $now = Carbon::now();
            $data['total_transaction'] = $this->paymentRepository->fetchPayment()->sum('nominal');
            $data['paid'] = $this->paymentRepository->fetchPayment()->where('status', 1)->sum('nominal');
            $data['not_paid'] = $this->paymentRepository->fetchPayment()->where('status', 0)->sum('nominal');
            $data['paid_pct'] = round($data['paid'] / $data['total_transaction'] * 100, 0);
            $data['not_paid_pct'] = round($data['not_paid'] / $data['total_transaction'] * 100, 0);
            $data['invoices'] = $this->paymentRepository->fetchPayment()->where('status', 0)->whereMonth('start_date', '<=', $now->month)->whereYear('start_date', '<=', $now->year)->get();
        }
        return view('menu.dashboard.dashboard')->with('data', $data);
    }

    public function calendar()
    {
        $events = [];
        if((int)Auth::user()->role_id !== 4){
            $invoices = $this->paymentRepository->fetchPayment()->where('status', 0)->get();
            foreach($invoices as $invoice){
                $events[] = [
                    'title' => $invoice->transaction->student->name." Invoice: ".$invoice->installment,
                    'start' => $invoice->start_date,
                    'url'   => "url",
                ];
            }
        }
        $add_events = $this->eventRepository->fetchEventBuilder()->get();
        foreach($add_events as $add_event){
            $events[] = [
                'title' => $add_event->name,
                'start' => $add_event->start_date,
                'url'   => "url",
            ];
        }
        return view('menu.dashboard.calendar', compact('events'));
    }

    public function events()
    {
        $events = $this->eventRepository->fetchEventBuilder()->get();
        $data = array(
            "events" => $events
        );
        return view('menu.dashboard.event')->with('data', $data);
    }

    public function createEvent(EventRequest $request)
    {
        $this->eventRepository->insertEvent($request);
        return redirect()->route('events');
    }
}
