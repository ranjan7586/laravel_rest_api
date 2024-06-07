<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe_Role extends Model
{
    protected $table='employe_roles';
    protected $fillable=['role_id','employe_id'];
    use HasFactory;
}
