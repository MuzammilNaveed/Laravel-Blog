<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_has_Permission extends Model
{
    protected $table = 'role_has_permissions';
    protected $fillable = ['feature_id','role_id'];
    use HasFactory;
}
