@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Permission</h1>

    <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="mt-8 space-y-6 max-w-2xl" id="permissionForm">
        @csrf
        @method('PUT')

        <div>
            <label for="module" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Module</label>
            <select name="module" id="module" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="service" {{ old('module', $module) === 'service' ? 'selected' : '' }}>Service</option>
                <option value="service_message" {{ old('module', $module) === 'service_message' ? 'selected' : '' }}>Service Message</option>
                <option value="renewal_plan" {{ old('module', $module) === 'renewal_plan' ? 'selected' : '' }}>Renewal Plan</option>
                <option value="reports" {{ old('module', $module) === 'reports' ? 'selected' : '' }}>Reports</option>
                <option value="admin" {{ old('module', $module) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div>
            <label for="action" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Action</label>
            <select name="action" id="action" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="view" {{ old('action', $action) === 'view' ? 'selected' : '' }}>View</option>
                <option value="create" {{ old('action', $action) === 'create' ? 'selected' : '' }}>Create</option>
                <option value="update" {{ old('action', $action) === 'update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ old('action', $action) === 'delete' ? 'selected' : '' }}>Delete</option>
            </select>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permission Name (auto-generated)</label>
            <input type="text" name="name" id="name" readonly value="{{ old('name', $permission->name) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assign to Roles (Optional)</label>
            <div class="space-y-2">
                @php
                    $permissionRoles = $permission->roles->pluck('id')->toArray();
                @endphp
                @foreach($roles as $role)
                <label class="flex items-center">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, old('roles', $permissionRoles)) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Update</button>
            <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>

<script>
    function updatePermissionName() {
        const module = document.getElementById('module').value;
        const action = document.getElementById('action').value;
        document.getElementById('name').value = module + '.' + action;
    }

    document.getElementById('module').addEventListener('change', updatePermissionName);
    document.getElementById('action').addEventListener('change', updatePermissionName);
</script>
@endsection

