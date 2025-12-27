<x-app-layout :header="__('Edit Book')">
    <form method="POST" action="{{ route('librarian.books.update',$book) }}">
        @csrf @method('PUT')

        <p>Category</p>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected($book->category_id==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>

        <p>Title</p>
        <input name="title" value="{{ old('title',$book->title) }}">
        @error('title') <p style="color:red">{{ $message }}</p> @enderror

        <p>Author</p>
        <input name="author" value="{{ old('author',$book->author) }}">

        <p>ISBN</p>
        <input name="isbn" value="{{ old('isbn',$book->isbn) }}">

        <p>Stock</p>
        <input type="number" name="stock" value="{{ old('stock',$book->stock) }}">
        @error('stock') <p style="color:red">{{ $message }}</p> @enderror

        <p><button>Save</button></p>
    </form>
</x-app-layout>
