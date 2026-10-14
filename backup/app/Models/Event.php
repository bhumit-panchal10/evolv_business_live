<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $table = 'news_and_events';
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'eventstart_date',
        'eventend_date',

    ];
}
