<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rpi3 extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac_addr', 'threshold', 'user_id', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'created_at',
    ];
}
