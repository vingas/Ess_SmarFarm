<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'humidade', 'percipitacao', 'id_rasp', 'updated_at'
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
