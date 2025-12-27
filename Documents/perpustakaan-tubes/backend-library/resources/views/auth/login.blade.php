<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mt-4">
            <label>
                <input type="checkbox" name="remember">
                Remember me
            </label>
        </div>

        <div class="mt-4 flex justify-between">
            <a href="{{ route('password.request') }}">Forgot password?</a>
            <x-primary-button>Login</x-primary-button>
        </div>
    </form>
</x-guest-layout>
