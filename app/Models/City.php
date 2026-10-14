<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $table = 'city';
    protected $fillable = [
        'city_name'
    ];

    public function cityGroups()
    {
        return $this->hasMany(City_group::class, 'city_id');
    }
}
