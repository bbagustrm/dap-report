<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Daily extends Model
{
    protected $casts = [
        'report' => 'array',
    ];

    use HasFactory;

}
