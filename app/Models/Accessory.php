<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Borrowing;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function borrowings()
    {
        return $this->belongsToMany(Borrowing::class, 'borrowing_accessory');
    }
}