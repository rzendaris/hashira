@extends('layouts/contentNavbarLayout')

@section('title', 'Students Profile - Student')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student Profile /</span> Profile
</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Student Profile</a></li>
      <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-bell me-1"></i> Class Report</a></li>
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
    <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{asset('assets/img/avatars/bird.png')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="bx bx-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Full Name</label>
                <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $data['student']->name }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $data['student']->email }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Gender</label>
                <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $data['student']->gender }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Birth Date</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $data['student']->birth_date }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Education</label>
                <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $data['student']->education }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">City</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $data['student']->city }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Location</label>
                <input type="text" class="form-control" id="organization" name="organization" value="{{ $data['student']->location->name }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Batch</label>
                <input type="text" class="form-control" id="organization" name="organization" value="{{ $data['student']->batch->name }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="phoneNumber">Phone Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" value="{{ $data['student']->phone_number }}" disabled />
                </div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $data['student']->address }}" disabled/>
            </div>
            <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Ujian JFT</label>
                <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $data['student']->jft_status }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Ujian SSW</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $data['student']->ssw_status }}" disabled />
            </div>
            <div class="mb-3 col-md-6">
                <label for="address" class="form-label">KTP</label>
                <img width="150" height="150" src="{{ asset($data['student']->ktp_file) }}">
            </div>
            <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Ijazah</label>
                <img width="150" height="150" src="{{ asset($data['student']->ijazah_file) }}">
            </div>
        </div>
      </div>
      <!-- /Account -->
    </div>
    <div class="card">
      <h5 class="card-header">Delete Account</h5>
      <div class="card-body">
        <div class="mb-3 col-12 mb-0">
          <div class="alert alert-warning">
            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
          </div>
        </div>
        <form id="formAccountDeactivation" onsubmit="return false">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
            <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
          </div>
          <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
