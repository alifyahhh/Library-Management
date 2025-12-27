<x-app-layout :header="__('Manage Categories')">
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <p><a href="{{ route('librarian.categories.create') }}">+ Create Category</a></p>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr><th>Name</th><th>Description</th><th>Action</th></tr>
        @foreach($categories as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->description }}</td>
                <td>
                    <a href="{{ route('librarian.categories.edit',$c) }}">Edit</a>
                    <form method="POST" action="{{ route('librarian.categories.destroy',$c) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div style="margin-top:12px;">{{ $categories->links() }}</div>
</x-app-layout>
