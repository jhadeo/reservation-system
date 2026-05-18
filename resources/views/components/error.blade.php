@props(['name'=>'required'])
@error($name)
    <p class="text-sm text-red-500 my-1">{{ $message }}</p>
@enderror