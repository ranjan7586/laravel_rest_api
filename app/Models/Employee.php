<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employe_roles','employe_id');
    }
}
