<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
        protected $fillable = [
        'name',
        'capacity',
        'position',
        'is_available',
    ];
}
