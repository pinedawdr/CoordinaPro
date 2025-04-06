@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-b-2 border-primary-600 text-sm font-medium leading-5 text-primary-700 focus:outline-none focus:border-primary-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-neutral-600 hover:text-neutral-800 hover:border-neutral-300 focus:outline-none focus:text-neutral-800 focus:border-neutral-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
