<x-app-layout :header="__('Create Book')">
    <form method="POST" action="{{ route('librarian.books.store') }}">
        @csrf

        <p>Category</p>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        <p>Title</p>
        <input name="title" value="{{ old('title') }}">
        @error('title') <p style="color:red">{{ $message }}</p> @enderror

        <p>Author</p>
        <input name="author" value="{{ old('author') }}">

        <p>ISBN</p>
        <input name="isbn" value="{{ old('isbn') }}">

        <p>Stock</p>
        <input type="number" name="stock" value="{{ old('stock',0) }}">
        @error('stock') <p style="color:red">{{ $message }}</p> @enderror

        <p><button>Create</button></p>
    </form>
</x-app-layout>
