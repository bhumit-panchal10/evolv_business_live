<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class members extends Model
{
    use HasFactory;
    public $table = 'members';
    protected $fillable = [
        'user_id',
        'companyname',
        'phonenumber',
        'email',
        'address',
        'city_id',
        'citygroup_id',
        'category_id',
        'subcategories_id',
        'pincode',
        'gstnumber',
        'budgecount',
        'Company_logo',
        'profile_photo',
        'facebook_link',
        'instagram_link',
        'linkedin_link',
        'youtube_link',
        'google_link',
        'Arrival_flag',
 
    ];

     public function renewalhistory()
    {
        return $this->hasOne(renewalhistory::class, 'member_id');
    }
}

