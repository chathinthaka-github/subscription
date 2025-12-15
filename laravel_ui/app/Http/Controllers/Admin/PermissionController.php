<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index(): View
    {
        abort_unless(auth()->user()?->can('admin.view'), 403);

        $roles = Role::withCount(['permissions', 'users'])->orderBy('name')->get();

        return view('admin.permissions.index', compact('roles'));
    }

    /**
     * Show permissions for a specific role.
     */
    public function show(Role $role): View
    {
        abort_unless(auth()->user()?->can('admin.view'), 403);

        $role->load('permissions');
        
        // Get all permissions grouped by module
        $allPermissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('admin.permissions.show', compact('role', 'allPermissions'));
    }

    /**
     * Update permissions for a role.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        abort_unless(auth()->user()?->can('admin.update'), 403);

        $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $permissionIds = $request->input('permissions', []);
        
        // Convert string IDs to integers
        $permissionIds = array_map('intval', $permissionIds);
        
        // Validate all permission IDs exist
        $existingPermissionIds = Permission::whereIn('id', $permissionIds)->pluck('id')->toArray();
        
        if (count($permissionIds) !== count($existingPermissionIds)) {
            return redirect()->back()
                ->with('error', 'Some selected permissions are invalid.');
        }

        $role->syncPermissions($permissionIds);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permissions updated successfully for role: ' . $role->name);
    }
}
