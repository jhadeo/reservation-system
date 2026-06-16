@props(["name" => ''])    
    <header class="navbar bg-base-100 flex justify-between align-middle items-center sticky top-0 z-50 shadow-md p-4 text-sm md:text-base text-center">
        <h1>Hello, {{ $name }}!</h1>

        <nav role="navigation" class="flex items-center gap-4">
            <a href="/client/home">Home</a>
            <a href="/rooms">Rooms</a>
            <form action="/logout" method="post">
                @csrf
                @method("DELETE")
                <button class="cursor-pointer">Logout</button>
            </form>
            <a href="/reserve-slot" class="btn btn-neutral rounded-full">Reserve a room</a>
        </nav>
    </header>