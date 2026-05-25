<x-layout>
    <main class="my-6 p-4">
        <h1 class="font-bold sm:text-6xl text-4xl flex justify-center m-10">Register</h1>
        <div class="flex justify-center-safe">
            <form action="/register" method="post">
                @csrf
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-sm border p-4">

                    <label class="label">Name</label>
                    <div class="flex gap-2">
                        <div>
                            <input class="input" name="first_name" placeholder="First Name" />
                            <x-forms.error name="first_name" />
                        </div>
                        <div>
                            <input class="input" name="last_name" placeholder="Last Name" />
                            <x-forms.error name="last_name" />
                        </div>
                    </div>

                    <label class="label">Email</label>
                    <input type="email" name="email" class="input w-sm" placeholder="ex: john@gmail.com" />
                    <x-forms.error name="email" />

                    <label class="label">Phone</label>
                    <input type="tel" name="phone" class="input w-sm" placeholder="ex: (09123456789)" />
                    <x-forms.error name="phone" />

                    <label class="label">Password</label>
                    <input name="password" type="password" class="input w-sm" placeholder="Password" />
                    <x-forms.error name="password" />

                    <button type="submit" class="btn btn-primary mt-4">Register</button>
                </fieldset>
            </form>

        </div>

    </main>

</x-layout>