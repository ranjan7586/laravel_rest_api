<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
    ];
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employe_roles', 'role_id','employe_id');
    }
}
