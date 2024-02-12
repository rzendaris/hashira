@extends('layouts/contentNavbarLayout')

@section('title', 'Student Payment Installment - Student')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student Profile /</span> Student Report
</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item"><a class="nav-link" href="{{ url('admin/students/'.$data['student']->id) }}"><i class="bx bx-user me-1"></i> Student Profile</a></li>
      <li class="nav-item"><a class="nav-link active" href="{{ url('admin/students/'.$data['student']->id.'/report') }}"><i class="bx bx-bell me-1"></i> Class Report</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('admin/students/'.$data['student']->id.'/installment') }}"><i class="bx bx-link-alt me-1"></i> Payment Installments</a></li>
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
    <h5 class="card-header">Report</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Score</th>
            <th>Topic</th>
            <th>Task</th>
            <th>Note</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach($data['date_range'] as $student)
                @if(empty($student['report']) || Carbon\Carbon::parse($student['date'])->format('l') === 'Saturday' || Carbon\Carbon::parse($student['date'])->format('l') === 'Sunday')
                    <tr>
                        @if(Carbon\Carbon::parse($student['date'])->isPast())
                            <td style="background-color: #ff0000; color: #000000"><strong>{{ Carbon\Carbon::parse($student['date'])->format('l, d F Y') }}</strong></td>
                            <td colspan="4" style="background-color: #ff0000; color: #000000">Libur</td>
                        @else
                            <td><strong>{{ Carbon\Carbon::parse($student['date'])->format('l, d F Y') }}</strong></td>
                            <td colspan="4" bgcolor="#ff0000">Belum Dimulai</td>
                        @endif
                    </tr>
                @else
                    <tr>
                        <td><strong>{{ Carbon\Carbon::parse($student['date'])->format('l, d F Y') }}</strong></td>
                        <td>{{ $student['report']->score }}</td>
                        <td>{{ $student['report']->material->name }}</td>
                        <td>{{ $student['report']->material->task }}</td>
                        <td>{{ $student['report']->material->note }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
