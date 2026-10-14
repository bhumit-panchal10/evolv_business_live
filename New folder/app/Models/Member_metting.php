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
          
    ];
}
