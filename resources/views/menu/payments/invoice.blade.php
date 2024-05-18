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
    <form method="get" action="{{url('/admin/invoice')}}">
      <div class="card-body">
        <div class="btn-group">
          <label for="emailWithTitle" class="form-label">Filter By Date</label>
          <select class="form-select" id="date_filter" name="date_filter">
            @foreach($data['group_filter'] as $filter)
              <option value="{{ $filter->month }}-{{ $filter->year }}">{{ $filter->month_name }} - {{ $filter->year }}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label for="emailWithTitle" class="form-label">Filter By Location</label>
          <select class="form-select" id="location_id" name="location_id">
            <option value="{{ $data['location']->id }}">{{ $data['location']->name }}</option>
            @foreach($data['location_lists'] as $location)
              @if($data['location']->id !== $location->id)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </div>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Location</th>
          <th>Name</th>
          <th>Email</th>
          <th>Installment</th>
          <th>Nominal</th>
          <th>Payment Period</th>
          <th>Invoice PDF</th>
          <th>Payment Proof</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @for($i = 0; $i < count($data['invoices']); $i++)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $data['invoices'][$i]->transaction->student->location->name }}</td>
            <td>{{ $data['invoices'][$i]->transaction->student->name }}</td>
            <td>{{ $data['invoices'][$i]->transaction->student->email }}</td>
            <td>{{ $data['invoices'][$i]->installment }}</td>
            <td>Rp. {{ number_format($data['invoices'][$i]->nominal) }}</td>
            <td>{{ date('Y/m/d', strtotime($data['invoices'][$i]->start_date)) }} - {{ date('Y/m/d', strtotime($data['invoices'][$i]->end_date)) }}</td>
            <td><a class="nav-link" href="{{ url('invoice/'.$data['invoices'][$i]->id) }}"><span class="badge bg-label-primary me-1">Download Invoice</span></a></td>

            @if(isset($data['invoices'][$i]->payment_proof))
              <td><a class="nav-link" href="{{ asset($data['invoices'][$i]->payment_proof) }}" target="_blank"><span class="badge bg-label-primary me-1">Image</span></a></td>
            @else
              <td></td>
            @endif
            
            @if($data['invoices'][$i]->status == 1)
              <td><span class="badge bg-label-primary me-1">Paid</span></td>
            @else
              <td><span class="badge bg-label-warning me-1">Not Paid</span></td>
            @endif
            <td>
              <div class="dropdown">
                @if(Auth::user()->role_id !== '2')
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editModal{{ $data['invoices'][$i]->id }}">
                    <i class="bx bx-edit-alt me-1"></i> Upload Payment Proof
                  </button>
                </div>
                @endif
              </div>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>

  @foreach($data['invoices'] as $invoice)
    <div class="card-body">
      <div class="row gy-3">
        <form method="post" action="{{url('admin/invoice/upload-payment')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal fade" id="editModal{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Upload Payment Proof</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="name" name="name" class="form-control" value="{{ $invoice->transaction->student->name }}" placeholder="Enter Name" disabled>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Email</label>
                      <input type="email" id="email" name="email" class="form-control" value="{{ $invoice->transaction->student->name }}" placeholder="xxxx@xxx.xx" disabled>
                    </div>
                    <div class="col mb-0">
                      <label for="dobWithTitle" class="form-label">Installment</label>
                      <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $invoice->installment }}" placeholder="+62..."  disabled>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Nominal</label>
                      <input type="email" id="email" name="email" class="form-control" value="Rp. {{ number_format($invoice->nominal) }}" placeholder="xxxx@xxx.xx" disabled>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Upload File</label>
                      <input type="file" id="payment_proof" name="payment_proof" class="form-control" placeholder="Enter Score" required>
                    </div>
                  </div>
                  <input type="hidden" id="id" name="id" value="{{ $invoice->id }}"/>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" id="id" value="{{ $invoice->id }}">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Edit Dialog -->
  @endforeach
</div>
<!--/ Basic Bootstrap Table -->

<hr class="my-5">

@endsection
