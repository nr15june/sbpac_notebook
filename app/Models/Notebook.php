<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Borrowing;

class Notebook extends Model
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

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
