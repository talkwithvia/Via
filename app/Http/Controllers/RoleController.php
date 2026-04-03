<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::latest();
            return DataTables::of($roles)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('D, d M Y') : '')
                ->addColumn('actions', function ($row) {
                    if ($row->name) {
                        $buttons = '<div class="btn-group">
                             <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Action
                             </button>
                             <div  class="dropdown-menu" style="min-width:0;padding:5px;width:max-content;">';

                        // Conditionally add Edit button
                        if (Auth::user()?->can('edit roles')) {
                            $buttons .= '<button class="btn btn-xs btn-warning editRole" data-id="' . $row->id . '" data-name="' . $row->name . '">Edit</button> ';
                        }

                        if (Auth::user()?->hasRole('super-admin') && Auth::user()?->id === 1) {
                            // Always include Delete and Permissions buttons
                            $buttons .= '<button class="btn btn-xs btn-danger deleteRole" data-id="' . $row->id . '">Delete</button> ';
                            $buttons .= '<br>';
                            $buttons .= '<a href="' . route('admin.roles.permissions', $row->id) . '" class="btn btn-xs btn-info">Permissions</a>';
                        }
                        $buttons .= '</div></div>';

                        return $buttons;
                    }
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);
        $role = Role::create(['name' => $request->name]);

        activity('Role Management')
            ->causedBy(Auth::user())
            ->withProperties([
                'role_id' => $role->id,
                'ip' => request()->ip(),
            ])
            ->log('Created new Role');
        if ($request->ajax()) {
            return response()->json(['success' => 'New role created successfully.']);
        }


        return back()->with('success', 'New role created successfully.');
    }


    public function update(Request $request, Role $role)
    {
        $before = $role->toArray();
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name]);
        activity('Role Management')
            ->causedBy(Auth::user())
            ->withProperties([
                'role_id' => $role->id,
                'before' => $before,
                'after' => $role->toArray(),
                'ip' => request()->ip(),
            ])
            ->log('Updated  Role');
        return response()->json(['success' => 'Role updated successfully.']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (DB::table('model_has_roles')->where('role_id', $role->id)->exists()) {
            return response()->json(['error' => 'Role cannot be deleted because it is assigned to users.'], 400);
        }

        $role->permissions()->detach();
        $role->delete();
        activity('Role Management')
            ->causedBy(Auth::user())
            ->withProperties([
                'role_id' => $role->id,
                'ip' => request()->ip(),
            ])
            ->log('Deleted  Role');
        return response()->json(['success' => 'Role deleted successfully.']);
    }

    public function attachUser(Role $role, User $user)
    {
        $user->assignRole($role->name);
        activity('Role Management')
            ->causedBy(Auth::user())
            ->withProperties([
                'user_id' => $user->id,
                'ip' => request()->ip(),
            ])
            ->log('Assigned Role to User');
        return back()->with('success', 'Role assigned to user successfully.');
    }

    public function permissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ];
        // Group permissions with enhanced logic
        $permissionGroups = $this->groupPermissions($permissions);

        return view('roles.permissions', array_merge($data, compact('permissionGroups', 'data')));
    }

    private function groupPermissions($permissions)
    {
        $groups = [];

        foreach ($permissions as $permission) {
            $name = $permission->name;

            // Determine the group for this permission
            $group = $this->determineGroup($name);

            if (!isset($groups[$group])) {
                $groups[$group] = [];
            }

            $groups[$group][] = $permission;
        }

        // Sort groups in logical order
        return $this->sortGroups($groups);
    }

    private function determineGroup($permissionName)
    {
        // Extract resource from permission name
        $resource = $this->extractResource($permissionName);

        // Define geographical entities group
        $geographicalEntities = ['regions', 'districts', 'divisions', 'wards'];

        foreach ($geographicalEntities as $entity) {
            if (stripos($resource, $entity) !== false) {
                return 'Location Management';
            }
        }

        // Define other groups
        $groupMapping = [
            'user' => 'User Management',
            'role' => 'Role & Permission Management',
            'permission' => 'Role & Permission Management',
            'warehouse' => 'Warehouse Management',
            'warehouses' => 'Warehouse Management',
            'activity_log' => 'Activity Log',
            'activity log' => 'Activity Log',
            'type' => 'Client Management',
            'farms' => 'Partner Management',
            'farm' => 'Partner Management',
            'aggregator' => 'Client Management',
            'produce_catalogue' => 'Produce Catalogue',
            'produce catalogue' => 'Produce Catalogue',
            'survey' => 'Survey Management',
            'survey-questions' => 'Survey Management',
            'survey-answers' => 'Survey Management',
            'inspector' => 'Warehouse Management',
            'marking-scheme' => 'Survey Management',
            'dashboard' => 'Dashboard Access',
            'toggle divisions' => 'Location Management',
            'toggle wards' => 'Location Management',
            'toggle regions' => 'Location Management',
            'toggle districts' => 'Location Management',
        ];

        foreach ($groupMapping as $key => $group) {
            if (stripos($resource, $key) !== false) {
                return $group;
            }
        }

        // Default: use resource name capitalized
        return ucwords(str_replace(['-', '_'], ' ', $resource));
    }

    private function extractResource($permissionName)
    {

        // Format: "action resource status" (e.g., "toggle user status", "toggle wards status")
        if (str_contains($permissionName, ' ')) {
            $parts = explode(' ', $permissionName);

            if (count($parts) === 3 && $parts[0] === 'toggle' && $parts[2] === 'status') {
                return $parts[1]; // Return the middle word (user, wards, etc.)
            }

            // For other space-separated formats like "view users"
            return end($parts); // Last part is the resource
        }

        // Format: "resource.action" (e.g., "activity_log.view")
        if (str_contains($permissionName, '.')) {
            $parts = explode('.', $permissionName);
            return $parts[0]; // First part is the resource
        }

        // Format: "action-resource" (e.g., "create-types")
        if (str_contains($permissionName, '-')) {
            $parts = explode('-', $permissionName);
            // Check if it's a compound resource like "survey-questions"
            if (count($parts) > 2 || in_array($parts[1], ['questions', 'answers'])) {
                return $parts[0] . '-' . $parts[1];
            }
            return $parts[1] ?? $parts[0];
        }

        return $permissionName;
    }

    private function sortGroups($groups)
    {
        $preferredOrder = [
            'Dashboard Access',
            'User Management',
            'Role & Permission Management',
            'Geographical Entities',
            'Warehouse Management',
            'Type Management',
            'Partner Management',
            'Client Management',
            'Produce Catalogue',
            'Survey Management',
            'Survey Questions',
            'Survey Answers',
            'Inspector Management',
            'Marking Scheme',
            'Activity Log'
        ];

        $sorted = [];

        // Add groups in preferred order
        foreach ($preferredOrder as $groupName) {
            if (isset($groups[$groupName])) {
                $sorted[$groupName] = $groups[$groupName];
                unset($groups[$groupName]);
            }
        }

        // Add remaining groups alphabetically
        ksort($groups);
        foreach ($groups as $groupName => $permissions) {
            $sorted[$groupName] = $permissions;
        }

        return $sorted;
    }
    public function updatePermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        // Sync permissions
        $role->syncPermissions($validated['permissions'] ?? []);
        activity('Role Management')
            ->causedBy(Auth::user())
            ->withProperties([
                'role_id' => $role->id,
                'ip' => request()->ip(),
            ])
            ->log('Updated Role Permissions');

        return redirect()->route('admin.roles.index')->with('success', 'Permissions updated successfully!');
    }
}
