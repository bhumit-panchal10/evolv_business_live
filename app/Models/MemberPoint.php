<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPoint extends Model
{
    use HasFactory;
    public $table = 'member_points';
    protected $fillable = [
        'member_id',
        'business_id',
        'points_id',
        'points',
        'created_at',
        'updated_at',
        'status',
        'description'
    ];
}
