<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneToOne extends Model
{
    use HasFactory;
    public $table = 'one_to_one_detail';
    protected $fillable = [
        'from',
        'to',
        'place',
        'comment',
        'photo',
        'from_id',
        'to_id',
        'receive_date',
        'isapproved_status',
        'approved_by',
        'approved_by_id',
        'approveddatetime',
        'iStatus',
        'reject_comment',
        'isDelete',
        'strIP',
        'date',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
