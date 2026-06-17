@props(["name" => ''])
<header class="navbar bg-base-100 flex justify-between align-middle items-center sticky top-0 z-50 shadow-md p-4 text-sm md:text-base text-center">
    <h1>Hello, {{ $name }}!</h1>

    <nav role="navigation" class="flex items-center gap-4">
        <a href="/admin/home">Home</a>
        <a href="/admin/rooms">Manage Rooms</a>
        <a href="/admin/room-types">Manage Room Types</a>
        <a href="/admin/staff">Manage Staff</a>
        <form action="/logout" method="post">
            @csrf
            @method("DELETE")
            <button class="btn btn-neutral">Logout</button>
        </form>
    </nav>
</header>