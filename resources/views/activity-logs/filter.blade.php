<form id="activityLogFilters">
    <div class="row">
        <!-- User Filter -->
        <div class="col-md-3">
            <label for="userFilter" class="form-label small fw-bold">User</label>
            <select id="userFilter" class="form-control form-control-sm select @error('user_id') is-invalid @enderror">
                <option value="">All Users</option>
                @foreach ($users as $item)
                    <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                        {{ isset($user->id) && $user->id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                        ({{ $item->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Activity Type Filter -->
        <div class="col-md-3">
            <label for="activityTypeFilter" class="form-label small fw-bold">Activity
                Type</label>
            <select id="activityTypeFilter"
                class="form-control form-control-sm select @error('activity_type') is-invalid @enderror">
                <option value="">All Types</option>
                <option value="created">Created</option>
                <option value="updated">Updated</option>
                <option value="deleted">Deleted</option>
                <option value="imported">Imported</option>
                <option value="exported">Exported</option>
                <option value="enabled">Enabled</option>
                <option value="disabled">Disabled</option>
            </select>
        </div>

        <!-- Model Filter -->
        <div class="col-md-3">
            <label for="modelFilter" class="form-label small fw-bold">Affected Model</label>
            <select id="modelFilter" class="form-control form-control-sm select @error('model') is-invalid @enderror">
                <option value="">All Models</option>
                <option value="User">User</option>
                <option value="Warehouse">Warehouse</option>
                <option value="Warehousesurvey">Survey</option>
                <option value="Warehousesurveyquestions">Question</option>
                <option value="Region">Region</option>
                <option value="District">District</option>
                <option value="Division">Division</option>
                <option value="Ward">Ward</option>
                <option value="Aggregator">Client</option>
                <option value="Farm">Partner</option>
                <option value="Bidder">Bidder</option>
                <option value="warehouseinspection">Warehouse Inspection</option>
            </select>
        </div>

        <!-- Date Range -->
        <div class="col-md-3">
            <label for="dateRange" class="form-label small fw-bold">Date Range</label>
            <input type="text" id="dateRange" class="form-control form-control-sm" placeholder="Select date range">
        </div>

        <!-- Search Text -->
        <div class="col-md-6">
            <label for="searchText" class="form-label small fw-bold">Search in
                Description</label>
            <div class="input-group input-group-sm">
                <input type="search" id="searchText" class="form-control" placeholder="Search activity description...">
            </div>
        </div>

        <!-- IP Address -->
        <div class="col-md-3">
            <label for="ipFilter" class="form-label small fw-bold">IP Address</label>
            <input type="text" id="ipFilter" class="form-control form-control-sm" placeholder="Filter by IP">
        </div>

        <!-- Status Filter -->
        <div class="col-md-3">
            <label class="form-label small fw-bold">Action Status</label>
            <div class="btn-group btn-group-sm w-100" role="group">
                <input type="radio" class="btn-check" name="statusFilter" id="statusAll" value="" checked>
                <label class="btn" for="statusAll">All</label>

                <input type="radio" class="btn-check" name="statusFilter" id="statusSuccess" value="success">
                <label class="btn" for="statusSuccess">
                    <i class="fas fa-check me-1"></i>Success
                </label>

                <input type="radio" class="btn-check" name="statusFilter" id="statusError" value="error">
                <label class="btn" for="statusError">
                    <i class="fas fa-times me-1"></i>Error
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-md-12">
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <button type="button" id="applyFilters" class="btn btn-sm btn-primary">
                        <i class="fas fa-search me-1"></i> Apply Filters
                    </button>
                    <button type="button" id="resetFilters" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-redo me-1"></i> Reset All
                    </button>
                </div>
                @if (Auth::user()->hasRole(['admin', 'super_admin', 'super admin']) || Auth::user()->can('edit users'))
                    <div class="d-flex align-items-center">
                        <span class="me-2 small">Export:</span>
                        <div class="btn-group btn-group-sm">
                            <button type="button" id="exportCSV" class="btn btn-outline-success">
                                <i class="fas fa-file-csv me-1"></i> CSV
                            </button>
                            <button type="button" id="exportPDF" class="btn btn-outline-danger">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </button>
                            <button type="button" id="exportExcel" class="btn btn-outline-primary">
                                <i class="fas fa-file-excel me-1"></i> Excel
                            </button>
                        </div>
                    </div>
                    <!-- Export Buttons -->
                @endif
            </div>
        </div>
    </div>
</form>

<!-- Active Filters Display -->
<div id="activeFilters" class="mt-3 d-none">
    <div class="d-flex align-items-center">
        <span class="me-2 small fw-bold">Active Filters:</span>
        <div id="filterTags" class="d-flex flex-wrap gap-2"></div>
        <button id="clearActiveFilters" class="btn btn-sm btn-link text-danger ms-auto">
            <i class="fas fa-times me-1"></i> Clear All
        </button>
    </div>
</div>
