<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $table = 'blogs';

    protected $fillable = [
    
        'user_id',
        'blogTitle',
        'blog_slug',
        'content',
        'status',
        'blogDescription',
        'blogDate',
        'urlParameter',
        'rejectedcomments',
        'blogImage',
        'tags',
        'metaTitle',
        'metaKeyword',
        'metaDescription',
        'strIP',
        'iStatus',
        'isDelete',
    ];

   
}