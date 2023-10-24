@extends('layouts/contentNavbarLayout')

@section('title', 'Payments Management')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Payments Management /</span> Invoice
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
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
  <h5 class="card-header">Invoices</h5>
  
  <div class="table-responsive text-nowrap">
    <div class="card-body">
      <div class="btn-group">
        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Filter By Month & Year</button>
        <ul class="dropdown-menu">
          @foreach($data['group_filter'] as $filter)
            <li><a class="dropdown-item" href="{{ url('admin/invoice/?month='.$filter->month.'&year='.$filter->year) }}">{{ $filter->month_name }} - {{ $filter->year }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Installment</th>
          <th>Nominal</th>
          <th>Payment Period</th>
          <th>Invoice PDF</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @for($i = 0; $i < count($data['invoices']); $i++)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $data['invoices'][$i]->transaction->student->name }}</td>
            <td>{{ $data['invoices'][$i]->transaction->student->email }}</td>
            <td>{{ $data['invoices'][$i]->installment }}</td>
            <td>Rp. {{ number_format($data['invoices'][$i]->nominal) }}</td>
            <td>{{ date('Y/m/d', strtotime($data['invoices'][$i]->start_date)) }} - {{ date('Y/m/d', strtotime($data['invoices'][$i]->end_date)) }}</td>
            <td><a class="nav-link" href="{{ url('invoice/'.$data['invoices'][$i]->id) }}"><strong>Download Invoice</strong></a></td>
            @if($data['invoices'][$i]->status === 1)
              <td><span class="badge bg-label-primary me-1">Paid</span></td>
            @else
              <td><span class="badge bg-label-warning me-1">Not Paid</span></td>
            @endif
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editModal{{ $data['invoices'][$i]->id }}">
                    <i class="bx bx-edit-alt me-1"></i> Upload Payment Proof
                  </button>
                </div>
              </div>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

<hr class="my-5">

@endsection
