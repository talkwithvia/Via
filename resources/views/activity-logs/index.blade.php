@extends('layouts.app')

@section('subtitle', 'Activity Logs')
@section('content_header_title', 'Activity Logs')
@section('content_header_subtitle', 'Management')

@section('content_body')
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
