<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        // Group permissions with enhanced logic
        $permissionGroups = $this->groupPermissions($permissions);

        return view('roles.permissions', compact('role', 'permissionGroups', 'rolePermissions'));
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
                return 'Geographical Entities';
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
            'type' => 'Type Management',
            'farms' => 'Farm Management',
            'farm' => 'Farm Management',
            'aggregator' => 'Aggregator Management',
            'produce_catalogue' => 'Produce Catalogue',
            'produce catalogue' => 'Produce Catalogue',
            'survey' => 'Survey Management',
            'survey-questions' => 'Survey Questions',
            'survey-answers' => 'Survey Answers',
            'inspector' => 'Inspector Management',
            'marking-scheme' => 'Marking Scheme',
            'dashboard' => 'Dashboard Access',
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
        // Handle different permission name formats

        // Format: "action resource" (e.g., "view users")
        if (str_contains($permissionName, ' ')) {
            $parts = explode(' ', $permissionName);
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
            'Farm Management',
            'Aggregator Management',
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

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back();
    }
}
