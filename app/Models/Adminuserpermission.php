<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminuserpermission extends Model
{
    use HasFactory;
    public $table = 'Adminuser_permission';

    protected $fillable = [
    
        'permission_id',
        'user_id',
        'city',
        'city_group',
        'categories',
        'membershipplans',
        'overteem',
        'Banner',
        'members',
        'Products_service',
        'Renewalhistory',
        'Business',
        'reports',
        'Adminuser',
        'Blog',
        'gallery',
        'videogallery',
        'Event',
        'strIP',
        'iStatus',
        'isDelete',
    ];
}
