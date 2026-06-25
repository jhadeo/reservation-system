@props([
'name',
'bag' => 'default'
])

@error($name, $bag)
<p class="text-sm text-red-500">{{ $message }}</p>
@enderror