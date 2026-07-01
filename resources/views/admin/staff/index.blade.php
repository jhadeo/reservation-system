<x-layout title="Manage Staff">
    <x-partials.admin.nav :name="auth()->user()->full_name" />

    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Staff</h2>
            <div class="flex gap-2">
                <button class="btn" popovertarget="popover-1" style="anchor-name:--anchor-1">
                    Filters <i class="fa-solid fa-angle-down"></i>
                </button>
                <div class="dropdown menu w-52 rounded-box bg-base-100 shadow-sm"
                    popover id="popover-1" style="position-anchor:--anchor-1">
                    <form id="staffFilter" class="flex flex-col p-2 gap-2">
                        <fieldset class="flex flex-col gap-2">
                            <p class="text-sm">Staff Status</p>
                            <div class="flex gap-1">
                                <input type="radio" name="status" id="active" class="radio" value="active"/>
                                <label for="active" class="label">Active</label>
                            </div>
                            <div class="flex gap-1">
                                <input type="radio" name="status" id="inactive" class="radio"  value="inactive"/>
                                <label for="inactive" class="label">Inactive</label>
                            </div>
                            <div class="flex gap-1">
                                <input type="radio" name="status" id="any" class="radio" checked="checked" value="any"/>
                                <label for="inactive" class="label">All Staff</label>
                            </div>
                        </fieldset>

                    </form>
                </div>
                <label class="input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="search" placeholder="Search" data-url="{{ route('admin.staff.search') }}" />
                </label>
                <button class="btn btn-primary" onclick="create_modal.showModal()">+ New Staff</a>
            </div>
        </div>

        <x-forms.alert-success />
        <x-forms.alert-info />

        @if($staffs->isEmpty())
        <div class="flex items-center justify-center min-h-96">
            <div class="card bg-base-200 shadow-xl p-8 text-center max-w-md ">
                <h3 class="card-title justify-center mb-4">Get Started</h3>
                <p class="mb-6 text-sm text-gray-600">Create staff to manage your staff.</p>
                <div class="card-actions justify-center gap-2">
                    <button onclick="create_modal.showModal()" class="btn btn-primary">Create Staff</button>
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
                                <button
                                    class="btn btn-neutral btn-xs edit-btn"
                                    data-action="{{ route('admin.staff.update', $staff) }}"
                                    data-type-name="{{ $staff->fullName }}"
                                    data-type-first-name="{{ $staff->first_name }}"
                                    data-type-last-name="{{ $staff->last_name }}"
                                    data-type-email="{{ $staff->email }}"
                                    data-type-phone="{{ $staff->phone }}">
                                    Edit
                                </button>
                                @if ($staff->deleted_at)
                                <button
                                    class="btn btn-success btn-xs restore-btn"
                                    data-type-name="{{ $staff->fullName }}"
                                    data-action="{{ route('admin.staff.restore', $staff)}}">
                                    Reactivate
                                </button>
                                @else
                                <button
                                    class="btn btn-error btn-xs delete-btn"
                                    data-type-name="{{ $staff->fullName }}"
                                    data-action="{{ route('admin.staff.destroy', $staff)}}">
                                    Deactivate
                                </button>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $staffs->links() }}
                </div>
            </div>
            @endif
        </div>

        <dialog id="create_modal" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold">Create new staff</h3>
                <div class="my-4 w-full">
                    <form action="{{ route('admin.staff.store') }}" method="post" class="w-full">
                        @csrf
                        <fieldset class="fieldset p-4 w-full">
                            <div class="flex gap-2">
                                <div>
                                    <label class="label" for="first_name">First name<span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" class="input w-full" placeholder="Ex: Juan" value="{{ old('first_name') }}" />
                                    <x-forms.error name="first_name" bag="create" />
                                </div>
                                <div>
                                    <label class="label" for="last_name">Last name<span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" class="input w-full" placeholder="Ex: Dela Cruz" value="{{ old('last_name') }}" />
                                    <x-forms.error name="last_name" bag="create" />
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <div>
                                    <label class="label" for="email">Email<span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="input w-full validator" placeholder="Ex: juan@gmail.com" value="{{ old('email') }}" />
                                    <x-forms.error name="email" bag="create" />
                                </div>
                                <div>
                                    <label class="label" for="phone">Mobile Number<span class="text-red-500">*</span></label>
                                    <input type="text" name="phone" class="input w-full" placeholder="Ex: 09123456789" value="{{ old('phone') }}" />
                                    <x-forms.error name="phone" bag="create" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Create Staff</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </dialog>

        <dialog id="edit_modal" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold">Edit <span id="staff-name"></span></h3>
                <div class="my-4 w-full">
                    <form method="post" class="w-full" id="edit-form"
                        action="{{ session('edit_staff_id') ? route('admin.staff.update', session('edit_staff_id')) : '' }}">
                        @csrf
                        @method('put')
                        <fieldset class="fieldset p-4 w-full">
                            <div class="flex gap-2">
                                <div>
                                    <label class="label">First Name<span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" id="edit-first-name" class="input w-full" placeholder="Ex: Juan" value="{{ old('first_name') }}" />
                                    <x-forms.error name="first_name" bag="edit" />
                                </div>
                                <div>
                                    <label class="label">Last Name<span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" id="edit-last-name" class="input w-full" placeholder="Ex: Dela Cruz" value="{{ old('last_name') }}" />
                                    <x-forms.error name="last_name" bag="edit" />
                                </div>
                            </div>
                            <label class="label">Email<span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="edit-email" class="input w-full" placeholder="Ex: juan@gmail.com" value="{{ old('email') }}" />
                            <x-forms.error name="email" bag="edit" />

                            <label class="label">Mobile Number<span class="text-red-500">*</span></label>
                            <input type="text" name="phone" id="edit-phone" class="input w-full" placeholder="Ex: 09123456789" value="{{ old('phone') }}" />
                            <x-forms.error name="phone" bag="edit" />

                            <button type="submit" class="btn btn-primary mt-4">Save changes</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </dialog>

        <dialog id="deact_modal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Deactivate Staff</h3>
                <p class="py-4">
                    Are you sure you want to deactivate
                    <span id="deact-type-name" class="font-semibold"></span>?
                </p>
                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn">Cancel</button>
                    </form>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary">Deactivate</button>
                    </form>
                </div>
            </div>
        </dialog>

        <dialog id="restore_modal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Activate Staff</h3>
                <p class="py-4">
                    Are you sure you want to activate
                    <span id="restore-type-name" class="font-semibold"></span>?
                </p>
                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn">Cancel</button>
                    </form>
                    <form id="restore-form" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Activate</button>
                    </form>
                </div>
            </div>
        </dialog>


        @if($errors->create->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.getElementById('create_modal')?.showModal();
            });
        </script>
        @endif

        @if($errors->edit->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.getElementById('edit_modal')?.showModal();
            });
        </script>
        @endif

        @vite(['resources/js/staff/index.js'])
</x-layout>