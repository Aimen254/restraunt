<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
      protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'is_active',
        'image',
        'prep_time',
    ];

      public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
