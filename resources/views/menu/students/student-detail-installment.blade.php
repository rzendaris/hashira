@extends('layouts/contentNavbarLayout')

@section('title', 'Student Payment Installment - Student')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student Profile /</span> Payment Installment
</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item"><a class="nav-link" href="{{ url('admin/students/'.$data['student']->id) }}"><i class="bx bx-user me-1"></i> Student Profile</a></li>
      <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-bell me-1"></i> Class Report</a></li>
      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-link-alt me-1"></i> Payment Installments</a></li>
    </ul>
    <div class="card mb-4">
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h5 class="card-header">Installment</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Installment</th>
            <th>Nominal</th>
            <th>Period</th>
            <th>Payment Proof</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($data['student']->transaction->payments as $payment)
            <tr>
              <td><strong>{{ $payment->installment }}</strong></td>
              <td>Rp. {{ number_format($payment->nominal) }}</td>
              <td>{{ date('Y/m/d', strtotime($payment->start_date)) }} - {{ date('Y/m/d', strtotime($payment->end_date)) }}</td>
              <td>{{ $payment->payment_proof }}</td>
              @if($payment->status === 1)
                <td><span class="badge bg-label-primary me-1">Paid</span></td>
              @else
                <td><span class="badge bg-label-warning me-1">Not Paid</span></td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
