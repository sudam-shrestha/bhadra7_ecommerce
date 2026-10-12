@props(['status'])

@php
    $classes = match ($status) {
        'processing' => 'bg-blue-50 text-blue-700',
        'completed' => 'bg-green-50 text-green-700',
        default => 'bg-amber-50 text-amber-700',
    };
@endphp

<span {{ $attributes->class(['inline-block rounded-full px-3 py-1 text-xs font-semibold', $classes]) }}>
    {{ ucfirst($status) }}
</span>
