<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    public $table = 'visitors';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo',
        'business_name',
        'business_catgory',
        'member_id',
        'iStatus',
        'created_at',
        'updated_at',
        'created_by',
        'meeting_id',
        'comments'
    ];

    public function business_category()
    {
        return $this->belongsTo(Categories::class, 'business_catgory', 'id');
    }

    public function members()
    {
        return $this->belongsTo(members::class, 'member_id', 'id');
    }
    
    public function Cluster_metting()
    {
        return $this->belongsTo(Cluster_metting::class, 'meeting_id', 'id');
    }
}
