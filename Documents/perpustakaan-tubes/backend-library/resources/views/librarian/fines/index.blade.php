<x-app-layout :header="__('Fines')">
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr><th>User</th><th>Book</th><th>Amount</th><th>Status</th><th>Action</th></tr>
        @foreach($fines as $f)
            <tr>
                <td>{{ $f->borrowing?->user?->name }}</td>
                <td>{{ $f->borrowing?->book?->title }}</td>
                <td>Rp {{ number_format($f->amount) }}</td>
                <td>{{ $f->status }}</td>
                <td>
                    @if($f->status === 'unpaid')
                        <form method="POST" action="{{ route('librarian.fines.pay',$f) }}">
                            @csrf
                            <button>Mark Paid</button>
                        </form>
                    @else
                        Paid at {{ $f->paid_at }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    <div style="margin-top:12px;">{{ $fines->links() }}</div>
</x-app-layout>
