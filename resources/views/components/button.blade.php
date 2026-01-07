<!-- resources/views/components/button.blade.php -->
@props(['variant' => 'primary', 'size' => 'md', 'disabled' => false])

@php
$variants = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    'accent' => 'btn-accent',
    'ghost' => 'btn-ghost',
    'outline' => 'btn-outline',
    'error' => 'btn-error',
    'success' => 'btn-success',
    'warning' => 'btn-warning',
];

$sizes = [
    'xs' => 'btn-xs',
    'sm' => 'btn-sm',
    'md' => '',
    'lg' => 'btn-lg',
];
@endphp

<button 
    {{ $attributes->merge(['class' => "btn {$variants[$variant]} {$sizes[$size]}"]) }}
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>
