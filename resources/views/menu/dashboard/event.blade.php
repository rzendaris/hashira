@extends('layouts/contentNavbarLayout')

@section('title', 'Event Management')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Event Management /</span> Event
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
  <h5 class="card-header">Events</h5>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
    Add new Event
  </button>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Description</th>
          <th>Period</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @for($i = 0; $i < count($data['events']); $i++)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $data['events'][$i]->name }}</strong></td>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $data['events'][$i]->description }}</strong></td>
            <td>{{ $data['events'][$i]->start_date }} - {{ $data['events'][$i]->end_date }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editModal{{ $data['events'][$i]->id }}">
                    <i class="bx bx-edit-alt me-1"></i> Detail
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
      <form method="post" action="{{url('admin/events/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Add new Event</h5>
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
                    <label for="emailWithTitle" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                  </div>
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Description</label>
                    <textarea type="text" class="form-control" name="description"></textarea>
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

  @foreach($data['events'] as $event)
    <div class="card-body">
      <div class="row gy-3">
        <form method="post" action="{{url('admin/configurations/events/update')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal fade" id="editModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Update Event</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="name" name="name" class="form-control" value="{{ $event->name }}" placeholder="Enter Name" required>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Start Date</label>
                      <input type="text" id="start_date" name="start_date" class="form-control" value="{{ $event->start_date }}" required>
                    </div>
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">End Date</label>
                      <input type="text" id="end_date" name="end_date" class="form-control" value="{{ $event->end_date }}" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" id="id" value="{{ $event->id }}">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                  <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
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
