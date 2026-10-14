<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsMaster extends Model
{
    use HasFactory;
    public $table = 'points_master';
    protected $fillable = [
        'points_name',
        'points',
        'created_at',
        'updated_at'
    ];
}
