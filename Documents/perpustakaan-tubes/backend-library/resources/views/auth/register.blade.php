<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" name="name" required autofocus />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
        </div>

        <div class="mt-4 flex justify-end">
            <x-primary-button>Register</x-primary-button>
        </div>
    </form>
</x-guest-layout>
