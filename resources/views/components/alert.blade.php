@props([
    'type' => 'success', // success, error, warning, info
    'dismissible' => false,
])

@php
    $typeClasses = [
        'success' => 'bg-green-100 text-green-700 border-green-200',
        'error' => 'bg-red-100 text-red-700 border-red-200',
        'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
        'info' => 'bg-blue-100 text-blue-700 border-blue-200',
    ];
    
    $iconPaths = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['success'];
@endphp

<div {{ $attributes->merge(['class' => "mb-6 rounded-lg border p-4 {$classes}"]) }}>
    <div class="flex items-start gap-3">
        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPaths[$type] }}" />
        </svg>
        
        <div class="flex-1">
            {{ $slot }}
        </div>
        
        @if($dismissible)
            <button type="button" onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 hover:opacity-70">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>
