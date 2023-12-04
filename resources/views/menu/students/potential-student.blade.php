@extends('layouts/contentNavbarLayout')

@section('title', 'Potential Students Management')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Potential Students Management /</span> Potential Students
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
  <h5 class="card-header">Potential Students</h5>
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
    Add new Potential Student
  </button> -->
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Phone Number</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @for($i = 0; $i < count($data['students']); $i++)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><a class="nav-link" href="{{ url('admin/students/'.$data['students'][$i]->id) }}"><strong>{{ $data['students'][$i]->name }}</strong></a></td>
            <td>{{ $data['students'][$i]->email }}</td>
            <td>{{ $data['students'][$i]->gender }}</td>
            <td>{{ $data['students'][$i]->phone_number }}</td>
            @if($data['students'][$i]->status === 1)
              <td><span class="badge bg-label-primary me-1">Active</span></td>
            @else
              <td><span class="badge bg-label-warning me-1">Active</span></td>
            @endif
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editModal{{ $data['students'][$i]->id }}">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                  </button>
                  <button type="button" class="dropdown-item btn btn-warning btn-block" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data['students'][$i]->id }}">
                    <i class="bx bx-trash me-1"></i> Delete
                  </button>
                </div>
              </div>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="card-body">
    <div class="row gy-3">
      <form method="post" action="{{url('admin/students/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Add new Potential Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="xxxx@xxx.xx">
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="+62..." required>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                      <option value="Laki-Laki">Laki-Laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">Birth Date</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control" required>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Education</label>
                    <select class="form-select" id="education" name="education" required>
                      <option value="SMA">SMA</option>
                      <option value="SMK">SMK</option>
                      <option value="Sarjana">Sarjana</option>
                    </select>
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">City</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-2">
                    <label for="emailWithTitle" class="form-label">Installments</label>
                    <select class="form-select" id="installment" name="installment" required>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                    </select>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-2">
                    <input class="form-check-input" type="checkbox" id="pay_later" name="pay_later">
                    <label class="form-check-label" for="flexCheckDefault">
                      Talangan Pendidikan
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter Name" required>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Ujian JFT</label>
                      <select class="form-select" id="jft_status" name="jft_status" required>
                        <option value="Belum">Belum</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Gagal">Gagal</option>
                      </select>
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">Ujian SSW</label>
                      <select class="form-select" id="ssw_status" name="ssw_status" required>
                        <option value="Belum">Belum</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Gagal">Gagal</option>
                      </select>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">KTP</label>
                    <input type="file" id="ktp_file" name="ktp_file" class="form-control" required>
                  </div>
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Ijazah</label>
                    <input type="file" id="ijazah_file" name="ijazah_file" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  @foreach($data['students'] as $student)
    <div class="card-body">
      <div class="row gy-3">
        <form method="post" action="{{url('admin/students/update')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal fade" id="editModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Update Student</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="name" name="name" class="form-control" value="{{ $student->name }}" placeholder="Enter Name" required>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Email</label>
                      <input type="email" id="email" name="email" class="form-control" value="{{ $student->email }}" placeholder="xxxx@xxx.xx">
                    </div>
                    <div class="col mb-0">
                      <label for="dobWithTitle" class="form-label">Phone Number</label>
                      <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $student->phone_number }}" placeholder="+62..." required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Address</label>
                      <input type="text" id="address" name="address" class="form-control" value="{{ $student->address }}" placeholder="Enter Name" required>
                    </div>
                  </div>
                  <input type="hidden" id="id" name="id" value="{{ $student->id }}"/>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" id="id" value="{{ $student->id }}">
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
