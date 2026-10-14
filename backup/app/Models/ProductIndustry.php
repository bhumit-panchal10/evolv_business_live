<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIndustry extends Model
{
    use HasFactory;
    public $table = 'productindustry';
    protected $fillable = [
        'productid',
        'industryid'
    ];
}
