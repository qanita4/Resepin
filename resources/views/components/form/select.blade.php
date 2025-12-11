@props([
    'label' => null,
    'name' => '',
    'required' => false,
    'error' => null,
    'hint' => null,
    'options' => [],
    'value' => '',
    'placeholder' => null,
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
    
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $optionValue => $optionLabel)
            <option 
                value="{{ $optionValue }}" 
                {{ old($name, $value) == $optionValue ? 'selected' : '' }}
            >
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    
    @if($hint)
        <p class="mt-1 text-sm text-gray-500">{{ $hint }}</p>
    @endif
    
    @if($error || $errors->has($name))
        <p class="mt-1 text-sm text-red-500">{{ $error ?? $errors->first($name) }}</p>
    @endif
</div>
