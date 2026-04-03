@extends('layouts.app')

@section('title', 'User Management')

@section('content_header_title', 'User')
@section('content_header_subtitle', 'Management')
@section('css')
    <style>
        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@stop
@section('content_body')
    <div class="card shadow-none border">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home"
                            type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                            All
                        </button>

                        <button class="nav-link" id="stats-tab" data-toggle="tab" data-target="#stats" type="button"
                            role="tab" aria-controls="stats" aria-selected="false">
                            Stats
                        </button>
                    </div>
                </div>
                <div class="col-md-8 d-flex align-items-center">
                    <div class="ml-auto">
                        @can('create user')
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-plus"></i> New User
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                    tabindex="0">
                    <div class="card shadow-sm border">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="users-table">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th width="200px">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab" tabindex="0">

                    <!-- Main Stats Cards -->
                    <div class="row mb-1">
                        <!-- Total Users Card -->
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($data['totalUsers']) }}
                                            </div>
                                            <div class="mt-2">
                                                <span class="badge bg-success">Active: {{ $data['activeUsers'] }}</span>
                                                <span class="badge bg-secondary">Inactive:
                                                    {{ $data['inactiveUsers'] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Users Card -->
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Active Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($data['activeUsers']) }}
                                            </div>
                                            <div class="mt-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-success">Active Rate</small>
                                                    <small
                                                        class="text-muted">{{ number_format($data['activePercentage'], 1) }}%</small>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $data['activePercentage'] }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-check fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Verified Users -->
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Verified Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($data['verifiedUsers']) }}
                                            </div>
                                            <div class="mt-2">
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-info">Verified</small>
                                                    <small
                                                        class="text-muted">{{ number_format($data['verifiedPercentage'], 1) }}%</small>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-warning">Unverified</small>
                                                    <small class="text-muted">{{ $data['unverifiedUsers'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-envelope-check fa-2x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Users -->
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Recent Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($data['recentUsers']) }}
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">Registered in last 30 days</small>
                                                @if ($data['recentUsers'] > 0)
                                                    <div class="progress mt-1" style="height: 4px;">
                                                        @php
                                                            $recentPercentage = min(
                                                                100,
                                                                ($data['recentUsers'] / max(1, $data['totalUsers'])) *
                                                                    100,
                                                            );
                                                        @endphp
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: {{ $recentPercentage }}%">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-clock fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role and Activity Summary -->
                    <div class="row mb-1">
                        <div class="col-lg-6 mb-1">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold">Role Distribution</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Role</th>
                                                    <th>Count</th>
                                                    <th>Percentage</th>
                                                    <th>Progress</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['roleDistribution'] as $role)
                                                    @php
                                                        $percentage =
                                                            $data['totalUsers'] > 0
                                                                ? ($role['count'] / $data['totalUsers']) * 100
                                                                : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="badge bg-{{ $role['color'] }}">{{ $role['role'] }}</span>
                                                        </td>
                                                        <td>{{ $role['count'] }}</td>
                                                        <td>{{ number_format($percentage, 1) }}%</td>
                                                        <td>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $role['color'] }}"
                                                                    role="progressbar"
                                                                    style="width: {{ $percentage }}%">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Status Overview Cards -->
                    <div class="row mb-1">
                        <div class="col-md-6 mb-1">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-3">
                                        <i class="fas fa-user-circle fa-3x"></i>
                                    </div>
                                    <h3 class="card-title">{{ number_format($data['activePercentage'], 1) }}%</h3>
                                    <p class="card-text text-muted">Active Users Rate</p>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $data['activePercentage'] }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="text-success mb-3">
                                        <i class="fas fa-envelope-check fa-3x"></i>
                                    </div>
                                    <h3 class="card-title">{{ number_format($data['verifiedPercentage'], 1) }}%</h3>
                                    <p class="card-text text-muted">Verified Users Rate</p>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $data['verifiedPercentage'] }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Assign Role Modal -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="assignRoleForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Role</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <select name="role" id="role" class="form-control" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('admin.users.index') }}",
                columns: [{
                        data: 'user',
                        name: 'user',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Open Assign Role Modal
            $(document).on('click', '.assignRoleBtn', function() {
                let id = $(this).data('id');
                $('#user_id').val(id);
                $('#assignRoleModal').modal('show');
            });

            // Submit Assign Role
            $('#assignRoleForm').submit(function(e) {
                e.preventDefault();
                let id = $('#user_id').val();
                $.ajax({
                    url: "/users/" + id + "/assign-role",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success(res.success);
                        $('#assignRoleModal').modal('hide');
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.error || 'Something went wrong.');
                    }
                });
            });

            $(document).off('click', '.toggleStatusBtn').on('click', '.toggleStatusBtn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.users.toggleStatus', 'id') }}".replace('id', id),
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        toastr.success(res.success);
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.error || 'Something went wrong.');
                    }
                });
            });

        });
    </script>
@endpush
