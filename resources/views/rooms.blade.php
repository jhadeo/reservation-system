<x-layout title="Rooms">
    <main>
        <h1 class="font-bold text-black my-10 sm:text-6xl text-4xl text-center">Rooms</h1>

        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 my-12 sm:my-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse ($room_types as $room_type)
                <section class="w-full rounded-lg p-4 sm:p-6 bg-white shadow-2xl">
                    <div class="flex flex-col gap-4 items-center justify-center">
                        <article class="w-full">
                            <h1 class="font-bold text-lg sm:text-xl text-center">{{ $room_type->name }}</h1>
                            @if ($room_type->description)
                            <p class="text-center">{{$room_type->description}}</p>
                            @endif
                        </article>
                    </div>
                </section>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No room types available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>