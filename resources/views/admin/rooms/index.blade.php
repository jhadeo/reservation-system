<x-layout title="Rooms">
    <x-partials.admin.nav :name="auth()->user()->full_name" />

    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Rooms</h2>
            <div class="flex gap-2">
                <a href="/admin/rooms/create" class="btn btn-primary btn-sm">+ New Room</a>
            </div>
        </div>

        <x-forms.alert-success />
        <x-forms.alert-info />

        <!-- Empty State -->
        @if($rooms->isEmpty())
        <div class="flex items-center justify-center min-h-96">
            <div class="card bg-base-200 shadow-xl p-8 text-center max-w-md">
                <h3 class="card-title justify-center mb-4">Get Started</h3>
                <p class="mb-6 text-sm text-gray-600">Create rooms to manage your inventory.</p>
                <div class="card-actions justify-center gap-2">
                    <a href="{{route('admin.rooms.create')}}" class="btn btn-primary">Create Room</a>
                </div>
            </div>
        </div>
        @else
        <!-- Rooms grouped by Type -->
        @foreach($rooms->groupBy('room_type_id') as $typeId => $typeRooms)
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">{{ $typeRooms->first()->roomType?->name ?? 'Untyped' }} ({{ $typeRooms->count() }})</h3>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Room Name</th>
                            <th>Rate</th>
                            <th>Max Capacity</th>
                            <th>Available</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($typeRooms as $room)
                        <tr>
                            <td class="font-semibold">{{ $room->room_id }}</td>
                            <td class="font-semibold">{{ $room->name }}</td>
                            <td>₱{{ number_format($room->hourly_rate, 2) }}/hr</td>
                            <td>{{ $room->max_pax }} people</td>
                            <td>
                                <span class="badge {{ $room->is_available ? 'badge-success' : 'badge-error' }}">
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="flex gap-2 justify-center">
                                <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-primary btn-xs">Show</a>
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-neutral btn-xs">Edit</a>
                                <a href="#"
                                    class="btn btn-error btn-xs"
                                    data-action="{{ route('admin.rooms.destroy', $room) }}"
                                    data-room-name="{{ $room->name }}"
                                    onclick="openDeleteModal(this)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete Room</h3>

            <p class="py-4">
                Are you sure you want to delete
                <span id="room-name" class="font-semibold"></span>?
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
        function openDeleteModal(button) {
            document.getElementById('delete-form').action = button.dataset.action;
            document.getElementById('room-name').textContent = button.dataset.roomName;
            document.getElementById('delete_modal').showModal();
        }
    </script>
</x-layout>