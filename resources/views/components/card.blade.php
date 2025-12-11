@props([
    'title' => null,
    'description' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => "rounded-xl bg-white shadow-md {$padding}"]) }}>
    @if($title)
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900">{{ $title }}</h2>
            @if($description)
                <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
            @endif
        </div>
    @endif
    
    {{ $slot }}
</div>
