<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    protected function formatIdValue($key, $id)
    {
        if (empty($id) || !is_numeric($id)) {
            return $this->formatValue($id);
        }

        // Determine model type and route based on the key
        $keyWithoutId = str_replace('_id', '', $key);
        $displayType = ucwords(str_replace('_', ' ', $keyWithoutId));

        // Get route based on key
        $route = '';
        $routeName = '';

        switch ($keyWithoutId) {
            case 'user':
                $route = route('admin.users.show', $id);
                $routeName = 'user.show';
                break;
            case 'causer':
                $route = route('admin.users.show', $id);
                $routeName = 'users.show';
                break;
            case 'subject':
                // For subject_id, we need to know the model type
                return "<span class='badge bg-info'>ID: {$id}</span>";
                break;
            case 'role':
                $route = route('admin.roles.index', $id);
                $routeName = 'roles.show';
                break;
            case 'permission':
                $route = route('admin.permissions.show', $id);
                $routeName = 'permissions.show';
                break;

            default:
                // Try to guess route based on common patterns
                if ($keyWithoutId === 'id') {
                    return "<span class='badge bg-secondary'>ID: {$id}</span>";
                }
                return $this->formatValue($id);
        }

        if ($route) {
            // Try to fetch the record name for better display
            try {
                $modelName = '';
                switch ($keyWithoutId) {
                    case 'user':
                        $model = User::find($id);
                        $modelName = $model->name ?? $model->email ?? '';
                        break;
                }

                if (!empty($modelName)) {
                    return "<a href='{$route}' target='_blank' class='badge bg-primary text-decoration-none'>
                          <i class='fa fa-eye me-1'></i> {$modelName}
                        </a>";
                } else {
                    return "<a href='{$route}' target='_blank' class='badge bg-info text-decoration-none'>
                          <i class='fa fa-eye me-1'></i> {$displayType} #{$id}
                        </a>";
                }
            } catch (\Exception $e) {
                return "<a href='{$route}' target='_blank' class='badge bg-info text-decoration-none'>
                      <i class='fa fa-eye me-1'></i> {$displayType} #{$id}
                    </a>";
            }
        }

        return $this->formatValue($id);
    }
    private function formatWarehouseInspectionMediaArray($mediaArray)
    {
        if (empty($mediaArray)) {
            return '<span class="text-muted">No media</span>';
        }

        $html = '<div class="warehouse-media-gallery">';

        foreach ($mediaArray as $index => $media) {
            $html .= $this->formatSingleWarehouseMedia($media, $index + 1);
        }

        $html .= '</div>';
        return $html;
    }

    private function formatSingleWarehouseMedia($media, $index = 1)
    {
        if (!is_array($media)) {
            return '';
        }

        $mediaId = $media['id'] ?? 'N/A';
        $details = htmlspecialchars($media['details'] ?? 'No description', ENT_QUOTES, 'UTF-8');
        $location = $media['location'] ?? '';

        $imageUrl = $location ? asset($location) : asset('images/default-image.webp');

        // Format timestamps
        $createdAt = isset($media['created_at']) ?
            \Carbon\Carbon::parse($media['created_at'])->format('d M Y, h:i A') : 'N/A';

        $html = '<div class="media-item mb-2 p-2 border-0 rounded">';

        // Header
        $html .= '<div class="d-flex justify-content-between align-items-start mb-1">';
        $html .= '<strong class="small">Media #' . $index . '</strong>';
        $html .= '<a href="' . $location . '" target="_blank" class="badge bg-info small"><span class="fa fa-eye"></span></a>';
        $html .= '</div>';

        // Image preview
        $html .= '<div class="text-center mb-1">';
        $html .= '<a href="' . $imageUrl . '" target="_blank" class="d-inline-block">';
        $html .= '<img src="' . $imageUrl . '" ';
        $html .= 'style="max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" ';
        $html .= 'onerror="this.onerror=null; this.src=\'' . asset('images/default-image.webp') . '\'" ';
        $html .= 'alt="' . $details . '">';
        $html .= '</a>';
        $html .= '</div>';

        // Details
        $html .= '<div class="small mb-1"><strong>Details:</strong> ' . $details . '</div>';

        // Timestamp
        $html .= '<div class="small text-muted">Uploaded: ' . $createdAt . '</div>';

        // View button
        $html .= '<div class="text-center mt-1">';
        $html .= '<a href="' . $imageUrl . '" target="_blank" class="btn btn-sm btn-outline-primary" style="padding: 1px 6px; font-size: 10px;">';
        $html .= '<i class="fas fa-external-link-alt me-1"></i>View';
        $html .= '</a>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Activity::with('causer')->latest();

            if ($request->has('user_id') && $request->user_id) {
                $query->where('causer_id', $request->user_id);
            }

            if ($request->has('activity_type') && $request->activity_type) {
                $query->where('description', 'like', "%{$request->activity_type}%");
            }
            if ($request->has('model') && $request->model) {
                if ($request->ajax() && $request->has('debug_models')) {
                    $existingModels = Activity::select('subject_type')
                        ->whereNotNull('subject_type')
                        ->distinct()
                        ->pluck('subject_type')
                        ->toArray();
                }

                $modelName = $request->model;
                $modelClass1 = 'App\\Models\\' . $modelName;
                $modelClass2 = $modelName;
                $smallModelName = strtolower($modelName);
                $modelClass3 = class_basename($modelName);

                $query->where(function ($q) use ($modelClass1, $modelClass2, $modelClass3, $modelName, $smallModelName) {
                    $q->where('subject_type', $modelClass1)
                        ->orWhere('subject_type', $modelClass2)
                        ->orWhere('subject_type', 'LIKE', '%' . $modelClass3 . '%')
                        ->orWhereRaw('log_name LIKE ?', ['%' . $modelName . '%'])
                        ->orWhereRaw("properties LIKE ?", ['%"affected_model":"' . $modelName . '"%'])
                        ->orWhereRaw("properties LIKE ?", ['%"model":"' . $modelName . '"%'])
                        ->orWhereRaw("JSON_EXTRACT(properties, '$.model') = ?", [$modelName]);
                });
            }

            if ($request->has('search_text') && $request->search_text) {
                $search = $request->search_text;
                $searchTerm = '%' . $search . '%';

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('description', 'like', $searchTerm)
                        ->orWhere('subject_type', 'like', $searchTerm)
                        ->orWhereHas('causer', function ($q2) use ($searchTerm) {
                            $q2->where('name', 'like', $searchTerm)
                                ->orWhere('email', 'like', $searchTerm);
                        })
                        ->orWhereRaw("properties LIKE ?", [$searchTerm]); // Simple string search
                });
            }
            if ($request->has('ip_address') && $request->ip_address) {
                $query->where('properties->ip', 'like', "%{$request->ip_address}%")
                    ->orWhere('properties->ip_address', 'like', "%{$request->ip_address}%");
            }

            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Status filter
            if ($request->has('status') && $request->status) {
                if ($request->status == 'success') {
                    $query->where('properties->success', true);
                } elseif ($request->status == 'error') {
                    $query->where('properties->error', true)
                        ->orWhere('description', 'like', '%error%')
                        ->orWhere('description', 'like', '%failed%');
                }
            }

            return DataTables::of($query)
                ->addColumn(
                    'timestamp',
                    fn($activity) =>
                    $activity->created_at->format('d M Y, h:i A') .
                        '<br><small class="text-muted">' . $activity->created_at->diffForHumans() . '</small>'
                )

                ->addColumn('user', function ($activity) {
                    $user = $activity->causer;

                    if ($user) {
                        $avatar = $user->image
                            ? asset($user->image)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=fff&background=4e73df&size=40';

                        return '
                       <div class="d-flex align-items-center" data-bs-toggle="tooltip" data-bs-html="true" 
                            title="<strong>' . htmlspecialchars($user->name) . '</strong><br>' . $user->email . '">
                           <div class="flex-shrink-0">
                               <img src="' . $avatar . '" 
                                    alt="' . htmlspecialchars($user->name) . '"
                                    class="rounded-circle"
                                    width="40"
                                    height="40"
                                    style="object-fit: cover;">
                           </div>
                           <div class="flex-grow-1 ml-1" style="margin-left:3px;">
                               <div class="fw-bold text-truncate" style="max-width: 150px;">' . $user->name . '</div>
                               <small class="text-muted text-truncate d-block" style="max-width: 150px;">' . $user->email . '</small>
                           </div>
                       </div>';
                    }

                    return '<span class="badge bg-secondary">System</span>';
                })

                ->addColumn('description', function ($activity) {
                    $desc = $activity->description;
                    $props = $activity->properties ?? [];
                    // Add project-specific details
                    $details = [];

                    // Import activities
                    if (isset($props['imported_regions_count'])) {
                        $details[] = "<span class='badge bg-success'>Regions: {$props['imported_regions_count']}</span>";
                    }
                    if (isset($props['imported_districts_count'])) {
                        $details[] = "<span class='badge bg-primary'>Districts: {$props['imported_districts_count']}</span>";
                    }
                    if (isset($props['imported_divisions_count'])) {
                        $details[] = "<span class='badge bg-info'>Divisions: {$props['imported_divisions_count']}</span>";
                    }
                    if (isset($props['imported_wards_count'])) {
                        $details[] = "<span class='badge bg-warning'>Wards: {$props['imported_wards_count']}</span>";
                    }

                    // Survey activities
                    if (isset($props['survey_id'])) {
                        $details[] = "<span class='badge bg-dark'>Survey #{$props['survey_id']}</span>";
                    }

                    // Warehouse activities
                    if (isset($props['warehouse_id'])) {
                        $details[] = "<span class='badge bg-secondary'>Warehouse #{$props['warehouse_id']}</span>";
                    }

                    // Question activities
                    if (isset($props['question_ids']) && is_array($props['question_ids'])) {
                        $count = count($props['question_ids']);
                        $details[] = "<span class='badge bg-info'>{$count} question(s)</span>";
                    }

                    // Status changes
                    if (isset($props['old_status']) && isset($props['new_status'])) {
                        $details[] = "<span class='badge bg-warning'>Status: {$props['old_status']} → {$props['new_status']}</span>";
                    }

                    // Add event badge
                    $event = $activity->event;
                    if ($event) {
                        $eventBadgeColor = match (strtolower($event)) {
                            'created', 'added' => 'success',
                            'updated', 'modified' => 'primary',
                            'deleted', 'removed' => 'danger',
                            'imported', 'exported' => 'info',
                            'enabled', 'activated' => 'warning',
                            'disabled', 'deactivated' => 'dark',
                            'toggled' => 'secondary',
                            default => 'secondary'
                        };
                        $details[] = "<span class='badge bg-{$eventBadgeColor}'>{$event}</span>";
                    }

                    if (!empty($details)) {
                        $desc .= '<div class="mt-2">' . implode(' ', $details) . '</div>';
                    }

                    return $desc;
                })

                ->addColumn('affected', function ($activity) {
                    $subjectType = $activity->subject_type;
                    $subjectId = $activity->subject_id;
                    $props = $activity->properties ?? [];

                    if ($subjectType && $subjectId) {
                        $modelName = class_basename($subjectType);

                        // Map model names to user-friendly versions
                        $modelDisplayNames = [
                            'Warehousesurveys' => 'Survey',
                            'Warehousequestions' => 'Question',
                            'Warehousesurveyquestions' => 'Survey Question',
                            'Warehouse' => 'Warehouse',
                            'User' => 'User',
                            'Region' => 'Region',
                            'District' => 'District',
                            'Division' => 'Division',
                            'Ward' => 'Ward',
                            'Aggregator' => 'Client',
                            'Type' => 'Type',
                            'Partner' => 'Partner',
                            'Farm' => 'Partner',
                            'Client' => 'Client',
                            'ProduceCatalogue' => 'Produce Catalogue',
                            'Role' => 'Role',
                            'Permission' => 'Permission',
                            'ActivityLog' => 'Activity Log',
                            'Activity' => 'Activity',
                            'Bidder' => 'Bidder',
                            'warehousesurveys' => 'Survey',
                            'warehousequestions' => 'Question',
                            'warehousesurveyquestions' => 'Survey Question',
                            'warehouse' => 'Warehouse',
                            'user' => 'User',
                            'region' => 'Region',
                            'district' => 'District',
                            'division' => 'Division',
                            'ward' => 'Ward',
                            'aggregator' => 'Client',
                            'type' => 'Type',
                            'partner' => 'Partner',
                            'farm' => 'Partner',
                            'client' => 'Client',
                            'produce_catalogue' => 'Produce Catalogue',
                            'role' => 'Role',
                            'permission' => 'Permission',
                            'activity_log' => 'Activity Log',
                            'activity' => 'Activity',
                            'bidder' => 'Bidder',
                            'Warehouseinspection' => 'Warehouse Inspection',
                            'warehouseinspection' => 'Warehouse Inspection',
                        ];

                        $displayName = $modelDisplayNames[$modelName] ?? $modelName;

                        try {
                            $modelClass = $subjectType;
                            if (class_exists(class: $modelClass)) {
                                $record = $modelClass::find($subjectId);
                                if ($record && method_exists($record, 'getNameAttribute')) {
                                    $name = $record->name;
                                } elseif ($record && isset($record->name)) {
                                    $name = $record->name;
                                } elseif ($record && isset($record->title)) {
                                    $name = $record->title;
                                } elseif ($record && isset($record->email)) {
                                    $name = $record->email;
                                } else {
                                    $name = "ID: {$subjectId}";
                                }
                                $route = '';
                                switch ($modelName) {
                                    case 'user':
                                        $route = route('user.show', $subjectId);
                                        break;
                                    case 'region':
                                        $route = route('region.show', $subjectId);
                                        break;
                                    case 'district':
                                        $route = route('district.show', $subjectId);
                                        break;
                                    case 'division':
                                        $route = route('division.show', $subjectId);
                                        break;
                                    case 'ward':
                                        $route = route('ward.show', $subjectId);
                                        break;
                                    case 'aggregator':
                                        $route = route('aggregator.show', $subjectId);
                                        break;
                                    case 'type':
                                        $route = route('type.show', $subjectId);
                                        break;
                                    case 'warehouse':
                                        $route = route('warehouse.show', $subjectId);
                                        break;
                                    case 'survey':
                                        $route = route('survey.show', $subjectId);
                                        break;
                                    case 'question':
                                        $route = route('question.show', $subjectId);
                                        break;
                                    case 'bidder_id':
                                        $route = route('bidder.show', $subjectId);
                                        break;
                                    case 'client_id':
                                        $route = route('aggregators.show', $subjectId);
                                        break;
                                    case 'farm_id':
                                        $route = route('farm.show', $subjectId);
                                        break;
                                    case 'partner_id':
                                        $route = route('partner.show', $subjectId);
                                        break;
                                    case 'produce_catalogue_id':
                                        $route = route('produce_catalogue.show', $subjectId);
                                        break;
                                    case 'role_id':
                                        $route = route('role.show', $subjectId);
                                        break;
                                    case 'permission_id':
                                        $route = route('permission.show', $subjectId);
                                        break;
                                    default:
                                        $route = '#';
                                }
                                return "
                            <div class='fw-bold'>{$displayName}</div>
                            <div>
                                <a href='{$route}' target='_blank' class='btn btn-sm btn-outline-primary mt-1'>
                                  <small class='fa fa-eye'></small> 

                                </a>
                            </div>
                        ";
                            }
                        } catch (\Exception $e) {
                            return '-';
                        }

                        return "<span class='badge bg-info'>{$displayName} #{$subjectId}</span>";
                    }

                    if (isset($props['affected_model'])) {
                        return "<span class='badge bg-secondary'>{$props['affected_model']}</span>";
                    }

                    return '—';
                })

                ->addColumn('before', function ($activity) {
                    $props = $activity->properties ?? [];
                    $before = $props['before'] ?? [];
                    $after = $props['after'] ?? [];

                    $changes = [];

                    foreach ($before as $key => $oldValue) {
                        $newValue = $after[$key] ?? null;

                        // Skip if values are the same
                        if ($oldValue == $newValue) {
                            continue;
                        }

                        $keyDisplay = ucwords(str_replace(['_', '-'], ' ', $key));

                        // Handle ID fields specially - create clickable links
                        if (str_ends_with($key, '_id') || $key === 'id') {
                            $formattedValue = $this->formatIdValue($key, $oldValue);
                        }
                        // Format timestamp fields specially
                        elseif (in_array($key, ['created_at', 'updated_at', 'deleted_at', 'timestamp'])) {
                            try {
                                $formattedValue = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('d M Y, h:i A') .
                                    '<br><small class="text-muted">' . \Carbon\Carbon::parse($oldValue)->diffForHumans() . '</small>' :
                                    '—';
                            } catch (\Exception $e) {
                                $formattedValue = $this->formatValue($oldValue);
                            }
                        } else {
                            $formattedValue = $this->formatValue($oldValue);
                        }

                        $changes[] = "
                          <div class='mb-2'>
                              <strong class='small'>{$keyDisplay}:</strong>
                              <div class='text-danger small'>{$formattedValue}</div>
                          </div>";
                    }

                    if (empty($changes)) {
                        foreach ($props as $key => $value) {
                            if (!in_array($key, ['before', 'after', 'ip', 'ip_address', 'timestamp', 'model'])) {
                                $keyDisplay = ucwords(str_replace(['_', '-'], ' ', $key));

                                // Handle ID fields specially
                                if (str_ends_with($key, '_id') || $key === 'id') {
                                    $formattedValue = $this->formatIdValue($key, $value);
                                } else {
                                    $formattedValue = $this->formatValue($value);
                                }

                                $changes[] = "<div class=''><strong class='small'>{$keyDisplay}:</strong> <span class='small'>{$formattedValue}</span></div>";
                            }
                        }
                    }

                    return !empty($changes) ? '<div class="changes-container" style="max-height: 150px; overflow-y: auto;">' . implode('', $changes) . '</div>' : '—';
                })

                ->addColumn('after', function ($activity) {
                    $props = $activity->properties ?? [];
                    $before = $props['before'] ?? [];
                    $after = $props['after'] ?? [];

                    $changes = [];

                    foreach ($after as $key => $newValue) {
                        $oldValue = $before[$key] ?? null;

                        // Skip if values are the same
                        if ($oldValue == $newValue) {
                            continue;
                        }

                        $keyDisplay = ucwords(str_replace(['_', '-'], ' ', $key));

                        // SPECIAL HANDLING: Check for warehouseinspectionmedia array
                        if ($key === 'warehouseinspectionmedia' && is_array($newValue)) {
                            $formattedValue = $this->formatWarehouseInspectionMediaArray($newValue);
                        }
                        // Handle ID fields specially - create clickable links
                        elseif (str_ends_with($key, '_id') || $key === 'id') {
                            $formattedValue = $this->formatIdValue($key, $newValue);
                        }
                        // Format timestamp fields specially
                        elseif (in_array($key, ['created_at', 'updated_at', 'deleted_at', 'timestamp'])) {
                            try {
                                $formattedValue = $newValue ? \Carbon\Carbon::parse($newValue)->format('d M Y, h:i A') .
                                    '<br><small class="text-muted">' . \Carbon\Carbon::parse($newValue)->diffForHumans() . '</small>' :
                                    '—';
                            } catch (\Exception $e) {
                                $formattedValue = $this->formatValue($newValue);
                            }
                        } else {
                            $formattedValue = $this->formatValue($newValue);
                        }

                        $changes[] = "
                              <div class='mb-2'>
                                  <strong class='small'>{$keyDisplay}:</strong>
                                  <div class='text-success small'>{$formattedValue}</div>
                              </div>";
                    }

                    return !empty($changes) ? '<div class="changes-container" style="max-height: 150px; overflow-y: auto;">' . implode('', $changes) . '</div>' : '—';
                })


                ->addColumn('ip', function ($activity) {
                    $props = $activity->properties ?? [];
                    $ip = $props['ip'] ?? $props['ip_address'] ?? null;

                    if ($ip) {
                        return "
                    <code>{$ip}</code>
                    <br>
                    <small class='text-muted'>" . ($this->getLocationFromIP($ip) ?: 'Location unknown') . "</small>
                ";
                    }

                    return '—';
                })

                ->rawColumns(['timestamp', 'user', 'description', 'affected', 'before', 'after', 'ip'])
                ->make(true);
        }

        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        return view('activity-logs.index', compact('users'));
    }



    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    private function formatJsonData($data)
    {
        if (empty($data)) {
            return '<span class="text-muted">—</span>';
        }

        $output = [];
        foreach ($data as $key => $value) {
            $keyDisplay = ucwords(str_replace(['_', '-'], ' ', $key));

            if (is_array($value) || is_object($value)) {
                $formattedValue = $this->formatJsonData((array)$value);
            } else {
                $formattedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }

            $output[] = "<div><strong>{$keyDisplay}:</strong> {$formattedValue}</div>";
        }

        return '<div class="json-container" style="max-height: 120px; overflow-y: auto; padding: 8px; background: #f8f9fa; border-radius: 4px;">' .
            implode('', $output) . '</div>';
    }
    private function formatWarehouseInspectionMedia($data)
    {
        $html = '<div class="warehouse-media-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px; margin: 5px 0;">';

        // Display ID
        if (isset($data['id'])) {
            $html .= "<div class='mb-2'><strong>Media ID:</strong> {$data['id']}</div>";
        }

        // Display details/description
        if (isset($data['details'])) {
            $details = htmlspecialchars($data['details'], ENT_QUOTES, 'UTF-8');
            $html .= "<div class='mb-2'><strong>Description:</strong> {$details}</div>";
        }

        // Display image preview if location exists
        if (isset($data['location']) && !empty($data['location'])) {
            $imageUrl = asset($data['location']);
            $html .= "
        <div class='mb-2'>
            <strong>Image:</strong>
            <div class='mt-1'>
                <a href='{$imageUrl}' target='_blank' class='image-preview-link'>
                    <img src='{$imageUrl}' 
                         alt='Warehouse Inspection Media' 
                         style='max-width: 100px; max-height: 100px; 
                                object-fit: cover; border-radius: 4px; 
                                border: 1px solid #ddd;'
                         onerror=\"this.onerror=null; this.src='" . asset('images/default-image.webp') . "';\">
                </a>
            </div>
        </div>";
        }

        // Display timestamps
        if (isset($data['created_at'])) {
            try {
                $createdAt = \Carbon\Carbon::parse($data['created_at'])->format('d M Y, h:i A');
                $html .= "<div class='mb-1'><small class='text-muted'>Created: {$createdAt}</small></div>";
            } catch (\Exception $e) {
                // Do nothing
            }
        }

        if (isset($data['updated_at'])) {
            try {
                $updatedAt = \Carbon\Carbon::parse($data['updated_at'])->format('d M Y, h:i A');
                $html .= "<div><small class='text-muted'>Updated: {$updatedAt}</small></div>";
            } catch (\Exception $e) {
                // Do nothing
            }
        }

        // Optional: Add download/view button
        if (isset($data['location'])) {
            $html .= "
        <div class='mt-2'>
            <a href='{$imageUrl}' 
               target='_blank' 
               class='btn btn-sm btn-outline-primary' 
               style='padding: 2px 8px; font-size: 12px;'>
               <i class='fas fa-external-link-alt'></i> View Full
            </a>
        </div>";
        }

        $html .= '</div>';

        return $html;
    }
    public function export(Request $request)
    {
        $query = Activity::with('causer');

        $this->applyFilters($query, $request);

        $activities = $query->latest()->get();


        $filename = $this->generateFilename($request);

        switch ($request->export_type) {
            case 'csv':
                return $this->exportToCSV($activities, $filename);
            case 'pdf':
                return $this->exportToPDF($activities, $filename);
            case 'excel':
                return $this->exportToExcel($activities, $filename);
            default:
                return $this->exportToExcel($activities, $filename);
        }
    }

    private function applyFilters($query, $request)
    {
        if ($request->has('user_id') && $request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        if ($request->has('activity_type') && $request->activity_type) {
            $query->where('event', $request->activity_type);
        }

        if ($request->has('model') && $request->model) {
            $modelClass = 'App\\Models\\' . $request->model;
            $query->where('subject_type', $modelClass);
        }

        if ($request->has('search_text') && $request->search_text) {
            $search = $request->search_text;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('properties', 'like', "%{$search}%");
            });
        }

        if ($request->has('ip_address') && $request->ip_address) {
            $query->where('properties->ip', 'like', "%{$request->ip_address}%")
                ->orWhere('properties->ip_address', 'like', "%{$request->ip_address}%");
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
    }

    private function generateFilename($request)
    {
        $filename = 'activity_logs_' . date('Y-m-d_H-i-s');

        $filters = [];
        if ($request->user_id) {
            $filters[] = 'user_' . $request->user_id;
        }
        if ($request->activity_type) {
            $filters[] = 'type_' . $request->activity_type;
        }
        if ($request->model) {
            $filters[] = 'model_' . $request->model;
        }
        if ($request->date_from && $request->date_to) {
            $filters[] = $request->date_from . '_to_' . $request->date_to;
        }

        if (!empty($filters)) {
            $filename .= '_' . implode('_', $filters);
        }

        return $filename;
    }

    /**
     * Export to CSV
     */
    private function exportToExcel($activities, $filename)
    {
        $writer = \Box\Spout\Writer\Common\Creator\WriterEntityFactory::createXLSXWriter();

        $tempFile = tempnam(sys_get_temp_dir(), 'activity_log_') . '.xlsx';
        $writer->openToFile($tempFile);

        $headers = [
            'ID',
            'Timestamp',
            'User Name',
            'User Email',
            'Activity Description',
            'Event Type',
            'Affected Model',
            'Model ID',
            'Before Changes',
            'After Changes',
            'IP Address',
            'Log Category',
            'Created At'
        ];

        $headerRow = \Box\Spout\Writer\Common\Creator\WriterEntityFactory::createRowFromArray($headers);
        $writer->addRow($headerRow);

        Activity::with('causer')
            ->orderByDesc('created_at')
            ->chunk(1000, function ($chunk) use ($writer) {
                foreach ($chunk as $activity) {
                    $rowData = [
                        $activity->id,
                        $activity->created_at->format('Y-m-d H:i:s'),
                        $activity->causer->name ?? 'System',
                        $activity->causer->email ?? '',
                        $activity->description,
                        $activity->event ?? 'N/A',
                        $activity->subject_type ? class_basename($activity->subject_type) : 'N/A',
                        $activity->subject_id ?? 'N/A',
                        $this->formatPropertiesForExport($activity->properties['before'] ?? []),
                        $this->formatPropertiesForExport($activity->properties['after'] ?? []),
                        $activity->properties['ip'] ?? $activity->properties['ip_address'] ?? 'N/A',
                        $activity->log_name ?? 'General',
                        $activity->created_at->format('Y-m-d H:i:s')
                    ];

                    $row = \Box\Spout\Writer\Common\Creator\WriterEntityFactory::createRowFromArray($rowData);
                    $writer->addRow($row);
                }
            });
        $writer->close();

        // Return the file as download
        return response()->download($tempFile, $filename . '.xlsx')->deleteFileAfterSend(true);
    }

    private function exportToCSV($activities, $filename): BinaryFileResponse
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'activity_log_') . '.csv';

        $writer = \Box\Spout\Writer\Common\Creator\WriterEntityFactory::createCSVWriter();

        $writer->setFieldDelimiter(',');
        $writer->setFieldEnclosure('"');
        $writer->setShouldAddBOM(true);

        $writer->openToFile($tempFile);

        $headers = [
            'ID',
            'Timestamp',
            'User Name',
            'User Email',
            'Activity Description',
            'Event Type',
            'Affected Model',
            'Model ID',
            'Before Changes',
            'After Changes',
            'IP Address',
            'Log Category',
            'Created At'
        ];

        $headerRow = \Box\Spout\Writer\Common\Creator\WriterEntityFactory::createRowFromArray($headers);
        $writer->addRow($headerRow);

        // Add data rows
        foreach ($activities as $activity) {
            $rowData = [
                $activity->id,
                $activity->created_at->format('Y-m-d H:i:s'),
                $activity->causer->name ?? 'System',
                $activity->causer->email ?? '',
                $activity->description,
                $activity->event ?? 'N/A',
                $activity->subject_type ? class_basename($activity->subject_type) : 'N/A',
                $activity->subject_id ?? 'N/A',
                $this->formatPropertiesForCSV($activity->properties['before'] ?? []),
                $this->formatPropertiesForCSV($activity->properties['after'] ?? []),
                $activity->properties['ip'] ?? $activity->properties['ip_address'] ?? 'N/A',
                $activity->log_name ?? 'General',
                $activity->created_at
            ];

            $row = \Box\Spout\Writer\Common\Creator\WriterEntityFactory::createRowFromArray($rowData);
            $writer->addRow($row);
        }

        $writer->close();

        // Return the file as download
        return response()->download($tempFile, $filename . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ])->deleteFileAfterSend(true);
    }

    private function formatPropertiesForCSV($properties)
    {
        if (empty($properties)) {
            return '';
        }

        if (is_array($properties)) {
            // Convert array to JSON string
            $json = json_encode($properties, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            // Escape CSV special characters if needed
            $json = str_replace('"', '""', $json);

            return $json;
        }

        // Escape special characters for CSV
        $value = (string) $properties;
        $value = str_replace('"', '""', $value);

        return $value;
    }

    private function formatPropertiesForExport($properties)
    {
        if (empty($properties)) {
            return '';
        }

        if (is_array($properties)) {
            return json_encode($properties, JSON_PRETTY_PRINT);
        }

        return (string) $properties;
    }



    private function exportToPDF($activities, $filename)
    {
        // Option 1: Generate HTML and let user print to PDF
        return view('exports.activity-pdf', [
            'activities' => $activities,
            'title' => 'Activity Log Report',
            'date' => now()->format('F j, Y'),
            'total' => $activities->count(),
            'filters' => request()->all(),
            'filename' => $filename
        ]);
    }

    // Or create a simplified export that works without PDF library
    private function exportToPDFSimple($activities, $filename)
    {
        // Create a CSV file and suggest user to convert to PDF
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($activities) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

            // Headers
            $headers = ['Activity Log Report - ' . now()->format('Y-m-d')];
            fputcsv($file, $headers);
            fputcsv($file, []); // Empty row

            $dataHeaders = [
                'ID',
                'Timestamp',
                'User',
                'Description',
                'Event',
                'Affected',
                'IP Address'
            ];
            fputcsv($file, $dataHeaders);

            foreach ($activities as $activity) {
                $row = [
                    $activity->id,
                    $activity->created_at->format('Y-m-d H:i:s'),
                    $activity->causer->name ?? 'System',
                    $activity->description,
                    $activity->event ?? 'N/A',
                    $activity->subject_type ? class_basename($activity->subject_type) . ' #' . $activity->subject_id : 'N/A',
                    $activity->properties['ip'] ?? $activity->properties['ip_address'] ?? ''
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    // Helper method to format values
    public function formatValue($value)
    {
        // Handle warehouse inspection media array specifically
        if (is_array($value) && isset($value[0]['warehouseinspection_id']) && isset($value[0]['location'])) {
            return $this->formatWarehouseInspectionMediaArray($value);
        }

        // Handle single warehouse media object
        if (is_array($value) && isset($value['location']) && isset($value['details'])) {
            return $this->formatSingleWarehouseMedia($value);
        }

        // ... rest of your existing formatValue method ...
    }

    /**
     * Format warehouse inspection media for display
     */
    private function formatWarehouseMedia($data)
    {
        // Extract values safely
        $id = $data['id'] ?? 'N/A';
        $details = htmlspecialchars($data['details'] ?? 'No description');
        $location = $data['location'] ?? '';

        // Build image URL
        $imageUrl = $location ? asset($location) : asset('images/default-image.webp');

        // Format timestamps
        $createdAt = isset($data['created_at']) ?
            \Carbon\Carbon::parse($data['created_at'])->format('d M Y, h:i A') : 'N/A';
        $updatedAt = isset($data['updated_at']) ?
            \Carbon\Carbon::parse($data['updated_at'])->format('d M Y, h:i A') : 'N/A';

        // Build HTML
        $html = '<div class="warehouse-media" style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 8px; background: #f8f9fa;">';

        // Header with ID
        $html .= '<div class="d-flex justify-content-between align-items-center mb-2">';
        $html .= '<strong class="text-primary small">Media #' . $id . '</strong>';
        $html .= '<span class="badge bg-info small">Warehouse Media</span>';
        $html .= '</div>';

        // Image preview
        if ($location) {
            $html .= '<div class="text-center mb-2">';
            $html .= '<a href="' . $imageUrl . '" target="_blank" class="d-inline-block">';
            $html .= '<img src="' . $imageUrl . '" ';
            $html .= 'style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" ';
            $html .= 'onerror="this.onerror=null; this.src=\'' . asset('images/default-image.webp') . '\'" ';
            $html .= 'alt="' . $details . '">';
            $html .= '</a>';
            $html .= '</div>';
        }

        // Details
        $html .= '<div class="mb-1"><strong>Details:</strong> ' . $details . '</div>';

        // Timestamps
        $html .= '<div class="d-flex justify-content-between small text-muted">';
        $html .= '<div>Created: ' . $createdAt . '</div>';
        $html .= '<div>Updated: ' . $updatedAt . '</div>';
        $html .= '</div>';

        // View button
        if ($location) {
            $html .= '<div class="text-center mt-2">';
            $html .= '<a href="' . $imageUrl . '" target="_blank" class="btn btn-sm btn-outline-primary" style="padding: 2px 8px; font-size: 11px;">';
            $html .= '<i class="fas fa-external-link-alt me-1"></i>View';
            $html .= '</a>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    private function getLocationFromIP($ip)
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Localhost';
        }

        return null;
    }

    /**
     * Show a specific activity log entry
     */
    public function show($id)
    {
        $activity = Activity::with('causer')->findOrFail($id);

        return view('activity-log.show', compact('activity'));
    }

    /**
     * Clear all activity logs (with confirmation)
     */
    public function clear(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:DELETE_ALL_LOGS'
        ]);

        $count = Activity::count();
        Activity::truncate();

        // Log the clearance activity
        activity()
            ->log('Cleared all activity logs (' . $count . ' records)');

        return response()->json([
            'success' => true,
            'message' => 'All activity logs cleared successfully',
            'cleared_count' => $count
        ]);
    }

    /**
     * Get activity statistics
     */
    public function stats(Request $request)
    {
        $period = $request->get('period', '30days');

        switch ($period) {
            case 'today':
                $date = now()->today();
                break;
            case 'yesterday':
                $date = now()->yesterday();
                break;
            case '7days':
                $date = now()->subDays(7);
                break;
            case '30days':
                $date = now()->subDays(30);
                break;
            case 'month':
                $date = now()->startOfMonth();
                break;
            default:
                $date = now()->subDays(30);
        }

        $stats = [
            'total' => Activity::count(),
            'period_total' => Activity::where('created_at', '>=', $date)->count(),
            'by_event' => Activity::where('created_at', '>=', $date)
                ->select('event', DB::raw('count(*) as count'))
                ->groupBy('event')
                ->orderBy('count', 'desc')
                ->get(),
            'by_user' => Activity::where('created_at', '>=', $date)
                ->whereNotNull('causer_id')
                ->with('causer')
                ->select('causer_id', DB::raw('count(*) as count'))
                ->groupBy('causer_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'by_model' => Activity::where('created_at', '>=', $date)
                ->whereNotNull('subject_type')
                ->select('subject_type', DB::raw('count(*) as count'))
                ->groupBy('subject_type')
                ->orderBy('count', 'desc')
                ->get()
                ->map(function ($item) {
                    $item->model_name = class_basename($item->subject_type);
                    return $item;
                }),
            'by_hour' => Activity::where('created_at', '>=', $date)
                ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as count'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Delete specific activity log
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Activity log deleted successfully'
        ]);
    }
}
