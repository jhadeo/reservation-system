<x-layout title="Manage Room Types">
    <x-partials.admin.nav :name="auth()->user()->full_name" />
    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Room Types</h2>
            <div class="flex gap-2">
                <label class="input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="search" placeholder="Search" data-url="{{ route('admin.room-types.search')}}" />
                </label>
                <button class="btn btn-primary" onclick="create_modal.showModal()">+ New Room Type</button>
            </div>

        </div>

        <x-forms.alert-success />
        <x-forms.alert-info />

        @if($roomTypes->isEmpty())
        <div class="flex items-center justify-center min-h-96">
            <div class="card bg-base-200 shadow-xl p-8 text-center max-w-md">
                <h3 class="card-title justify-center mb-4">Get Started</h3>
                <p class="mb-6 text-sm text-gray-600">Create room types to categorize your rooms.</p>
                <div class="card-actions justify-center gap-2">
                    <button class="btn btn-primary" onclick="create_modal.showModal()">Create Room Type</button>
                </div>
            </div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Type Name</th>
                        <th>Description</th>
                        <th>Rooms</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="t-body">
                    @foreach($roomTypes as $type)
                    <tr>
                        <td class="font-semibold">{{ $type->name }}</td>
                        <td class="font-semibold">
                            <div class="max-w-xs truncate" title="{{ $type->description }}">
                                {{ $type->description }}
                            </div>
                        </td>

                        <td><span class="badge badge-info">{{ $type->rooms_count }}</span></td>
                        <td><span class="badge badge-{{$type->deleted_at ? 'error' : 'success'}}">{{ $type->deleted_at ? 'Inactive' : 'Active' }}</span></td>
                        <td class="flex gap-2 justify-center">
                            <button class="btn btn-neutral btn-xs edit-btn"
                                data-action="{{ route('admin.room-types.update', $type) }}"
                                data-type-name="{{ $type->name }}"
                                data-type-description="{{ $type->description }}">
                                Edit
                            </button>

                            @if ($type->deleted_at)
                            <button
                                class="btn btn-success btn-xs restore-btn"
                                data-action="{{ route('admin.room-types.restore', $type) }}"
                                data-type-name="{{ $type->name }}">
                                Restore
                            </button>
                            @else
                            <button
                                class="btn btn-error btn-xs delete-btn"
                                data-action="{{ route('admin.room-types.destroy', $type) }}"
                                data-type-name="{{ $type->name }}">
                                Delete
                            </button>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $roomTypes->links() }}
        </div>
        @endif
    </div>

    <dialog id="create_modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Create new room type</h3>
            <div class="my-4 w-full">
                <form action="{{ route('admin.room-types.create') }}" method="post" class="w-full">
                    @csrf
                    <fieldset class="fieldset p-4 w-full">

                        <label class="label">Name<span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="input w-full" placeholder="Name" value="{{ old('name') }}" />
                        <x-forms.error name="name" bag="create" />

                        <label class="label">Description<span class="text-red-500">*</span></label>
                        <input type="text" name="description" class="input w-full" placeholder="Description" value="{{ old('description') }}" />
                        <x-forms.error name="description" bag="create" />

                        <button type="submit" class="btn btn-primary mt-4">Create Room Type</button>
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
            <h3 class="text-lg font-bold">Edit <span id="room-name"></span></h3>
            <div class="my-4 w-full">
                <form method="post" class="w-full" id="edit-form"
                    action="{{ session('edit_room_type_id') ? route('admin.room-types.update', session('edit_room_type_id')) : '' }}">
                    @csrf
                    @method('put')
                    <fieldset class="fieldset p-4 w-full">

                        <label class="label">Name<span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit-name" class="input w-full" placeholder="Name" value="{{ old('name') }}" />
                        <x-forms.error name="name" bag="edit" />

                        <label class="label">Description<span class="text-red-500">*</span></label>
                        <input type="text" name="description" id="edit-description" class="input w-full" placeholder="Description" value="{{ old('description') }}" />
                        <x-forms.error name="description" bag="edit" />

                        <button type="submit" class="btn btn-primary mt-4">Save changes</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete Room Type</h3>

            <p class="py-4">
                Are you sure you want to delete
                <span id="type-name" class="font-semibold"></span>?
            </p>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Cancel</button>
                </form>

                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-error">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="restore_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Restore Room Type</h3>

            <p class="py-4">
                Are you sure you want to restore
                <span id="restore-type-name" class="font-semibold"></span>?
            </p>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Cancel</button>
                </form>

                <form id="restore-form" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-success">
                        Restore
                    </button>
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

    @vite(['resources/js/room-types/index.js'])
</x-layout>