@extends('layouts/contentNavbarLayout')

@section('title', 'Users Management')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Users Management /</span> Users
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
  <h5 class="card-header">Table Basic</h5>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
    Add new User
  </button>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Location</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @for($i = 0; $i < count($data['users']); $i++)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $data['users'][$i]->name }}</strong></td>
            <td>{{ $data['users'][$i]->email }}</td>
            <td>{{ $data['users'][$i]->role->role_name }}</td>
            @if(isset($data['users'][$i]->location))
              <td>{{ $data['users'][$i]->location->name }}</td>
            @else
              <td>-</td>
            @endif
            @if($data['users'][$i]->status === 1)
              <td><span class="badge bg-label-primary me-1">Active</span></td>
            @else
              <td><span class="badge bg-label-warning me-1">Active</span></td>
            @endif
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <button type="button" class="dropdown-item btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editModal{{ $data['users'][$i]->id }}">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                  </button>
                  <button type="button" class="dropdown-item btn btn-warning btn-block" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data['users'][$i]->id }}">
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
      <form method="post" action="{{url('admin/users/create')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Add new User</h5>
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
                    <input type="email" id="email" name="email" class="form-control" placeholder="xxxx@xxx.xx" required>
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">Role</label>
                    <select class="form-control" id="role_id" name="role_id" required>
                      @foreach($data['roles'] as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Location</label>
                    <select class="form-control" id="location_id" name="location_id" required>
                      <option value="">-</option>
                      @foreach($data['locations'] as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
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

  @foreach($data['users'] as $user)
    <div class="card-body">
      <div class="row gy-3">
        <form method="post" action="{{url('admin/users/update')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Update User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" placeholder="Enter Name" required>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Email</label>
                      <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" placeholder="xxxx@xxx.xx" required>
                    </div>
                    <div class="col mb-0">
                      <label for="dobWithTitle" class="form-label">Role</label>
                      <select class="form-control" id="role_id" name="role_id" required>
                        <option value="{{ $user->role_id }}">{{ $user->role->role_name }}</option>
                        @foreach($data['roles'] as $role)
                          @if($user->role_id !== $role->id)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Password</label>
                      <input type="password" id="password" name="password" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" id="id" value="{{ $user->id }}">
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
    <div class="card-body">
      <div class="row gy-3">
        <form method="get" action="{{url('admin/users/delete/'.$user->id)}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Are you sure to deleting User?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Name</label>
                      <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" placeholder="Enter Name" disabled>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailWithTitle" class="form-label">Email</label>
                      <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" placeholder="xxxx@xxx.xx" disabled>
                    </div>
                    <div class="col mb-0">
                      <label for="dobWithTitle" class="form-label">Role</label>
                      <select class="form-control" id="role_id" name="role_id" disabled>
                        <option value="{{ $user->role_id }}">{{ $user->role->role_name }}</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Delete Dialog -->
  @endforeach
</div>
<!--/ Basic Bootstrap Table -->

<hr class="my-5">

<script>
  $("#role_id").on('change', function() {
    const roleId = this.value;
    if (roleId === 4 || roleId === 5) {
      $("#location_id").prop('required', true);
    } else {
      $("#location_id").prop('required', false);
    }
  });
</script>

@endsection
