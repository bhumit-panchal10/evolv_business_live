<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class renewalhistory extends Model
{
    use HasFactory;
   public $table = 'renewal_history';
    protected $fillable = [
         
        'member_id',
        'plan_id',
        'renewal_date',
        'paymentrefNo',
        'substartdate',
        'stbenddate',
        'pincode',
        'gstnumber',
        'budgecount',
 
    ];

    public function members()
    {
        return $this->belongsTo(members::class, 'member_id');
    }

}

