<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    public $table = 'Business';
    protected $fillable = [
        'business_id',
        'business_type',
        'business_from',
        'business_to',
        'business_Date',
        'isapproved_status',
        'Business_amount',
        'businesscomment',
        'approved_by',
        'approved_by_id',
    ];

}
