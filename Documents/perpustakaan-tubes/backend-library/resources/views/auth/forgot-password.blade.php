<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" type="email" name="email" required />
        <x-primary-button class="mt-4">Send Reset Link</x-primary-button>
    </form>
</x-guest-layout>
