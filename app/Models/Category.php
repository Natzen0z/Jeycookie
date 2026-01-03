<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the products for this category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get only active products for this category.
     */
    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    /**
     * Scope to get only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Get the route key name for model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the optimized image URL (Cloudinary or local).
     */
    public function getImageUrlAttribute(): ?string
    {
        return app(CloudinaryService::class)->getImageUrl($this->image);
    }

    /**
     * Get the thumbnail image URL.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        $cloudinary = app(CloudinaryService::class);
        
        if ($cloudinary->isCloudinaryImage($this->image)) {
            return $cloudinary->thumbnail($this->image, 200, 200);
        }

        return asset('storage/' . $this->image);
    }
}
