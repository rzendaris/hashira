<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PaymentFilterRequest;
use App\Http\Requests\PaymentRequest;
use PDF;

use App\Repositories\Payment\EloquentPaymentRepository;
use App\Repositories\Location\EloquentLocationRepository;

class PaymentController extends Controller
{
    protected $paymentRepository;
    protected $locationRepository;

    public function __construct(
        EloquentPaymentRepository $paymentRepository,
        EloquentLocationRepository $locationRepository
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->locationRepository = $locationRepository;
    }

    public function invoice(PaymentFilterRequest $request): View
    {
        if($request->location_id){
            $location = $this->locationRepository->fetchLocationBuilder()->where('id', $request->location_id)->first();
        } else {
            $location = $this->locationRepository->fetchLocationBuilder()->first();
        }
        $location_lists = $this->locationRepository->fetchLocation();
        $invoices = $this->paymentRepository->fetchPaymentFilter($request, $location->id);
        $group_filter = $this->paymentRepository->fetchPaymentGroupByMonth();

        $data = array(
            "invoices" => $invoices,
            "group_filter" => $group_filter,
            "location" => $location,
            "location_lists" => $location_lists
        );
        return view('menu.payments.invoice')->with('data', $data);
    }

    public function uploadPaymentProof(PaymentRequest $request)
    {
        $invoices = $this->paymentRepository->updatePayment($request);
        return redirect()->route('invoice-view');
    }

    public function invoicePDF($payment_id)
    {
        $payment = $this->paymentRepository->fetchPaymentById($payment_id);
        $pdf = PDF::loadView('menu.payments.invoice-pdf', compact('payment'));
        return $pdf->download($payment->transaction->student->name.'-'.$payment->installment.'.pdf');
    }
}
