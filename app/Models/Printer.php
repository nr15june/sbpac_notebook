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

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'available' => 'พร้อมใช้งาน',
            'pending'   => 'รออนุมัติ',
            'borrowed'  => 'ถูกยืม',
            'repair'    => 'ซ่อม',
            'disabled'  => 'ปิดใช้งาน',
            default     => 'ไม่ทราบสถานะ',
        };
    }
}
