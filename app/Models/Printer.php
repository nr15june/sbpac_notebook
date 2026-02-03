<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code',
        'brand',
        'model',
        'status',
        'note',
        'image',
    ];
}
