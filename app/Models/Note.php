<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable=[
        'name',
        'author',
        'description',
        'image',
        'note_content',
        'admin_id',
        'domain_id',
        'domain_name',
    ];
}
