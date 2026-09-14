<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * Canonical "roles" a Collection can be tagged with, matching the
     * commonly-labeled fixed sections themes render (Best Sellers,
     * Recommended For You, etc.). At most one Collection can hold a given
     * role at a time -- see CollectionController for the single-owner
     * enforcement. A Collection with no role is just a regular, freely
     * placeable homepage block.
     */
    public const ROLES = [
        'best_sellers' => 'Best Sellers',
        'recommended' => 'Recommended For You',
        'new_arrivals' => 'New Arrivals',
        'trending' => 'Trending Now',
    ];

    protected $fillable = [
        'title',
        'slug',
        'role',
        'description',
        'sort_order',
        'limit',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'limit' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product')
            ->withPivot(['sort_order', 'pinned'])
            ->withTimestamps()
            ->orderBy('collection_product.sort_order');
    }
}
