<x-layout title="Edit {{ $room->room_id }}">
    <x-partials.admin.nav :name="auth()->user()->full_name" />

    <div class="p-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold uppercase">Edit Room</h2>
        </div>
        <div class="flex mb-8">
            <a href="{{url()->previous()}}" class="font-bold">← Go Back</a>
        </div>

        <x-forms.alert-success />

        <form action="{{ route('admin.rooms.update', $room) }}" method="post" enctype="multipart/form-data" class="max-w-full">
            @csrf
            @method('PUT')
            <div class="md:flex md:items-stretch md:gap-8">
                <div class="md:w-1/2 pr-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label"><span class="label-text">Room ID</span></label>
                            <input type="text" name="room_id" placeholder="Room ID" value="{{ old('room_id', $room->room_id) }}" class="input input-bordered w-full">
                            <p class="label">Must be unique. This includes rooms that have been deleted.</p>
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Room Name</span></label>
                            <input type="text" name="name" placeholder="Room Name" value="{{ old('name', $room->name) }}" class="input input-bordered w-full">
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Hourly Rate</span></label>
                            <input type="number" step="any" name="hourly_rate" placeholder="Room Rate" value="{{ old('hourly_rate', $room->hourly_rate) }}" class="input input-bordered w-full">
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Maximum Capacity</span></label>
                            <input type="text" name="max_pax" placeholder="Maximum Capacity" value="{{ old('max_pax', $room->max_pax) }}" class="input input-bordered w-full">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="label"><span class="label-text">Room Type</span></label>
                        <select name="room_type_id" id="room_type_id" class="select select-bordered w-full">
                            @foreach($types as $id => $name)
                            <option value="{{ $id }}" @selected(old('room_type_id', $room->room_type_id) == $id)>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="label"><span class="label-text">Room Photo (optional)</span></label>
                        <input type="file" accept="image/png, image/jpeg, image/webp" name="photo" id="photo" class="file-input file-input-bordered w-full">
                    </div>

                    <div class="mt-4">
                        <label class="label"><span class="label-text">Description</span></label>
                        <textarea name="description" id="description" cols="30" rows="10" class="textarea textarea-bordered w-full">{{ old('description', $room->description) }}</textarea>
                    </div>

                    <div class="mt-4 flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="featured" id="featured" value="1" class="toggle" {{ $room->featured ? 'checked' : '' }}>
                            <span>Room featured?</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_available" id="is_available" value="1" class="toggle" {{ $room->is_available ? 'checked' : '' }}>
                            <span>Room available for reservation?</span>
                        </label>
                    </div>


                </div>

                <div class="md:w-1/2 pl-4 w-full mt-6 md:mt-0">
                    <div class="border rounded p-2 bg-gray-50 flex items-center justify-center h-full">
                        @if ($room->photo)
                        <img src="{{ Storage::url($room->photo) }}" alt="Room of {{ $room->room_id }}" class="w-full max-h-100 object-scale-down rounded id" id="photo-preview">
                        @else
                        <div class="text-center text-sm text-gray-500">

                            <div class="mt-2">No image provided</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</x-layout>