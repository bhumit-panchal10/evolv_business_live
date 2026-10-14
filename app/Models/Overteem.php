<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overteem extends Model
{
    use HasFactory;
    public $table = 'Overteem';
    protected $fillable = [
        'Overteem_id',
        'Overteem_name',
        'Overteem_photo',
        'description',
        'designation',
    ];

}
