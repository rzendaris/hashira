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

class PaymentController extends Controller
{
    protected $paymentRepository;

    public function __construct(
        EloquentPaymentRepository $paymentRepository
    ) {
        $this->paymentRepository = $paymentRepository;
    }

    public function invoice(PaymentFilterRequest $request): View
    {
        $invoices = $this->paymentRepository->fetchPaymentFilter($request);
        $group_filter = $this->paymentRepository->fetchPaymentGroupByMonth();

        $data = array(
            "invoices" => $invoices,
            "group_filter" => $group_filter
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
