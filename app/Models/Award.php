<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    public $table = 'Award';
    protected $fillable = [
        'title',
        'photos',
        'description',
        'member_id',
        'created_at',
        'updated_at'
    ];
}
