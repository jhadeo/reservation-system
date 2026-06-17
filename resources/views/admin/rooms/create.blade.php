<x-layout title="Create Room">
    <x-partials.admin.nav :name="auth()->user()->full_name" />
    <div class="p-6">
        <div class="flex mb-8 flex-col gap-2">
            <h2 class="text-2xl font-bold">Rooms</h2>
            <div class="flex my-2">
                <a href="{{url()->previous()}}" class="font-bold"><- Go Back</a>
            </div>
        </div>
        <form action="{{ route('admin.rooms.store') }}" method="post" enctype="multipart/form-data" class="max-w-3xl mx-auto w-full">
            @csrf
            <fieldset class="card-body fieldset gap-6">

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:[direction:ltr]">
                    <div class="flex w-full flex-col">
                        <label for="id">Room ID</label>
                        <input type="text" class="input w-full" name="id" value="{{ old('id') }}" placeholder="ex: REG-302" />
                        <x-forms.error name="id" />
                    </div>
                    <div class="flex w-full flex-col">
                        <label for="name">Room Name</label>
                        <input type="text" class="input w-full" name="name" value="{{ old('name') }}" placeholder="ex: Regent 302" />
                        <x-forms.error name="name" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:[direction:ltr]">
                    <div class="flex w-full flex-col">
                        <label for="hourly_rate">Hourly Rate</label>
                        <input type="number" step="any" min="0" class="input validator w-full" name="hourly_rate" value="{{ old('hourly_rate') }}" placeholder="ex: 100.00" />
                        <p class="label">This is the price of the room rented per hour. (e.g. 100/hr)</p>
                        <x-forms.error name="hourly_rate" />
                    </div>
                    <div class="flex w-full flex-col">
                        <label for="max_pax">Maximum Capacity</label>
                        <input type="number" min="1" class="input validator w-full" name="max_pax" value="{{ old('max_pax') }}" placeholder="ex: 2" />
                        <p class="label">The amount of people a room can hold</p>
                        <x-forms.error name="max_pax" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:[direction:ltr]">
                    <div class="flex w-full flex-col">
                        <label for="room_type_id">Room Type</label>
                        <select name="room_type_id" id="room_type_id" class="select select-bordered w-full">
                            <option value="" @selected(!old('room_type_id')) disabled>-- Select a Room Type --</option>
                            @foreach($types as $id => $name)
                            <option value="{{ $id }}" @selected(old('room_type_id')==$id)>{{ $name }}</option>
                            @endforeach
                        </select>
                        <x-forms.error name="room_type_id" />
                    </div>
                    <div class="flex w-full flex-col">
                        <label for="photo">Room Photo (optional)</label>
                        <input type="file" accept="image/png, image/jpeg, image/webp" name="photo" id="photo" class="file-input file-input-bordered w-full">
                        <x-forms.error name="photo" />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 md:[direction:ltr]">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" placeholder="Provide a brief description of the room" class="textarea textarea-bordered w-full md:col-span-2">{{ old('description') }}</textarea>
                    <x-forms.error name="description" />
                </div>
                <div class="card-actions justify-end pt-2">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </fieldset>
        </form>
    </div>
</x-layout>