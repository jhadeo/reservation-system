<x-layout title="Reset Password">
    <div class="flex min-h-screen w-full flex-col items-center justify-center gap-10 px-4">
        <h1 class="font-bold sm:text-6xl text-4xl text-center">Reset your password</h1>
        <form action="{{route('password.update')}}" method="POST" class="w-full max-w-sm">
            @csrf
            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
                <input type="hidden" name="token" value="{{ $data['token'] }}">
                <input type="hidden" name="email" value="{{ $data['email'] }}">
                <label class="label">Password</label>
                <input type="password" name="password" class="input w-full" placeholder="Password" />

                <label class="label">Confirm password</label>
                <input type="password" name="password_confirmation" class="input w-full" placeholder="Confirm Password" />
                <x-forms.error name="password"/>
                    <button type="submit" class="btn btn-primary mt-4">Reset Password</button>
            </fieldset>
        </form>
    </div>
</x-layout>