<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrinterBorrowing extends Model
{
    use HasFactory;

    protected $table = 'printer_borrowings';

    protected $fillable = [
        'user_id',
        'printer_id',
        'phone',
        'borrow_date',
        'return_date',
        'status',
        'reject_reason',
        'rejected_at',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'rejected_at' => 'datetime',
    ];
    // ความสัมพันธ์กับ User
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // ความสัมพันธ์กับ Printer
    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(
            Accessory::class,
            'printer_borrowing_accessory',
            'printer_borrowing_id',
            'accessory_id'
        );
    }
}
