<?php

namespace App\Models;

use App\Models\Membership;
use App\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use CrudTrait;


    protected $fillable = ['first_name', 'last_name', 'email', 'contact_number', 'status'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            $latestMember = static::latest()->first();
            $latestId = $latestMember ? $latestMember->id : 0;
            $member->code = now()->format('md') . '-' . str_pad($latestId + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function latestCheckin()
    {
        return $this->hasOne(Checkin::class)->latest(); 
    }
    
  
    // Create Qr Code
    protected static function booted()
    {
        static::creating(function ($member) {
            $qrCode = QrCode::size(300)->generate($member->code);
            $fileName = $member->code;
            $publicPath = public_path('assets/qrcodes/' . $fileName);
            File::put($publicPath, $qrCode);
            $member->qrcode = 'assets/qrcodes/' . $fileName;
        });
    }

    // Check if the member is already exist!
    
    use HasFactory;
}
