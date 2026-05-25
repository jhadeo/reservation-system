@props(["name" => ''])    
    <header class="navbar bg-base-100 flex justify-between align-middle items-center sticky top-0 z-50 shadow-md p-4 text-sm md:text-base text-center">
        <h1>Hello, {{ $name }}!</h1>

        <nav role="navigation" class="flex items-center gap-4">
            <a href="/staff/home">Home</a>
            <a href="/staff/reservations">Reservations</a>
            <a href="/staff/rooms">Rooms</a>
            <form action="/logout" method="post">
                @csrf
                @method("DELETE")
                <button class="btn btn-neutral">Logout</button>
            </form>
        </nav>
    </header>