@extends('layouts.app')

@section('subtitle', 'Roles Management')
@section('content_header_title', 'Role')
@section('content_header_subtitle', 'Management')

@section('content_body')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Create / Edit Form -->
                <div id="roleFormSection" class="mb-4">
                    <form id="roleForm">
                        @csrf
                        <input type="hidden" name="role_id" id="role_id">

                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Enter role name" required>
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- DataTable --}}
        <div class="card">
            <div class="card-body">
                <!-- DataTable -->
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="roles-table">
                        <thead class="text-sm text-capitalize">
                            <tr>
                                <th>Name</th>
                                <th>Created on</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('admin.roles.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Reset form
            $('#resetBtn').click(function() {
                $('#roleForm').trigger("reset");
                $('#role_id').val('');
                $('#saveBtn').text('Save');
            });

            // Save role (create or update)
            $('#roleForm').off('submit').submit(function(e) {
                e.preventDefault();
                let id = $('#role_id').val();
                let url = id ?
                    "{{ route('admin.roles.update', ':id') }}".replace(':id', id) :
                    "{{ route('admin.roles.store') }}";

                let type = id ? "PUT" : "POST";
                $.ajax({
                    url: url,
                    type: type,
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success(res.success);
                        $('#roleForm').trigger("reset");
                        $('#role_id').val('');
                        $('#saveBtn').text('Save');
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]); // show each error
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.error(xhr.responseJSON.error);
                        } else {
                            toastr.error('Something went wrong.');
                        }
                    }
                });
            });

            // Edit role
            $(document).on('click', '.editRole', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                $('#role_id').val(id);
                $('#name').val(name);
                $('#saveBtn').text('Update');
            });

            // Delete role
            $(document).on('click', '.deleteRole', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the role permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.roles.destroy', ':id') }}".replace(':id',
                                id),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(data) {
                                toastr.success(data.success);
                                table.ajax.reload(null, false);
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON.message ||
                                    'Error deleting role');
                            }
                        });
                    }
                });

            });

        });
    </script>
@endpush
