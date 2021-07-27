<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'site_name',
        'site_url',
        'site_keywords',
        'site_description',
        'site_logo',
        'site_favicon',
        'dashboard_logo',
        'facebook',
        'linkedin',
        'instagram',
        'twitter',
        'created_by',
    ];

}
