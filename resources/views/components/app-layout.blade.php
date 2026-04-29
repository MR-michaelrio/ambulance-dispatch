@php
    $attributes = $attributes->defaults(['class' => '']);
@endphp

@include('layouts.navigation')

<main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 {{ $attributes->get('class') }}">
    @if(isset($header))
        <div class="mb-6">
            {{ $header }}
        </div>
    @endif
    
    {{ $slot }}
</main>
