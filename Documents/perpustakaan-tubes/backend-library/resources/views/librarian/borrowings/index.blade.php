<x-app-layout :header="__('Borrowings')">
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>User</th><th>Book</th><th>Status</th><th>Due</th><th>Fine</th><th>Action</th>
        </tr>
        @foreach($borrowings as $b)
            <tr>
                <td>{{ $b->user?->name }}</td>
                <td>{{ $b->book?->title }}</td>
                <td>{{ $b->status }}</td>
                <td>{{ $b->due_date }}</td>
                <td>
                    @if($b->fine)
                        Rp {{ number_format($b->fine->amount) }} ({{ $b->fine->status }})
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($b->status !== 'returned')
                        <form method="POST" action="{{ route('librarian.borrowings.return',$b) }}">
                            @csrf
                            <button>Force Return</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    <div style="margin-top:12px;">{{ $borrowings->links() }}</div>
</x-app-layout>
