<!-- resources/views/components/alert.blade.php -->
@props(['type' => 'info', 'title' => null, 'dismissible' => true])

@php
$types = [
    'success' => 'alert-success',
    'error' => 'alert-error',
    'warning' => 'alert-warning',
    'info' => 'alert-info',
];
@endphp

<div class="alert {{ $types[$type] }} shadow-lg" role="alert">
    <div class="flex items-start gap-3">
        <div class="flex-1">
            @if($title)
                <h3 class="font-bold">{{ $title }}</h3>
            @endif
            <div class="text-sm">{{ $slot }}</div>
        </div>
        @if($dismissible)
            <button class="btn btn-sm btn-ghost" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
