<x-layout title="Rooms">
    <main>
        <div style="background-image: url(https://images.pexels.com/photos/1146708/pexels-photo-1146708.jpeg); background-size: contain;"
            class="aspect-video max-w-full flex items-center justify-center shadow-2xl">
            <h1 class="font-bold text-amber-50 sm:text-6xl text-4xl text-center">Rooms</h1>
        </div>

        @foreach ($room_types as $room_type)
        <h1 class="font-bold text-black sm:text-6xl text-4xl flex justify-center m-10 mb-2">{{$room_type->name}}</h1>
        @if ($room_type->description)
        <p class="w-full text-sm sm:text-base mx-auto text-center italic">{{$room_type->description}}</p>
        @endif

        <div class="grid gap-6 sm:gap-8 justify-center">
            @forelse ($room_type->rooms as $room)
            <section class="w-full sm:w-100 md:w-200 rounded-lg p-4 sm:p-6 bg-white m-4 shadow-2xl">
                <div class="flex flex-col gap-4 md:flex-row">
                    <div class="aspect-square w-full md:w-1/3 rounded-md border"></div>
                    <article class="w-full md:w-2/3">
                        <h1 class="font-bold text-lg sm:text-xl">{{ $room->name }}</h1>
                        <p>{{$room->description}}</p>
                        <ul class="mt-2">
                            <li>Maximum Capacity: {{ $room->max_pax }}</li>
                            <li>Hourly Rate: ₱ {{ number_format($room->hourly_rate, 2) }}</li>
                        </ul>
                    </article>
                </div>
            </section>
            @empty
            <p class="col-span-full text-center italic">There are no rooms yet.</p>
            @endforelse
        </div>


        @endforeach
    </main>
</x-layout>