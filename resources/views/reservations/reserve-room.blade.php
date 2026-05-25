<x-layout title="Reserve a room">
     <x-partials.home-nav></x-partials.home-nav>
    <main>
        <div class="flex flex-col m-auto w-full">
            <h1 class="font-bold sm:text-6xl text-4xl flex justify-center m-10">Reserve a Room</h1>
            @guest
            <p class="w-200 mx-auto text-center"><a href="/login" class="link-primary">Log in</a> or <a href="/register" class="link-secondary">register</a> an account to reserve a room.</p>
            @endguest
            <div class="flex w-full justify-center">
                <x-partials.timeline></x-partials.timeline>
            </div>
            <div class="">
                <!-- form.... -->
            </div>
        </div>
    </main>
</x-layout>