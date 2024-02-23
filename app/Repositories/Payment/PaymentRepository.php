<?php

namespace App\Repositories\Payment;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PaymentFilterRequest;

interface PaymentRepository {
    public function fetchPayment();
    public function fetchPaymentById($id);
    public function fetchTransaction();
    public function fetchPaymentGroupByMonth();
    public function fetchPaymentFilter(PaymentFilterRequest $request, $location_id);
    public function updatePayment(PaymentRequest $request);
}
