<x-layout title="Forgot Password">
     <x-partials.home-nav></x-partials.home-nav>
    <main class="my-6 p-4">
        <h1 class="font-bold sm:text-6xl text-4xl flex justify-center m-10">Forgot Password</h1>
        <div class="flex justify-center-safe">
            <form action="{{route('password.email')}}" method="POST">
                @csrf
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-sm border p-4">
                    <x-forms.success />
                    <label class="label">Email</label>
                    <input type="email" name="email" class="input w-sm" placeholder="Email" />
                    <x-forms.error name="email" />
                    <button type="submit" class="btn btn-primary mt-4 w-sm">Send email</button>
                </fieldset>
            </form>

        </div>

    </main>

</x-layout>