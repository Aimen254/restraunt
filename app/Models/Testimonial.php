<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
      protected $fillable = [
        'name',
        'title',
        'comment',
        'rating',
        'avatar',
        'approved',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'approved' => 'boolean'
    ];

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : asset('images/default-avatar.jpg');
    }
}
