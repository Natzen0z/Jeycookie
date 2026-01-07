<!-- resources/views/components/input.blade.php -->
@props(['label' => null, 'type' => 'text', 'required' => false, 'error' => null])

<div class="form-control w-full">
    @if($label)
        <label class="label">
            <span class="label-text">{{ $label }}</span>
            @if($required)
                <span class="text-error">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="{{ $type }}"
        {{ $attributes->merge(['class' => 'input input-bordered w-full' . ($error ? ' input-error' : '')]) }}
        @if($required) required @endif
    />
    
    @if($error)
        <label class="label">
            <span class="label-text-alt text-error">{{ $error }}</span>
        </label>
    @endif
</div>
