<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBanner extends Model
{
    protected $fillable = [
        'title', 'position', 'link', 'image', 'active',
        'badge_text', 'subtitle', 'button_text',
        'bg_color', 'bg_color_2', 'text_color',
    ];

    protected $casts = ['active' => 'boolean'];
}
