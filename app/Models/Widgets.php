<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{

    protected $table = 'widgets';
    protected $fillable = ['widget_id','widget_name','name','content','type','position'];

    use HasFactory;
}
