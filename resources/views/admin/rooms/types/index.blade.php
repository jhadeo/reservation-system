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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomTypes as $type)
                    <tr>
                        <td class="font-semibold">{{ $type->name }}</td>
                        <td>{{ Str::limit($type->description, 50) }}</td>
                        <td><span class="badge badge-info">{{ $type->rooms_count }}</span></td>
                        <td>
                            <a href="#" class="btn btn-ghost btn-xs">Edit</a>
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
</x-layout>