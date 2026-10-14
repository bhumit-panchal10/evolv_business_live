<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster_metting extends Model
{
    use HasFactory;
    public $table = 'Cluster_Meet';
    protected $fillable = [
        'id',
        'city_id',
        'city_group_id',
        'Meeting_title',
        'venue',
        'start_date',
        'End_date',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at'
    ];
}
