@extends('layouts.app')

@section('subtitle', 'Profile')
@section('content_header_title', 'My Profile')
@section('content_header_subtitle', 'View & Edit')

@section('content_body')

    <div class="card shadow-none border">
        <div class="card-header">
            <h3 class="card-title">Profile Information</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Name -->
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">

                    <!-- Profile Picture -->
                    <div class="form-group col-md-6">
                        <label>Profile Picture</label>
                        <input type="file" name="profile_picture"
                            class="form-control @error('profile_picture') is-invalid @enderror">
                        @error('profile_picture')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        @if ($user->image)
                            <img src="{{ asset($user->image) }}" alt="Profile Picture" class="img-thumbnail mt-2"
                                width="150">
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- Password -->
                    <div class="form-group col-md-6">
                        <label>Password (leave blank if no change)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Update Profile</button>
            </form>

        </div>
    </div>

    <div class="card shadow-none border">
        <div class="card-header bg-light">
            <h6 class="card-title mb-0"><i class="fas fa-filter me-2"></i>My Activities</h6>
        </div>
        <div class="card-body">
            <div class="tabler-responsive">
                <table id="activityLogTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Affected</th>
                            <th>Before</th>
                            <th>After</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#activityLogTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.activity-log.index') }}",
                data: function(d) {
                    d.user_id = '{{ $user->id }}}';
                }
            },
            columns: [{
                    data: 'timestamp',
                    name: 'created_at',
                    orderable: true
                },
                {
                    data: 'user',
                    name: 'causer.name',
                    orderable: false
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false
                },
                {
                    data: 'affected',
                    name: 'subject_type',
                    orderable: false
                },
                {
                    data: 'before',
                    name: 'before',
                    orderable: false
                },
                {
                    data: 'after',
                    name: 'after',
                    orderable: false
                },
                {
                    data: 'ip',
                    name: 'ip',
                    orderable: false
                }
            ],
            order: [
                [0, 'desc']
            ],
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search in table...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                zeroRecords: "No matching records found",
                emptyTable: "No data available",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
        });
    </script>
@endsection
