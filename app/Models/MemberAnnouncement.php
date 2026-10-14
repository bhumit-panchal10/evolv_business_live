<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAnnouncement extends Model
{
    use HasFactory;
    public $table = 'MemberAnnouncement';
    protected $fillable = [
        'title',
        'photos',
        'description',
        'member_id',
        'created_at',
        'updated_at'
    ];
     public function member()
    {
        return $this->belongsTo(members::class, 'member_id', 'id');
    }
}
