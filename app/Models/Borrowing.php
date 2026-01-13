<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accessory;

class Borrowing extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'notebook_id',
        'borrow_date',
        'return_date',
        'status'
    ];

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'borrowing_accessory');
    }

    
}
