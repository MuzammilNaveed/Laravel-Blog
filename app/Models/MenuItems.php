<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $table = 'menu_items';
    protected $fillable = ['name','slug','type','category_id','page_id','url','icon','target','parent_id','position','status','menu_id'];
    

    public function childs() {
        return $this->hasMany( MenuItems::class,'parent_id','id') ;
    }


    use HasFactory;

}
