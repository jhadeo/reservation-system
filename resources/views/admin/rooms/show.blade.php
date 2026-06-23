<x-layout title="{{ $room->room_id }}">
    <x-partials.admin.nav :name="auth()->user()->full_name" />

    <div class="p-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">{{ $room->room_id }} - Details</h2>
        </div>
        <div class="flex mb-8">
            <a href="{{url()->previous()}}" class="font-bold">← Go Back</a>
        </div>

        <x-forms.alert-success />

        <div class="max-w-full">
            <div class="md:flex md:items-stretch md:gap-8">
                <div class="md:w-1/2 pr-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="label-text">Room ID</p>
                            <p class="border p-2 rounded">{{ $room->room_id }}</p>
                        </div>
                        <div>
                            <p class="label-text">Room Name</p>
                            <p class="border p-2 rounded">{{ $room->name }}</p>
                        </div>

                        <div>
                            <p class="label-text">Hourly Rate</p>
                            <p class="border p-2 rounded">{{ $room->hourly_rate }}</p>
                        </div>

                        <div>
                            <p class="label-text">Maximum Capacity</p>
                            <p class="border p-2 rounded">{{ $room->max_pax }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="label-text">Room Type</p>
                        <p class="border p-2 rounded">{{ $room->roomType?->name ?? 'N/A' }}</p>
                    </div>                    <div class="mt-4">
                        <p class="label-text">Description</p>
                        <p class="border rounded p-2 w-full">{{ $room->description }}</p>
                    </div>

                    <div class="mt-4 flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="featured" id="featured" value="1" class="toggle" {{ $room->featured ? 'checked' : '' }} disabled>
                            <span>Room featured?</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_available" id="is_available" value="1" class="toggle" {{ $room->is_available ? 'checked' : '' }} disabled>
                            <span>Room available for reservation?</span>
                        </label>
                    </div>


                </div>

                <div class="md:w-1/2 pl-4 w-full mt-6 md:mt-0">
                    <div class="border rounded p-2 bg-gray-50 flex items-center justify-center h-full max-h-100">
                        @if ($room->photo)
                        <img src="{{ Storage::url($room->photo) }}" alt="Room of {{ $room->room_id }}" class="w-full h-full max-h-100 object-scale-down rounded id" id="photo-preview">
                        @else
                        <div class="text-center text-sm text-gray-500">

                            <div class="mt-2">No image provided</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layout>