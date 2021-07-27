<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $table = 'usrr_info';
    protected $fillable = [
        'date',
        'ip_add',
        'country',
        'city',
        'state',
        'postal_code',
        'lat',
        'longi',
        'time_zone',
        'pltform',
        'pltform_version',
        'browser',
        'browser_version',
        'devices',
        'desktop',
        'phone',
    ];
}
