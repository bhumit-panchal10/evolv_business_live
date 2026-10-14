<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member_metting extends Model
{
    use HasFactory;
    public $table = 'Cluster_Meet_Member_meeting';
    protected $fillable = [
        'meeting_id',
        'member_id',
        'ppt_taken_1',
        'ppt_taken_2',
        'brand_showcase_1',
        'brand_showcase_2',
        'brand_showcase_1_amount',
        'brand_showcase_2_amount',
        'is_approve',
        'is_approve_by',
        'is_approve_meeting'
    ];
}
