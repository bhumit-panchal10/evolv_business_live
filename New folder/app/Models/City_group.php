<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City_group extends Model
{
    use HasFactory;
    public $table = 'city_groups';
    protected $fillable = [
        'city_id',
        'group_name',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


}
