<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Payment\EloquentPaymentRepository;

class DashboardController extends Controller
{
    protected $paymentRepository;

    public function __construct(
        EloquentPaymentRepository $paymentRepository
    ) {
        $this->paymentRepository = $paymentRepository;
    }

    public function index()
    {
        return view('menu.dashboard');
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
