<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products_service extends Model
{
    use HasFactory;
    public $table = 'member_services';
    protected $fillable = [
        'member_id',
        'product_name',
        'photo',
        'description',
        'price',
        'product_category_Id',
    ];
}
