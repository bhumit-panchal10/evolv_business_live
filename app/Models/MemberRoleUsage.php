<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRoleUsage extends Model
{
    protected $fillable = [
        'member_id',
        'role_type',
        'meeting_id',
        'meeting_date'
    ];
}
