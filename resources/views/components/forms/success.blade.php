@if(session()->has('success'))
    <div class="text-sm text-green-500 my-1">
        {{ session()->get('success') }}
    </div>
@endif