@props(['src' => null, 'class' => ''])

@php
$classes = 'w-10 h-10 rounded-full ' . $class;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
    @else
        <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
        </div>
    @endif
</div> 