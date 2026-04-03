<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Models\User;


class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->latest();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('user', function ($user) {
                    $avatar = $user->image
                        ? asset($user->image)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=fff&background=4e73df&size=40';
                    return '
                        <div class="d-flex align-items-center">
                            
                            <!-- Avatar -->
                            <div class="me-2">
                                <img src="' . $avatar . '" 
                                     alt="Avatar" 
                                     class="rounded-circle" 
                                     width="40" 
                                     height="40">
                            </div>
                
                            <!-- User Info -->
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">' . $user->name . '</span>
                                <small class="text-muted">' . $user->email . '</small>
                            </div>
                
                        </div> ';
                })
                ->addColumn('roles', fn($user) => $user->roles->pluck('name')->join(', '))
                ->addColumn('status', function ($user) {
                    return $user->status ? '<span class="badge badge-success badge-pill">Active</span>' : '<span class="badge badge-danger badge-pill">Inactive</span>';
                })
                ->addColumn('actions', function ($user) {
                    // Super Admin special case
                    if ($user->id === 1) {
                        return '<span class="badge badge-info badge-pill">Super Admin</span>';
                    }

                    $buttons = '
                           <div class="btn-group" style="witdh:max-content;">
                               <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   Actions
                               </button>
                               <div  class="dropdown-menu" style="min-width:0;padding:5px;width:max-content;">';
                    // View
                    if (Auth::user()->can('view users')) {
                        $buttons .= '
                                            <a href="' . route('admin.users.show', $user->id) . '" class="btn btn-xs btn-info ">
                                                View
                                            </a>';
                    }

                    // Edit
                    if (Auth::user()->can('edit users')) {

                        $buttons .= '
                        <br>
                        <a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-xs btn-secondary ">
                                                Edit
                                            </a>';
                    }

                    // Assign Role
                    if (Auth::user()->can('assign roles') &&  $user->id != 1) {
                        $buttons .= '<br>
                                            <button class="btn btn-xs btn-primary   assignRoleBtn" data-id="' . $user->id . '">
                                                Assign Role
                                            </button>';
                    }

                    // Enable / Disable
                    if (Auth::user()->can('toggle user status') && ! $user->hasRole('super-admin')) {
                        if ($user->status) {
                            $buttons .= '
                                                <button class="btn btn-xs btn-warning   toggleStatusBtn" data-id="' . $user->id . '" data-status="0">
                                                    Disable
                                                </button>';
                        } else {
                            $buttons .= '
                                                <button class="btn btn-xs btn-success   toggleStatusBtn" data-id="' . $user->id . '" data-status="1">
                                                    Enable
                                                </button>';
                        }
                    }

                    $buttons .= '</div>
                                   
                  </div>';

                    return $buttons;
                })
                ->rawColumns(['roles', 'status', 'actions', 'user'])
                ->make(true);
        }

        $roles = Role::all(); // to use in modal select
        $data = [];

        $data['totalUsers'] = User::count();

        $data['activeUsers'] = User::active()->count();

        $data['inactiveUsers'] = $data['totalUsers'] - $data['activeUsers'];


        $data['verifiedUsers'] = User::whereNotNull('email_verified_at')->count();
        $data['unverifiedUsers'] = User::whereNull('email_verified_at')->count();
        $data['adminUsers'] = User::role('super-admin')->count();
        $data['usersWithProfilePictures'] = User::whereNotNull('image')->count();

        $data['recentUsers'] = User::where('created_at', '>=', now()->subDays(30))->count();

        $data['activePercentage'] = $data['totalUsers'] > 0 ?
            ($data['activeUsers'] / $data['totalUsers']) * 100 : 0;

        $data['verifiedPercentage'] = $data['totalUsers'] > 0 ?
            ($data['verifiedUsers'] / $data['totalUsers']) * 100 : 0;

        $data['roleDistribution'] = [
            ['role' => 'super-admin', 'count' => $data['adminUsers'], 'color' => 'primary'],
            ['role' => 'other', 'count' => $data['totalUsers'] - $data['adminUsers'], 'color' => 'secondary'],
        ];
        return view('users.index', compact('roles', 'data'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function show(Request $request, $id)
    {

        if ($id == 1) {
            abort(403, 'Access to Super Admin activities is restricted.');
        }
        $user = User::with('roles')->findOrFail($id);
        $users = User::with('roles')->latest()->get();
        $roles = Role::all();
        $causer = (new getRecordCreatorController())->getRecordCreator('User', $user->id, 'user_id');
        return view('users.show', compact('user', 'users', 'roles', 'causer'));
    }
    public function edit($id)
    {
        if ($id == 1) {
            abort(403, 'Access to Super Admin activities is restricted.');
        }
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
        ]);
        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => true,
            ]);
            activity('User Management')
                ->causedBy(Auth::user())
                ->withProperties([
                    'user_id' => $user->id,
                    'ip' => request()->ip(),
                ])
                ->log('Created new User');
            // Assign Roles (Spatie)
            $user->syncRoles($validated['roles']);
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the user: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $before = $user->toArray();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:8'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ]);
        DB::beginTransaction();
        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();
            $after = $user->toArray();

            if (isset($validated['roles'])) {
                $user->syncRoles($validated['roles']);
            }

            activity('User Management')
                ->causedBy(Auth::user())
                ->withProperties([
                    'user_id' => $user->id,
                    'before' => $before,
                    'after' => $after,
                    'ip' => request()->ip(),
                ])
                ->log('Updated User Details');

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error starting transaction: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while starting the transaction: ' . $e->getMessage()]);
        }
    }
    public function assignRole(Request $request, User $user)
    {
        // try and catch to handle any unexpected errors
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'role' => 'required|exists:roles,name',
            ]);
            if ($user->hasRole('super-admin')) {
                return response()->json(['error' => 'Cannot modify Super Admin'], 403);
            }

            $request->validate([
                'role' => 'required|exists:roles,name',
            ]);

            $user->syncRoles([$request->role]);
            DB::commit();
            return response()->json(['success' => 'Role assigned successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error assigning role: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Validation failed: ' . $e->getMessage()], 422);
        }
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent disabling super-admin
        if ($user->hasRole('super-admin')) {
            return response()->json(['error' => 'Cannot disable Super Admin'], 403);
        }
        // Toggle status
        $user->status = $user->status ? 0 : 1;
        $user->save();
        return response()->json([
            'success' => 'User status updated',
        ]);
    }
}
