<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
class Donor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'donor_id',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'fullname',
        'address',
        'hospital',
        'diagnosis',
        'gender',
        'phone',
        'amount',
        'category',
        'golongan_darah',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function details()
    {
        return $this->hasMany(DonorDetail::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
