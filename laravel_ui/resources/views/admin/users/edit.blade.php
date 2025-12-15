@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit User</h1>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-8 space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
            <input type="text" name="username" id="username" required value="{{ old('username', $user->username) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roles</label>
            <div class="mt-2 space-y-2">
                @php
                    $userRoles = $user->roles->pluck('id')->toArray();
                @endphp
                @foreach($roles as $role)
                <label class="flex items-center">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Update</button>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection

