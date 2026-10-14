<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $table = 'news_and_events';
    protected $primaryKey = 'event_id';
    public $timestamps = true;
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'eventstart_date',
        'eventend_date',
        'event_type',
        'eventstart_time',
        'eventend_time',
        'member_id',
        'isapproved_status',
        'assign_member_id'
    ];

    public function member()
    {
        return $this->belongsTo(members::class, 'member_id', 'user_id');
    }
    public function EventMembers()
    {
        return $this->hasMany(EventMembers::class, 'event_id', 'event_id');
    }
}
