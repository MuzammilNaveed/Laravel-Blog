<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $table = 'menu_items';
    protected $fillable = ['name','slug','type','category_id','page_id','url','icon','target','parent_id','status','menu_id'];
    use HasFactory;
}
