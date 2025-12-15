@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Role</h1>

    <form method="POST" action="{{ route('admin.roles.store') }}" class="mt-8 space-y-6 max-w-2xl">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permissions</label>
            @foreach($permissions as $module => $modulePermissions)
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ ucfirst(str_replace('_', ' ', $module)) }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($modulePermissions as $permission)
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Create</button>
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection

