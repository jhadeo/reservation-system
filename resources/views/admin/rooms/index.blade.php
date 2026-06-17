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
                            <th>Room Name</th>
                            <th>Rate</th>
                            <th>Max Capacity</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($typeRooms as $room)
                        <tr>
                            <td class="font-semibold">{{ $room->name }}</td>
                            <td>₱{{ number_format($room->hourly_rate, 2) }}/hr</td>
                            <td>{{ $room->max_pax }} people</td>
                            <td>
                                <span class="badge {{ $room->is_available ? 'badge-success' : 'badge-error' }}">
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-ghost btn-xs">Edit</a>
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
</x-layout>