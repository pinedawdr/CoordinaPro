@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-neutral-700']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-danger-600 ml-1">*</span>
    @endif
</label>