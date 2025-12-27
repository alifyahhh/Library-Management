<x-app-layout :header="__('Edit Category')">
    <form method="POST" action="{{ route('librarian.categories.update',$category) }}">
        @csrf @method('PUT')
        <p>Name</p>
        <input name="name" value="{{ old('name',$category->name) }}">
        @error('name') <p style="color:red">{{ $message }}</p> @enderror

        <p>Description</p>
        <textarea name="description">{{ old('description',$category->description) }}</textarea>

        <p><button>Save</button></p>
    </form>
</x-app-layout>
