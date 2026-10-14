<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    public $table = 'Reference';
    protected $fillable = [
        'Reference_id',
        'Reference_from',
        'Reference_to',
        'Reference_Date',
        'isapproved_status',
        'phonenumber',
        'Referencecomment',
        'approved_by',
        'approved_by_id',
    ];

}