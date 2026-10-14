<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryDetail extends Model
{
    use HasFactory;
    public $table = 'photo_gallery_detail';
    protected $fillable = [

        'gallery_id',
        'photo'
    ];
}
