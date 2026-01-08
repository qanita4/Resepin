@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'required' => false,
    'error' => null,
    'hint' => null,
    'value' => '',
    'min' => null,
    'max' => null,
])

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $name }}" class="mb-1 block font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        {{ $attributes->whereStartsWith('placeholder')->merge([
            'class' => 'w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20'
        ]) }}
    >
    
    @if($hint)
        <p class="mt-1 text-sm text-gray-500">{{ $hint }}</p>
    @endif
    
    @if($error || $errors->has($name))
        <p class="mt-1 text-sm text-red-500">{{ $error ?? $errors->first($name) }}</p>
    @endif
</div>
