<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminuser extends Model
{
    use HasFactory;
    public $table = 'users';
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'email',
        'role_id',    
    ];
}
