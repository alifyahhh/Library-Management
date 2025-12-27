<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <x-input-label value="Password" />
        <x-text-input type="password" name="password" required />
        <x-primary-button class="mt-4">Confirm</x-primary-button>
    </form>
</x-guest-layout>
