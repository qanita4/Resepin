@props([
    'title',
    'image',
    'imageAlt' => null,
    'chef' => null,
    'description' => null,
    'badge' => null,
    'badgePosition' => 'none', // overlay, content, none
    'href' => null,
    'buttonText' => 'Lihat Resep',
    'contentClass' => '',
    'actionsClass' => 'mt-4',
])

@php
    $imageAlt = $imageAlt ?? $title;
    $contentClasses = trim($contentClass !== '' ? $contentClass : 'p-4');
    $hasCustomSlot = trim((string) $slot) !== '';
    $hasMetaSlot = isset($meta) && ! $meta->isEmpty();
@endphp

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl bg-white shadow-sm transition-shadow duration-300 hover:shadow-md']) }}>
    <a href="{{ $href }}" class="block relative aspect-[4/3] overflow-hidden">
        <img
            src="{{ asset('storage/' . $image) }}"
            alt="{{ $imageAlt }}"
            class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
        />

        @if ($badge && $badgePosition === 'overlay')
            <span class="absolute left-4 top-4 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-resepin-tomato shadow">
                {{ $badge }}
            </span>
        @endif
    </a>

    <div class="{{ $contentClasses }}">
        @if ($badge && $badgePosition === 'content')
            <p class="text-xs font-semibold uppercase tracking-wide text-resepin-tomato">{{ $badge }}</p>
        @endif

        <a href="{{ $href }}" class="block">
            <h3 class="{{ $badge && $badgePosition === 'content' ? 'mt-1' : 'mt-0' }} text-lg font-semibold text-gray-900 hover:text-resepin-tomato transition-colors">{{ $title }}</h3>
        </a>

        @if ($chef || $hasMetaSlot)
            <div class="mb-4 mt-2 flex items-center justify-between">
                @if ($chef)
                    <span class="text-sm text-gray-600">{{ $chef }}</span>
                @else
                    <span class="text-sm text-gray-600">&nbsp;</span>
                @endif

                @if ($hasMetaSlot)
                    <div class="flex items-center gap-2">
                        {{ $meta }}
                    </div>
                @endif
            </div>
        @endif

        @if ($description)
            <p class="mt-2 text-sm text-gray-600">{{ $description }}</p>
        @endif

        @php
            $shouldRenderAction = $hasCustomSlot || $href;
        @endphp

        @if ($shouldRenderAction)
            @php
                $actionsClasses = trim($actionsClass);
            @endphp

            <div class="{{ $actionsClasses !== '' ? $actionsClasses : 'mt-4' }}">
                @if ($hasCustomSlot)
                    {{ $slot }}
                @elseif ($href)
                    <x-recipe-button :href="$href">
                        {{ $buttonText }}
                    </x-recipe-button>
                @endif
            </div>
        @endif
    </div>
</div>
