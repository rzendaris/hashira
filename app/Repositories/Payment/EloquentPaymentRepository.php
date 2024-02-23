<?php

namespace App\Repositories\Payment;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Traits\Upload;
use App\Models\Payment;
use App\Models\Transaction;
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

    public function fetchPaymentFilter(PaymentFilterRequest $request, $location_id)
    {
        $now = Carbon::now();
        $transactions = Transaction::whereHas(
            'student', fn($query) => $query
                ->where('location_id', $location_id)
        )->pluck('id');
        $date_filter = [NULL, NULL];
        if($request->date_filter){
            $date_filter = explode('-', $request->date_filter);
        }

        $payment =  $this->fetchPayment()->whereIn('transaction_id', $transactions);
        if($date_filter[0]){
            $payment = $payment->whereMonth('start_date', '<=', $date_filter[0]);
        } else {
            $payment = $payment->whereMonth('start_date', '<=', $now->month);
        }

        if($date_filter[1]){
            $payment = $payment->whereYear('start_date', '<=', $date_filter[1]);
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