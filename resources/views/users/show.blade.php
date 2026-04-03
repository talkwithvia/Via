@extends('layouts.app')

@section('title', 'User Details and Activity Logs')
@section('subtitle', 'User Details and Activity Logs')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Information & Activity Logs')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between align-items-center d-flex">
            <div>
                <h3 class="card-title">{{ $user->name }}'s Details</h3>
            </div>

            <div>
                @can('view users')
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Users
                    </a>
                @endcan
                @can('edit users')
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Edit User
                    </a>
                @endcan
                @if (Auth::user()->hasRole(['admin', 'super_admin', 'super admin']) ||
                        (Auth::user()->can('delete users') && $user->id != Auth::user()->id))
                    <button type="button" class="btn btn-sm btn-danger ml-2" data-toggle="modal"
                        data-target="#deleteUserModal">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column: Profile Picture -->
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            @if ($user->image && file_exists(public_path($user->image)))
                                <img src="{{ asset($user->image) }}" alt="Profile Picture"
                                    class="img-fluid rounded-circle mb-3"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                                    style="width: 200px; height: 200px;">
                                    <i class="fas fa-user fa-5x text-muted"></i>
                                </div>
                            @endif
                            <div class="mt-2">
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: User Information Table -->
                <div class="col-md-8">
                    <div class="card h-100">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-hover mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold text-nowrap"
                                                style="width: 200px; background-color: #f8f9fa;">Full Name</td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-nowrap" style="background-color: #f8f9fa;">Email Address
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                @if ($user->email_verified_at)
                                                    <span class="badge badge-success ml-2">
                                                        <i class="fas fa-check-circle"></i> Verified
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning ml-2">
                                                        <i class="fas fa-exclamation-circle"></i> Not Verified
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-nowrap" style="background-color: #f8f9fa;">Account
                                                Status</td>
                                            <td>
                                                @if ($user->status)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times"></i> Inactive
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-nowrap" style="background-color: #f8f9fa;">Roles
                                            </td>
                                            <td>
                                                @if ($user->roles->count() > 0)
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge badge-info mr-1 mb-1 d-inline-block">
                                                            <i class="fas fa-user-tag mr-1"></i>{{ ucfirst($role->name) }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No roles assigned</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-nowrap" style="background-color: #f8f9fa;">Account
                                                Created</td>
                                            <td>
                                                {{ $user->created_at->format('F d, Y \a\t h:i A') }}
                                                <br>
                                                <small
                                                    class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-nowrap" style="background-color: #f8f9fa;">Last Updated
                                            </td>
                                            <td>
                                                {{ $user->updated_at->format('F d, Y \a\t h:i A') }}
                                                <br>
                                                <small
                                                    class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                        @if ($user->email_verified_at)
                                            <tr>
                                                <td class="fw-bold text-nowrap" style="background-color: #f8f9fa;">Email
                                                    Verified</td>
                                                <td>
                                                    {{ $user->email_verified_at->format('F d, Y \a\t h:i A') }}
                                                    <br>
                                                    <small
                                                        class="text-muted">({{ $user->email_verified_at->diffForHumans() }})</small>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <small class="text-muted">
                    <span>Created by {{ $causer['user']['name'] }}</span>
                    <br>
                    <span>Updated by {{ $causer['user']['name'] }}</span>
                </small>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if (Auth::user()->hasRole(['admin', 'super_admin', 'super admin']) ||
            (Auth::user()->can('delete users') && $user->id != Auth::user()->id))
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete user <strong>{{ $user->name }}</strong>?</p>
                        <p class="text-danger"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .table td:first-child {
            background-color: #f8f9fa !important;
            border-right: 1px solid #dee2e6;
        }

        .table tr:hover td:first-child {
            background-color: #e9ecef !important;
        }

        .rounded-circle {
            border: 3px solid #dee2e6;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.85em;
        }
    </style>

    <div class="card shadow-none border">
        <!-- Filters Section -->
        <div class="card-header bg-light">
            <h6 class="card-title mb-0"><i class="fas fa-filter me-2"></i>Filter Activity Logs</h6>
            <br>

            @can('edit users')
                @include('activity-logs.filter')
            @endcan
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

@stop

@push('css')
    <style>
        /* Filter Styles */
        #activeFilters .badge {
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
            cursor: default;
        }

        #activeFilters .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        #activeFilters .btn-close:hover {
            opacity: 1;
        }

        /* Date range picker customization */
        .daterangepicker {
            font-family: inherit;
        }

        .daterangepicker td.active,
        .daterangepicker td.active:hover {
            background-color: #4e73df;
        }

        /* Filter card */
        .card-header.bg-light {
            background-color: #f8f9fa !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .btn-group.w-100 {
                flex-wrap: wrap;
            }

            .btn-group.w-100 .btn {
                flex: 1;
                min-width: 100px;
            }
        }

        /* Export buttons */
        .btn-outline-success:hover {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-outline-danger:hover {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }

        .btn-outline-primary:hover {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        /* Table header dropdowns */
        .dataTables_wrapper select.form-control-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            if ($('#dateRange').length) {
                $('#dateRange').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    }
                });

                $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                        'YYYY-MM-DD'));
                    updateFilterTag('date', $(this).val());
                });

                $('#dateRange').on('cancel.daterangepicker', function() {
                    $(this).val('');
                    removeFilterTag('date');
                });
            }

            function updateFilterTag(type, text) {
                var existingTag = $(`#filterTags .badge[data-type="${type}"]`);
                if (existingTag.length) {
                    existingTag.html(`
                    ${text}
                    <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.5rem;" 
                            onclick="removeFilterTag('${type}')">&times;</button>
                `);
                } else {
                    addFilterTag(type, text, text);
                }
            }

            var table = $('#activityLogTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.activity-log.index') }}",
                    data: function(d) {
                        d.user_id = $('#userFilter').val();
                        d.activity_type = $('#activityTypeFilter').val();
                        d.model = $('#modelFilter').val();
                        d.search_text = $('#searchText').val();
                        d.ip_address = $('#ipFilter').val();
                        d.status = $('input[name="statusFilter"]:checked').val();
                        var dateRange = $('#dateRange').val();
                        if (dateRange) {
                            var dates = dateRange.split(' to ');
                            d.date_from = dates[0];
                            d.date_to = dates[1] || dates[0];
                        } else {
                            d.date_from = '';
                            d.date_to = '';
                        }
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

            // Filter Functions
            function applyFilters() {
                table.ajax.reload();
                updateActiveFiltersDisplay();
            }

            function resetFilters() {
                $('#activityLogFilters')[0].reset();
                $('#dateRange').val('');
                $('#activeFilters').addClass('d-none');
                $('#filterTags').empty();
                $('input[name="statusFilter"][value=""]').prop('checked', true);
                applyFilters();
            }

            function updateActiveFiltersDisplay() {
                var filters = [];
                var filterTags = $('#filterTags');
                filterTags.empty();

                var userId = $('#userFilter').val();
                var userName = $('#userFilter option:selected').text();
                if (userId) {
                    filters.push({
                        type: 'user',
                        value: userId,
                        text: userName
                    });
                    addFilterTag('user', userName, userId);
                }

                var activityType = $('#activityTypeFilter').val();
                if (activityType) {
                    filters.push({
                        type: 'activity',
                        value: activityType,
                        text: activityType
                    });
                    addFilterTag('activity', activityType, activityType);
                }

                var model = $('#modelFilter').val();
                if (model) {
                    filters.push({
                        type: 'model',
                        value: model,
                        text: model
                    });
                    addFilterTag('model', model, model);
                }

                // Search text
                var searchText = $('#searchText').val();
                if (searchText) {
                    filters.push({
                        type: 'search',
                        value: searchText,
                        text: 'Search: ' + searchText
                    });
                    addFilterTag('search', searchText, searchText);
                }

                var ip = $('#ipFilter').val();
                if (ip) {
                    filters.push({
                        type: 'ip',
                        value: ip,
                        text: 'IP: ' + ip
                    });
                    addFilterTag('ip', ip, ip);
                }

                var status = $('input[name="statusFilter"]:checked').val();
                if (status) {
                    var statusText = status === 'success' ? 'Success' : 'Error';
                    filters.push({
                        type: 'status',
                        value: status,
                        text: statusText
                    });
                    addFilterTag('status', statusText, status);
                }

                var dateRange = $('#dateRange').val();
                if (dateRange) {
                    filters.push({
                        type: 'date',
                        value: dateRange,
                        text: 'Date: ' + dateRange
                    });
                    addFilterTag('date', dateRange, dateRange);
                }

                if (filters.length > 0) {
                    $('#activeFilters').removeClass('d-none');
                } else {
                    $('#activeFilters').addClass('d-none');
                }
            }

            function addFilterTag(type, text, value) {
                var tagHtml = `
                <span class="badge bg-primary d-flex align-items-center" data-type="${type}" data-value="${value}">
                    ${text}
                    <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.5rem;" 
                            onclick="removeFilterTag('${type}')"></button>
                </span>
            `;
                $('#filterTags').append(tagHtml);
            }

            window.removeFilterTag = function(type) {
                $(`#filterTags .badge[data-type="${type}"]`).remove();
                switch (type) {
                    case 'user':
                        $('#userFilter').val('');
                        break;
                    case 'activity':
                        $('#activityTypeFilter').val('');
                        break;
                    case 'model':
                        $('#modelFilter').val('');
                        break;
                    case 'search':
                        $('#searchText').val('');
                        break;
                    case 'ip':
                        $('#ipFilter').val('');
                        break;
                    case 'status':
                        $('#statusAll').prop('checked', true);
                        break;
                    case 'date':
                        $('#dateRange').val('');
                        break;
                }

                applyFilters();
            };

            $('#applyFilters').click(applyFilters);
            $('#resetFilters').click(resetFilters);
            $('#clearActiveFilters').click(resetFilters);
            $('#clearSearch').click(function() {
                $('#searchText').val('');
                removeFilterTag('search');
            });

            $('#searchText, #ipFilter').keypress(function(e) {
                if (e.which == 13) {
                    applyFilters();
                    e.preventDefault();
                }
            });

            let filterTimeout;
            $('#userFilter, #activityTypeFilter, #modelFilter, input[name="statusFilter"]').change(function() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(applyFilters, 300);
            });

            $('#exportCSV').click(function() {
                exportData('csv');
            });

            $('#exportPDF').click(function() {
                exportData('pdf');
            });

            $('#exportExcel').click(function() {
                exportData('excel');
            });

            function exportData(type) {
                var params = {
                    user_id: $('#userFilter').val(),
                    activity_type: $('#activityTypeFilter').val(),
                    model: $('#modelFilter').val(),
                    search_text: $('#searchText').val(),
                    ip_address: $('#ipFilter').val(),
                    status: $('input[name="statusFilter"]:checked').val(),
                    export_type: type,
                    _token: '{{ csrf_token() }}'
                };

                var dateRange = $('#dateRange').val();
                if (dateRange) {
                    var dates = dateRange.split(' to ');
                    params.date_from = dates[0];
                    params.date_to = dates[1] || dates[0];
                }

                var form = document.createElement('form');
                form.method = 'GET';
                form.action = "{{ route('admin.activity-log.export') }}";
                form.target = '_blank';

                for (var key in params) {
                    if (params[key] !== undefined && params[key] !== '') {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = params[key];
                        form.appendChild(input);
                    }
                }

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }

            setInterval(function() {
                if (!$('#activityLogFilters input:focus').length && !$('#activityLogFilters select:focus')
                    .length) {
                    table.ajax.reload(null, false);
                }
            }, 30000);

            $('[data-bs-toggle="tooltip"]').tooltip();

            updateActiveFiltersDisplay();

            $('#searchText').on('keyup', function() {
                table.search($(this).val()).draw();
            });
        });
    </script>
@endpush
