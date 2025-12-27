<x-guest-layout>
    <p>Please verify your email address.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <x-primary-button>Resend Verification Email</x-primary-button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</x-guest-layout>
