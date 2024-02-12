<?php

namespace App\Repositories\Payment;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Traits\Upload;
use App\Models\Payment;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PaymentFilterRequest;

class EloquentPaymentRepository implements PaymentRepository
{
    use Upload;

    public function fetchPayment()
    {
        $query_builder = Payment::whereNotNull('status');
        return $query_builder;
    }

    public function fetchPaymentById($id)
    {
        $payment = $this->fetchPayment()->where('id', $id)->first();
        return $payment;
    }

    public function fetchTransaction()
    {
        $transaction = Transaction::whereNotNull('status');
        return $transaction;
    }

    public function fetchPaymentGroupByMonth()
    {
        $payment_group =$this->fetchPayment()->selectRaw('year(start_date) as year, month(start_date) as month, monthname(start_date) as month_name')
            ->groupBy('year','month','month_name')
            ->orderByRaw('min(created_at) desc')
            ->get();
        return $payment_group;
    }

    public function fetchPaymentFilter(PaymentFilterRequest $request)
    {
        $now = Carbon::now();
        $payment =  $this->fetchPayment();
        if($request->month){
            $payment = $payment->whereMonth('start_date', '<=', $request->month);
        } else {
            $payment = $payment->whereMonth('start_date', '<=', $now->month);
        }

        if($request->year){
            $payment = $payment->whereYear('start_date', '<=', $request->year);
        } else {
            $payment = $payment->whereYear('start_date', '<=', $now->year);
        }
        return $payment->orderBy('transaction_id')->orderBy('installment')->get();
    }

    public function updatePayment(PaymentRequest $request)
    {
        $payment = $this->fetchPaymentById($request->id);
        if ($request->hasFile('payment_proof')) {
            $payment->payment_proof = $this->UploadFile($request->file('payment_proof'), 'payment-proof');
        }
        $payment->status = 1;
        $payment->save();
        return $payment;
    }
}