<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminfrontimage extends Model
{
    use HasFactory;
    public $table = 'Adminfrontimage';
    protected $fillable = [
        'Title',
        'photo',
        'button_link',
    ];

    
}