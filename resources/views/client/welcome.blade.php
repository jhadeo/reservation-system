<x-layout>
    <form action="/logout" method="post">
        @csrf
        @method("DELETE")
        <button class="btn btn-primary">Logout</button>
    </form>
    </main>
</x-layout>