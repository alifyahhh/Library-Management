@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ($messages as $message)
    <div style="color:red">{{ $message }}</div>
@endforeach

    </ul>
@endif
