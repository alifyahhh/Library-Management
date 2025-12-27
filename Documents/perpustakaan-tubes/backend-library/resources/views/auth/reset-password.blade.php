<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-input-label value="Email" />
        <x-text-input name="email" value="{{ old('email', $request->email) }}" required />

        <x-input-label value="Password" />
        <x-text-input type="password" name="password" required />

        <x-input-label value="Confirm Password" />
        <x-text-input type="password" name="password_confirmation" required />

        <x-primary-button class="mt-4">Reset Password</x-primary-button>
    </form>
</x-guest-layout>
