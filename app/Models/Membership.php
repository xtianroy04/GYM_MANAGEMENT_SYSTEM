<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'memberships';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    protected static function booted()
    {
        static::saving(function ($membership) {
            if ($membership->annual_date_end !== null) {
                if ($membership->annual_date_end > now()) {
                    $membership->status = 'Active';
                } else {
                    $membership->status = 'Cancelled';
                }
            } else {
                $membership->status = null; 
            }
    
            if ($membership->date_end !== null) {
                if (Carbon::parse($membership->date_end)->isFuture()) {
                    $membership->subscription_status = 'Active';
                } else {
                    $membership->subscription_status = 'Expired';
                }   
            } else {
                $membership->subscription_status = null; 
            }
        });
    }
    


    
}
