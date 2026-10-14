<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $table = 'product';
    protected $fillable = [
        'model_code',
        'serial_no',
        'dealer_code',
        'invoice_no',
        'serviceproviderid',
        'validateBy',
        'financedate',
    ];
}
