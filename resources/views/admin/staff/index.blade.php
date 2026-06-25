<x-layout title="Staff">
    <x-partials.admin.nav :name="auth()->user()->full_name" />

    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Staff</h2>
            <div class="flex gap-2">
                <label class="input">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g
                            stroke-linejoin="round"
                            stroke-linecap="round"
                            stroke-width="2.5"
                            fill="none"
                            stroke="currentColor">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <input type="search" id="search" placeholder="Search" data-url="" />
                </label>
                <a href="/admin/rooms/create" class="btn btn-primary">+ New Staff</a>
            </div>
        </div>

        <x-forms.alert-success />
        <x-forms.alert-info />

        @if($staffs->isEmpty())
        <div class="flex items-center justify-center min-h-96">
            <div class="card bg-base-200 shadow-xl p-8 text-center max-w-md">
                <h3 class="card-title justify-center mb-4">Get Started</h3>
                <p class="mb-6 text-sm text-gray-600">Create staff to manage your staff.</p>
                <div class="card-actions justify-center gap-2">
                    <a href="{{route('admin.rooms.create')}}" class="btn btn-primary">Create Staff</a>
                </div>
            </div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Mobile Number</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="t-body">
                    @foreach($staffs as $staff)
                    <tr>
                        <td class="font-semibold">{{ $staff->fullName }}</td>
                        <td class="font-semibold">{{ $staff->phone }}</td>
                        <td class="font-semibold">{{ $staff->email }}</td>
                        <td class="font-semibold">
                            <span class="badge {{ $staff->deleted_at ? 'badge-error' : 'badge-success' }}">
                                {{ $staff->deleted_at ? 'Inactive' : 'Active' }}
                            </span>
                        </td>

                        <td class="flex gap-2 justify-center">
                            <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-primary btn-xs">Show</a>
                            <a href="{{ route('admin.rooms.edit', $staff) }}" class="btn btn-neutral btn-xs">Edit</a>
                            <button
                                class="btn btn-error btn-xs"
                                data-action="{{ route('admin.rooms.destroy', $staff) }}"
                                data-room-name="{{ $staff->fullName }}"
                                onclick="openDeleteModal(this)">
                                Delete
                            </button>
                        </td>

                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-layout>