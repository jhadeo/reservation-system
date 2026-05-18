<x-layout title="Contact">
    <main class="my-6 p-4">
        <h1 class="font-bold text-black sm:text-6xl text-4xl flex justify-center m-10">Contact Us!</h1>
        <h2 class="font-bold text-black flex justify-center mt-10">We want to hear from you, from feedback to inquiries!</h2>
        <h2 class="font-bold text-black flex justify-center mt-2 mb-10">Say hi, or ask questions regarding our services</h2>
        <div class="flex justify-center-safe">
            <form action="/contact" method="post" class="w-auto h-auto sm:w-150 sm:h-150 shadow-2xl p-6">
                @csrf

                <x-error name="email" />
                <x-error name="name" />
                <x-error name="message" />
                @if(session()->has('success'))
                <div class="text-sm text-green-500 my-1">
                    {{ session()->get('success') }}
                </div>
                @endif

                <fieldset class="flex flex-col justify-items-start gap-2 h-auto w-auto">
                    <label for="email">Email: <span class="text-sm text-red-500">*</span></label>
                    <input type="email" name="email" id="email" class="border rounded-sm shadow-sm p-2" required>
                    <label for="name">Name: <span class="italic text-gray-600">(Optional)</span></label>
                    <input type="text" name="name" id="name" class="border rounded-sm shadow-sm p-2">
                    <label for="message">Message: <span class="text-sm text-red-500">*</span></label>
                    <textarea name="message" id="message" cols="30" rows="10" class="border rounded-sm shadow-sm resize-none p-2" required></textarea>
                </fieldset>
                <div class="flex justify-end">
                    <input type="submit" value="Submit" class="rounded-md text-white bg-black p-2 mt-4 ">
                </div>
            </form>
        </div>
    </main>
</x-layout>