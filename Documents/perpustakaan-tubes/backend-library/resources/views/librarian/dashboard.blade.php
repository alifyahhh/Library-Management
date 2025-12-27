<x-app-layout :header="__('Librarian Dashboard')">
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

    <ul>
        <li>Total Books: <b>{{ $totalBooks }}</b></li>
        <li>Total Categories: <b>{{ $totalCategories }}</b></li>
        <li>Total Borrowings: <b>{{ $totalBorrowings }}</b></li>
        <li>Unpaid Fines: <b>{{ $unpaidFines }}</b></li>
    </ul>
</x-app-layout>
