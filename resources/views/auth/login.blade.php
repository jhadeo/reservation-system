<x-layout title="Login">
     <x-partials.home-nav></x-partials.home-nav>
    <main class="my-6 p-4">
        <h1 class="font-bold sm:text-6xl text-4xl flex justify-center m-10">Login</h1>
        <div class="flex justify-center-safe">
            <form action="/login" method="POST">
                @csrf
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-sm border p-4">
                    <x-forms.success />
                    <x-forms.error name="email" />

                    <label class="label">Email</label>
                    <input type="email" name="email" class="input w-sm" placeholder="Email" />

                    <label class="label">Password</label>
                    <input type="password" name="password" class="input w-sm" placeholder="Password" />

                    <button type="submit" class="btn btn-primary mt-4">Login</button>
                    <a href="/register" class="btn btn-secondary mt-4">Register</a>
                </fieldset>
            </form>

        </div>

    </main>

</x-layout>