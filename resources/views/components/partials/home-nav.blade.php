    <header class="navbar bg-base-100 flex justify-between align-middle items-center sticky top-0 z-50 shadow-md p-4 text-sm md:text-base text-center">
        <h1>Company name</h1>

        <nav role="navigation" class="flex items-center gap-4">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/rooms">Rooms</a>
            @guest
                <a href="/login">Login</a>
            @endguest
            @auth
                <a href="/account">Account</a>
            @endauth
            <a href="/reserve-slot" class="btn btn-neutral rounded-full">Reserve a slot now!</a>
        </nav>
    </header>