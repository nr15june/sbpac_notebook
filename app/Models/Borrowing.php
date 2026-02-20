<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accessory;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'notebook_id',
        'borrow_date',
        'return_date',
        'status',
        'reject_reason',
        'rejected_at',
    ];

    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function accessories()
    {
        return $this->belongsToMany(\App\Models\Accessory::class, 'borrowing_accessory')
            ->withPivot('is_returned', 'note');
    }

    // จำนวนวันที่ยืมไปแล้ว
    public function daysUsed()
    {
        return Carbon::parse($this->borrow_date)->diffInDays(now());
    }

    public function isOverdue()
    {
        return $this->status == 'borrowed' && now()->gt($this->return_date);
    }

    public function daysLeft()
    {
        return Carbon::today()->diffInDays(Carbon::parse($this->return_date), false);
    }
}
