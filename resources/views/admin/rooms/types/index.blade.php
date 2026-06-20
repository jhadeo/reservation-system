<x-layout title="Room Type">
    <x-partials.admin.nav :name="auth()->user()->full_name" />
    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Room Types</h2>
            <div class="flex gap-2">
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
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomTypes as $type)
                    <tr>
                        <td class="font-semibold">{{ $type->name }}</td>
                        <td class="tooltip tooltip-right" data-tip="{{$type->description}}">
                            <p>{{ Str::limit($type->description, 50) }}</p>
                        </td>

                        <td><span class="badge badge-info">{{ $type->rooms_count }}</span></td>
                        <td class="flex gap-2 justify-center">
                            <a href="#" class="btn btn-neutral btn-xs"
                                data-action="{{ route('admin.room-types.update', $type) }}"
                                data-type-name="{{ $type->name }}"
                                data-type-description="{{ $type->description }}"
                                onclick="openEditModal(this)">
                                Edit
                            </a>
                            <a href="#"
                                class="btn btn-error btn-xs"
                                data-action="{{ route('admin.room-types.destroy', $type) }}"
                                data-type-name="{{ $type->name }}"
                                onclick="openDeleteModal(this)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <x-forms.error name="name" />

                        <label class="label">Description<span class="text-red-500">*</span></label>
                        <input type="text" name="description" class="input w-full" placeholder="Description" value="{{ old('description') }}" />
                        <x-forms.error name="description" />

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
                <form method="post" class="w-full" id="edit-form">
                    @csrf
                    @method('put')
                    <fieldset class="fieldset p-4 w-full">

                        <label class="label">Name<span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit-name" class="input w-full" placeholder="Name" value="{{ old('name') }}" />
                        <x-forms.error name="name" />

                        <label class="label">Description<span class="text-red-500">*</span></label>
                        <input type="text" name="description" id="edit-description" class="input w-full" placeholder="Description" value="{{ old('description') }}" />
                        <x-forms.error name="description" />

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

    <script>
        function openEditModal(button) {
            document.getElementById('edit-form').action = button.dataset.action;
            document.getElementById('edit-name').value = button.dataset.typeName;
            document.getElementById('edit-description').value = button.dataset.typeDescription;
            document.getElementById('edit_modal').showModal();
        }

        function openDeleteModal(button) {
            document.getElementById('delete-form').action = button.dataset.action;
            document.getElementById('type-name').textContent = button.dataset.typeName;
            document.getElementById('delete_modal').showModal();
        }
    </script>
</x-layout>