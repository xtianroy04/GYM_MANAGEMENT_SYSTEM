<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use CrudTrait;
    protected $fillable = ['member_id', 'checkin_date'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    use HasFactory;

    protected static function booted()
    {
        parent::booted();

        static::created(function ($payment) {
            if ($payment->payment_for === 'Session') {
                // Create a new Checkin record
                Checkin::create([
                    'member_id' => $payment->member_id,
                    'checkin_time' => now(), // or use any other timestamp
                ]);
            }
        });
    }
}