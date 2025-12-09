@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Users</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('admin.create')
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Add User</a>
            @endcan
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Username</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Roles</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ $user->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $user->username }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2">
                                    @can('admin.update')
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan
                                    @can('admin.delete')
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-sm text-gray-500">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection

