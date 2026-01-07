# 📦 Custom Components Usage Guide

Berikut adalah custom Blade components yang telah dibuat untuk memudahkan development:

## 1. Button Component

### Usage
```blade
<!-- Basic Button -->
<x-button>Click Me</x-button>

<!-- With Variant -->
<x-button variant="primary">Primary</x-button>
<x-button variant="secondary">Secondary</x-button>
<x-button variant="accent">Accent</x-button>
<x-button variant="ghost">Ghost</x-button>
<x-button variant="outline">Outline</x-button>
<x-button variant="error">Error</x-button>
<x-button variant="success">Success</x-button>
<x-button variant="warning">Warning</x-button>

<!-- With Size -->
<x-button size="xs">Extra Small</x-button>
<x-button size="sm">Small</x-button>
<x-button size="md">Medium</x-button>
<x-button size="lg">Large</x-button>

<!-- Disabled -->
<x-button disabled>Disabled</x-button>

<!-- With Icon -->
<x-button variant="primary">
    <i class="fas fa-save mr-2"></i>
    Save
</x-button>

<!-- With Additional Classes -->
<x-button variant="primary" class="w-full">Full Width</x-button>

<!-- As Link -->
<a href="{{ route('products.index') }}" class="btn btn-primary">
    <i class="fas fa-arrow-right"></i>
    Shop Now
</a>
```

## 2. Card Component

### Usage
```blade
<!-- Basic Card -->
<x-card>
    This is a simple card content
</x-card>

<!-- Card with Title -->
<x-card title="Product Details">
    <p>Product information goes here</p>
</x-card>

<!-- Compact Card -->
<x-card compact title="Info">
    Small card content
</x-card>

<!-- Card with Image -->
<x-card title="Featured">
    <img src="image.jpg" alt="Featured" class="w-full h-48 object-cover rounded mb-4" />
    <p>Description here</p>
</x-card>

<!-- Multiple Cards in Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-card title="Card 1">Content 1</x-card>
    <x-card title="Card 2">Content 2</x-card>
    <x-card title="Card 3">Content 3</x-card>
</div>
```

## 3. Alert Component

### Usage
```blade
<!-- Success Alert -->
<x-alert type="success" title="Success!">
    Your changes have been saved successfully.
</x-alert>

<!-- Error Alert -->
<x-alert type="error" title="Error!">
    Something went wrong. Please try again.
</x-alert>

<!-- Warning Alert -->
<x-alert type="warning" title="Warning!">
    Please review the following information.
</x-alert>

<!-- Info Alert -->
<x-alert type="info" title="Information">
    This is an informational message.
</x-alert>

<!-- Non-dismissible Alert -->
<x-alert type="success" title="Notice" :dismissible="false">
    This alert cannot be dismissed
</x-alert>

<!-- Without Title -->
<x-alert type="success">
    Product added to cart!
</x-alert>
```

## 4. Modal Component

### Usage
```blade
<!-- Define Modal -->
<x-modal id="deleteModal" title="Confirm Delete">
    <p>Are you sure you want to delete this item?</p>
    <form action="{{ route('items.destroy', $item) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-error">Delete</button>
    </form>
</x-modal>

<!-- Trigger Button -->
<button data-modal="deleteModal" class="btn btn-outline btn-error">
    <i class="fas fa-trash"></i>
    Delete
</button>

<!-- Edit Modal -->
<x-modal id="editModal" title="Edit Product">
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-input label="Product Name" name="name" value="{{ $product->name }}" required />
        <x-input label="Price" name="price" type="number" value="{{ $product->price }}" required />
        
        <div class="modal-action">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</x-modal>

<!-- Open Modal Programmatically -->
<button onclick="document.getElementById('editModal').showModal()" class="btn">
    Edit
</button>
```

## 5. Input Component

### Usage
```blade
<!-- Basic Input -->
<x-input name="username" />

<!-- With Label -->
<x-input label="Username" name="username" />

<!-- Required Field -->
<x-input label="Email" name="email" type="email" required />

<!-- With Error -->
<x-input 
    label="Password" 
    name="password" 
    type="password" 
    error="Password must be at least 8 characters"
/>

<!-- Using $errors Blade Variable -->
<x-input 
    label="Name" 
    name="name"
    :error="$errors->first('name')"
/>

<!-- Different Input Types -->
<x-input label="Text" type="text" name="text" />
<x-input label="Email" type="email" name="email" />
<x-input label="Password" type="password" name="password" />
<x-input label="Number" type="number" name="quantity" />
<x-input label="Date" type="date" name="date" />
<x-input label="File" type="file" name="avatar" />

<!-- In Form -->
<form action="{{ route('products.store') }}" method="POST" class="space-y-4">
    @csrf
    
    <x-input 
        label="Product Name" 
        name="name" 
        required
        :error="$errors->first('name')"
    />
    
    <x-input 
        label="Price" 
        type="number" 
        name="price" 
        step="0.01" 
        required
        :error="$errors->first('price')"
    />
    
    <x-button type="submit" variant="primary">Save Product</x-button>
</form>
```

## Combining Components

### Complete Form Example
```blade
<x-card title="Create Product">
    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <x-input 
            label="Product Name" 
            name="name" 
            placeholder="Enter product name"
            required 
            :error="$errors->first('name')"
        />
        
        <x-input 
            label="Description" 
            name="description" 
            placeholder="Enter description"
            :error="$errors->first('description')"
        />
        
        <x-input 
            label="Price" 
            type="number" 
            name="price" 
            step="0.01" 
            required
            :error="$errors->first('price')"
        />
        
        <x-input 
            label="Stock" 
            type="number" 
            name="stock" 
            required
            :error="$errors->first('stock')"
        />
        
        <div class="flex gap-2">
            <x-button type="submit" variant="primary">
                <i class="fas fa-save mr-2"></i>
                Save Product
            </x-button>
            <x-button type="reset" variant="ghost">Reset</x-button>
        </div>
    </form>
</x-card>
```

### Success Message with Alert
```blade
@if(session('success'))
    <x-alert type="success" title="Success!">
        {{ session('success') }}
    </x-alert>
@endif

@if($errors->any())
    <x-alert type="error" title="Validation Error">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
```

## Component Features

### Button Features
- Variants: primary, secondary, accent, ghost, outline, error, success, warning
- Sizes: xs, sm, md, lg
- Disabled state support
- Supports all standard button attributes

### Card Features
- Optional title
- Compact mode for smaller cards
- Shadow and hover effects
- Responsive design

### Alert Features
- Types: success, error, warning, info
- Optional title
- Dismissible by default
- Custom styling per type

### Modal Features
- Custom ID for targeting
- Title support
- Backdrop dismiss
- Action buttons included

### Input Features
- All HTML input types supported
- Label support
- Error message display
- Required field indicator
- Supports all standard input attributes

## Best Practices

1. **Always use components** instead of raw HTML for consistency
2. **Use proper spacing** with `space-y-4` in forms
3. **Always add labels** for accessibility
4. **Validate on the backend** even with frontend validation
5. **Use proper input types** (email, number, date, etc.)
6. **Handle errors gracefully** with error messages

## File Locations

- Button: `resources/views/components/button.blade.php`
- Card: `resources/views/components/card.blade.php`
- Alert: `resources/views/components/alert.blade.php`
- Modal: `resources/views/components/modal.blade.php`
- Input: `resources/views/components/input.blade.php`

---

**Last Updated**: January 7, 2026
