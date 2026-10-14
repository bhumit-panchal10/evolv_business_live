<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMembers extends Model
{
    use HasFactory;
    public $table = 'event_members';
    protected $fillable = [
        'id',
        'event_id',
        'member_id',
        'isapproved_status',
        'absent',
        'created_at'
    ];

    public function member()
    {
        return $this->belongsTo(members::class, 'member_id', 'id');
    }
}
