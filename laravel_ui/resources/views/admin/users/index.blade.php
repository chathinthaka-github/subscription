@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="neo-card p-8 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold" style="color: var(--color-neo-text);">Users</h1>
            <p class="mt-2 text-sm" style="color: var(--color-neo-text-light);">Manage system users and their permissions</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('admin.create')
            <a href="{{ route('admin.users.create') }}" class="neo-button-primary px-4 py-2 text-sm font-medium inline-flex items-center">Add User</a>
            @endcan
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y" style="border-color: rgba(163, 163, 163, 0.2);">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0" style="color: var(--color-neo-text);">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Username</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Name</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Email</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Roles</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Created</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($users as $user)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $user->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $user->username }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2 justify-end">
                                    @can('admin.update')
                                    <a href="{{ route('admin.users.edit', $user) }}" class="neo-button px-3 py-1 text-sm" style="color: var(--color-neo-accent); font-weight: 600;">Edit</a>
                                    @endcan
                                    @can('admin.delete')
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="neo-button-danger px-3 py-1 text-sm">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No users found</td>
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

