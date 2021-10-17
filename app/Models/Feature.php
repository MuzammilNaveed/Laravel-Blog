<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{

    protected $table = 'feature';
    protected $fillable = ['title','slug','route','sequence','parent_id',
    'is_active','role_id','feature_type','menu_icon'];
    use HasFactory;


    public function sub_menu() {
        return $this->hasMany(Feature::class,'parent_id','id');
    }

}
