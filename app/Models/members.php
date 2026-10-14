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
        'Contact_person',
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
        'priority_club',
        'training_free',
        'brand_showcase',
        'from',
        'product_service',
        'pin',
        'SubscriptionExpiredDate'
    ];

    public function renewalhistory()
    {
        return $this->hasOne(renewalhistory::class, 'member_id');
    }
    public function referrer()
    {
        return $this->belongsTo(members::class, 'from', 'user_id');
    }

    public function referrals()
    {
        return $this->hasMany(members::class, 'from', 'user_id');
    }
}
