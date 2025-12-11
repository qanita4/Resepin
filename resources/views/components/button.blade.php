@props([
    'variant' => 'primary', // primary, secondary, success, danger, outline
    'size' => 'md', // sm, md, lg
    'href' => null,
    'icon' => null,
])

@php
    $variantClasses = [
        'primary' => 'bg-resepin-tomato text-white hover:brightness-95 shadow-sm',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
        'success' => 'bg-resepin-green text-white hover:brightness-95 shadow-sm',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'outline' => 'border-2 border-gray-300 bg-white text-gray-700 hover:bg-gray-50',
    ];
    
    $sizeClasses = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2';
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if($icon)
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
        {{ $slot }}
    </button>
@endif
