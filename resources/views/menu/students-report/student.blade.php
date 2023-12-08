@extends('layouts/contentNavbarLayout')

@section('title', 'Students Management')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Students Management /</span> Students
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
  <h5 class="card-header">Students</h5>
  @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
    @if(!isset($data['material']))
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
        Add new Material
        </button>
    @endif
  @endif
  <div class="card-body">
    @if(isset($data['material']))
        <div class="row">
            <div class="mb-1 col-md-12">
                <label for="firstName" class="form-label">Material</label>
                <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $data['material']->name }}" disabled />
            </div>
            <div class="mb-1 col-md-12">
                <label for="email" class="form-label">Task</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $data['material']->task }}" disabled />
            </div>
            <div class="mb-1 col-md-12">
                <label for="firstName" class="form-label">Note</label>
                <textarea type="text" class="form-control" name="description" disabled>{{ $data['material']->note }}</textarea>
            </div>
        </div>
    @endif
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Batch</th>
          <th>Location</th>
          <th>Phone Number</th>
          <th>Score</th>
          <th>Actions</th>
        </tr>
      </thead>
        @if(isset($data['material']))
            <tbody class="table-border-bottom-0">
                @for($i = 0; $i < count($data['students']); $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><a class="nav-link" href="{{ url('admin/students/'.$data['students'][$i]->id) }}"><strong>{{ $data['students'][$i]->name }}</strong></a></td>
                    <td>{{ $data['students'][$i]->batch->name }}</td>
                    <td>{{ $data['students'][$i]->location->name }}</td>
                    <td>{{ $data['students'][$i]->phone_number }}</td>
                    <td><span class="badge bg-label-primary me-1">{{ $data['students'][$i]->score }}</span></td>
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                        <button type="button" class="dropdown-item btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editModal{{ $data['students'][$i]->id }}">
                            <i class="bx bx-edit-alt me-1"></i> Update Score
                        </button>
                        </div>
                    </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        @endif
    </table>
  </div>

  <!-- Modal -->
  <div class="card-body">
    <div class="row gy-3">
      <form method="post" action="{{url('admin/student-report/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Add new Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Material</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Material" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Task</label>
                    <input type="text" id="task" name="task" class="form-control" placeholder="Enter Task" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Note</label>
                    <textarea type="text" class="form-control" id="note" name="note" name="description" required></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Batch</label>
                    <input type="text" id="batch_id" name="batch_id" class="form-control" value="{{ $data['batch']->id }}" required>
                  </div>
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Location</label>
                    <input type="text" id="location_id" name="location_id" class="form-control" value="{{ Auth::user()->location->name }}" disabled>
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
        <form method="post" action="{{url('admin/student-report/score')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal fade" id="editModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Student Score</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="name" name="name" class="form-control" value="{{ $student->name }}" placeholder="Enter Name" disabled>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Email</label>
                      <input type="email" id="email" name="email" class="form-control" value="{{ $student->email }}" placeholder="xxxx@xxx.xx" disabled>
                    </div>
                    <div class="col mb-0">
                      <label for="dobWithTitle" class="form-label">Phone Number</label>
                      <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $student->phone_number }}" placeholder="+62..."  disabled>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Score</label>
                      <input type="text" id="score" name="score" class="form-control" placeholder="Enter Score" required>
                    </div>
                  </div>
                  <input type="hidden" id="id" name="id" value="{{ $student->id }}"/>

                    @if(isset($data['material']))
                        <input type="hidden" id="material_id" name="material_id" value="{{ $data['material']->id }}"/>
                    @endif
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
