@extends('layouts.app')

@section('subtitle', 'Permission Management')
@section('content_header_title', 'Permission')
@section('content_header_subtitle', 'Management')

@section('content_body')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.permissions.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Grant Permissions to <b
                            class="badge badge-primary text-uppercase rounded-pill">{{ $role->name }}</b></h5>
                    <label class="mb-0"><input type="checkbox" id="master-toggle"> Select all</label>
                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width:22%;">Resource</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($permissionGroups as $group => $permissions)
                            @php
                                $slug = \Illuminate\Support\Str::slug($group);
                                // Count selected permissions in this group
                                $selectedInGroup = 0;
                                foreach ($permissions as $permission) {
                                    if (in_array($permission->name, $rolePermissions)) {
                                        $selectedInGroup++;
                                    }
                                }
                            @endphp
                            <tr>
                                <td class="align-top">
                                    <div class="d-flex align-items-center mb-2">
                                        <input type="checkbox" class="group-toggle me-3" data-group="{{ $slug }}"
                                            style="margin-right:8px !important;"
                                            {{ $selectedInGroup === count($permissions) ? 'checked' : '' }}>
                                        <strong>{{ $group }}</strong>
                                    </div>
                                    <div class="small text-muted">
                                        <span class="badge bg-info rounded-pill">
                                            {{ $selectedInGroup }}/{{ count($permissions) }} selected
                                        </span>
                                        @if ($group === 'Geographical Entities')
                                            <div class="mt-1">
                                                <small>
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    Regions, Districts, Divisions, Wards
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            @php
                                                // Extract action (first word)
                                                $action = '';
                                                $displayName = '';

                                                if (str_contains($permission->name, ' ')) {
                                                    $parts = explode(' ', $permission->name, 2);
                                                    $action = $parts[0];
                                                    $resource = $parts[1] ?? '';
                                                } elseif (str_contains($permission->name, '.')) {
                                                    $parts = explode('.', $permission->name, 2);
                                                    $action = $parts[0];
                                                    $resource = $parts[1] ?? '';
                                                } else {
                                                    $resource = $permission->name;
                                                }

                                                // Transform specific resource names for display
                                                $displayResource = $resource;

                                                // Singular to plural transformations
                                                $transformations = [
                                                    'farm' => 'Partner',
                                                    'farms' => 'Partner',
                                                    'aggregator' => 'Client',
                                                    'aggregators' => 'Client',
                                                    'user' => 'User',
                                                    'users' => 'User',
                                                    'role' => 'Role',
                                                    'roles' => 'Role',
                                                    'permission' => 'Permission',
                                                    'permissions' => 'Permission',
                                                ];

                                                // Check for exact matches first, then partial matches
                                                if (isset($transformations[$resource])) {
                                                    $displayResource = $transformations[$resource];
                                                } else {
                                                    // Handle cases like "create farm" -> "create Partner"
                                                    foreach ($transformations as $key => $value) {
                                                        if (str_contains(strtolower($resource), $key)) {
                                                            $displayResource = str_ireplace($key, $value, $resource);
                                                            break;
                                                        }
                                                    }
                                                }

                                                // Combine action and transformed resource
                                                if ($action) {
                                                    $displayName =
                                                        $action .
                                                        ' ' .
                                                        ucwords(str_replace(['-', '_', '.'], ' ', $displayResource));
                                                } else {
                                                    $displayName = ucwords(
                                                        str_replace(['-', '_', '.'], ' ', $displayResource),
                                                    );
                                                }

                                                // Badge color mapping
                                                $badgeClasses = [
                                                    'view' => 'bg-primary',
                                                    'read' => 'bg-primary',
                                                    'show' => 'bg-primary',
                                                    'create' => 'bg-success',
                                                    'store' => 'bg-success',
                                                    'add' => 'bg-success',
                                                    'edit' => 'bg-warning text-dark',
                                                    'update' => 'bg-warning text-dark',
                                                    'delete' => 'bg-danger',
                                                    'destroy' => 'bg-danger',
                                                    'remove' => 'bg-danger',
                                                    'toggle' => 'bg-info',
                                                    'change' => 'bg-info',
                                                    'assign' => 'bg-purple',
                                                    'manage' => 'bg-purple',
                                                    'access' => 'bg-purple',
                                                    'import' => 'bg-teal',
                                                    'export' => 'bg-indigo',
                                                    'approve' => 'bg-success',
                                                    'reject' => 'bg-danger',
                                                    'download' => 'bg-secondary',
                                                    'upload' => 'bg-secondary',
                                                ];

                                                $badgeClass = $badgeClasses[$action] ?? 'bg-secondary';
                                            @endphp

                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                        name="permissions[]" value="{{ $permission->name }}"
                                                        id="perm_{{ $permission->id }}" data-group="{{ $slug }}"
                                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label d-flex align-items-center"
                                                        for="perm_{{ $permission->id }}">
                                                        <span class="me-2">
                                                            {{ $displayName }}
                                                        </span>
                                                        @if ($action)
                                                            <span class="badge badge-sm {{ $badgeClass }}">
                                                                {{ $action }}
                                                            </span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Total selected: <span id="selected-count" class="fw-bold">0</span>/
                            {{ count($data['permissions']) }}
                            permissions
                        </span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .group-toggle:indeterminate {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .badge-purple {
            background-color: #6f42c1 !important;
            color: white;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check-label {
            width: 100%;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const master = document.getElementById('master-toggle');
            const permCheckboxes = () => [...document.querySelectorAll('.permission-checkbox')];
            const groupToggles = () => [...document.querySelectorAll('.group-toggle')];

            // Function to update selected count
            function updateSelectedCount() {
                const selected = permCheckboxes().filter(p => p.checked).length;
                document.getElementById('selected-count').textContent = selected;
                return selected;
            }

            function updateGroup(slug) {
                const perms = document.querySelectorAll(`.permission-checkbox[data-group="${slug}"]`);
                const checked = [...perms].filter(p => p.checked).length;
                const groupBox = document.querySelector(`.group-toggle[data-group="${slug}"]`);
                if (!groupBox) return;
                groupBox.checked = checked === perms.length && perms.length > 0;
                groupBox.indeterminate = checked > 0 && checked < perms.length;
            }

            function updateMaster() {
                const all = permCheckboxes();
                const checkedCount = all.filter(c => c.checked).length;
                const total = all.length;

                master.checked = checkedCount === total && total > 0;
                master.indeterminate = checkedCount > 0 && checkedCount < total;

                // Update selected count
                updateSelectedCount();
            }

            // Init state - update all groups and master
            groupToggles().forEach(g => updateGroup(g.dataset.group));
            updateMaster();

            // Master toggle
            master?.addEventListener('change', () => {
                const checked = master.checked;
                permCheckboxes().forEach(cb => cb.checked = checked);
                groupToggles().forEach(g => {
                    g.checked = checked;
                    g.indeterminate = false;
                });
                updateSelectedCount();
            });

            // Group toggle
            document.querySelectorAll('.group-toggle').forEach(g => {
                g.addEventListener('change', () => {
                    document.querySelectorAll(
                            `.permission-checkbox[data-group="${g.dataset.group}"]`)
                        .forEach(cb => cb.checked = g.checked);
                    g.indeterminate = false;
                    updateMaster();
                });
            });

            // Individual check updates group/master
            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    updateGroup(cb.dataset.group);
                    updateMaster();
                });
            });
        });
    </script>
@endpush
