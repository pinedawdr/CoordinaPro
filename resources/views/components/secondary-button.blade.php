<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline border-neutral-300 text-neutral-700 hover:bg-neutral-50 focus:border-primary-500 focus:ring focus:ring-primary-200']) }}>
    {{ $slot }}
</button>