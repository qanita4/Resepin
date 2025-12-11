@props([
    'icon' => null,
    'badge' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between']) }}>
    <h2 class="text-2xl font-bold text-gray-900">
        @if($icon)
            <span class="flex items-center gap-2">
                {!! $icon !!}
                {{ $slot }}
            </span>
        @else
            {{ $slot }}
        @endif
    </h2>
    
    @if($badge)
        <div>
            {{ $badge }}
        </div>
    @endif
</div>
