<x-layout title="Contact">
    <x-partials.home-nav></x-partials.home-nav>
    <div class="my-6 p-4">
        <h1 class="font-bold sm:text-6xl text-4xl flex justify-center m-10">Contact Us!</h1>
        <h2 class="font-bold flex justify-center mt-10">We want to hear from you, from feedback to inquiries!</h2>
        <h2 class="font-bold flex justify-center mt-2 mb-10">Say hi, or ask questions regarding our services</h2>
        <div class="flex justify-center-safe">
            <x-forms.success />
            <form action="/contact" method="post" class="w-auto h-auto sm:w-150 sm:h-150 p-6">
                @csrf
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4 w-auto h-auto">
                    <label for="email">Email: <span class="text-sm text-red-500">*</span></label>
                    <input type="email" name="email" id="email" class="border rounded-sm p-2" required>
                    <x-forms.error name="email" />
                    <label for="name">Name: <span class="italic text-gray-600">(Optional)</span></label>
                    <input type="text" name="name" id="name" class="border rounded-sm  p-2">
                    <x-forms.error name="name" />
                    <label for="message">Message: <span class="text-sm text-red-500">*</span></label>
                    <textarea name="message" id="message" cols="30" rows="10" class="border rounded-sm resize-none p-2" required></textarea>
                    <x-forms.error name="message" />
                    <div class="flex justify-end">
                        <input type="submit" value="Submit" class="rounded-md text-white bg-black p-2 mt-4 ">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <x-partials.footer />

</x-layout>