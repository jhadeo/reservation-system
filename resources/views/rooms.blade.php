<x-layout title="Rooms">
    <main>
        <h1 class="font-bold my-10 sm:text-6xl text-4xl text-center">Rooms</h1>

        <div class="flex justify-center-safe mx-auto w-full px-4 sm:px-6 lg:px-8 my-12 sm:my-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8">
                @forelse ($room_types as $room_type)
               <x-partials.room-card room_type="{{ $room_type->name }}" room_description="{{ $room_type->description }}"></x-partials.room-card>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No room types available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
