<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membershipplans extends Model
{
    use HasFactory;
    public $table = 'membership_plans';
    protected $fillable = [
        'plan_name',
        'duration_in_days',
        'amount',
        'discount',
    ];

}

