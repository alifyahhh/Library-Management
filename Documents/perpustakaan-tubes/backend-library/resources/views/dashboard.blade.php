<x-app-layout :header="__('Dashboard')">
    <p>Welcome, {{ auth()->user()->name }} (role: {{ auth()->user()->role }})</p>

    @if(auth()->user()->role === 'librarian')
        <p><a href="{{ route('librarian.dashboard') }}">Go to Librarian Dashboard</a></p>
    @endif
</x-app-layout>
