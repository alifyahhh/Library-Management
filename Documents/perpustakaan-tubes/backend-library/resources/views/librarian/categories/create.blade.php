<x-app-layout :header="__('Create Category')">
    <form method="POST" action="{{ route('librarian.categories.store') }}">
        @csrf
        <p>Name</p>
        <input name="name" value="{{ old('name') }}">
        @error('name') <p style="color:red">{{ $message }}</p> @enderror

        <p>Description</p>
        <textarea name="description">{{ old('description') }}</textarea>

        <p><button>Create</button></p>
    </form>
</x-app-layout>
