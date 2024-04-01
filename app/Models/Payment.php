<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Checkin;
use App\Models\Membership;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use CrudTrait;
    use HasFactory;
    
    protected $table = 'payments';
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function calculateEndDate()
    {
        $paymentFor = $this->payment_for;
        $endDate = null;

        switch ($paymentFor) {
            case 'Session':
                $endDate = Carbon::now()->endOfDay();
                break;
            case 'Monthly':
                $endDate = Carbon::now()->addMonth();
                break;
            case 'Bi-Monthly':
                $endDate = Carbon::now()->addMonths(2);
                break;
            case '6 Months':
                $endDate = Carbon::now()->addMonths(6);
                break;
            case '1 Year':
            case 'Annual-Fee':
                $endDate = Carbon::now()->addYear();
                break;
            default:
                $endDate = Carbon::now()->addMonth();
                break;
        }

        return $endDate->toDateString();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            $membership = Membership::where('member_id', $payment->member_id)->first();

            if ($membership) {
                // Update
                    //    Annual Only
                if ($payment->payment_for === 'Annual-Fee') {
                    $membership->annual_date_started = Carbon::now();
                    $membership->annual_date_end = Carbon::parse($membership->annual_date_end)->addYear();
                    // Other Options
                }else {
                    $membership->date_started = Carbon::now();
                    
                    switch ($payment->payment_for) {
                        case 'Session':
                            $membership->date_end = Carbon::parse($membership->date_end)->endOfDay();
                            break;
                        case 'Monthly':
                            $membership->date_end = Carbon::parse($membership->date_end)->addMonth();
                            break;
                        case 'Bi-Monthly':
                            $membership->date_end = Carbon::parse($membership->date_end)->addMonths(2);
                            break;
                        case '6 Months':
                            $membership->date_end = Carbon::parse($membership->date_end)->addMonths(6);
                            break;
                        case '1 Year':
                        case 'Annual-Fee':
                            $membership->date_end = Carbon::parse($membership->date_end)->addYear();
                            break;
                        default:
                            $membership->date_end = Carbon::parse($membership->date_end)->addMonth();
                            break; 
                    }
                }
                

                $membership->save();
                // Create
            } else {
                $membership = new Membership();
                $membership->member_id = $payment->member_id;
                // Annual
                if ($payment->payment_for === 'Annual-Fee') {
                    $membership->annual_date_started = Carbon::now();
                    $membership->annual_date_end = $payment->calculateEndDate();
                // Other Option
                } else {
                    $membership->date_started = Carbon::now();
                    $membership->date_end = $payment->calculateEndDate();    
                }
                $membership->save();
            }
        });
    }
    // Create checkin if the payment type is session
    protected static function booted()
    {
        parent::booted();

        static::created(function ($payment) {
            if ($payment->payment_for === 'Session') {
                Checkin::create([
                    'member_id' => $payment->member_id,
                    'checkin_time' => now(), 
                ]);
            }
        });
    }
}
