<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;
    public $table = 'industry';
    protected $fillable = [
        'industryname',
        'photo',
    ];
}
