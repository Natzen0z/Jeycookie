<!-- resources/views/components/card.blade.php -->
@props(['title' => null, 'compact' => false])

<div class="card bg-base-100 shadow-lg {{ $compact ? 'compact' : '' }}">
    @if($title)
        <div class="card-body">
            <h2 class="card-title">{{ $title }}</h2>
            {{ $slot }}
        </div>
    @else
        <div class="card-body">
            {{ $slot }}
        </div>
    @endif
</div>
