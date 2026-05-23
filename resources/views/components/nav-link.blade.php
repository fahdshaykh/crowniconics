@props(['href' => '#', 'active' => false, 'icon' => null])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'flex items-center gap-2 px-4 py-2 rounded-lg transition ' .
            ($active ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-200'),
    ]) }}>

    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif

    {{ $slot }}
</a>
