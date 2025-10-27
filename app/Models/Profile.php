<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable=[

        'phone',
        'address',
        'date_of_birth',
        'bio',
        'user_id',
        'image',
    ];

    function user(){
        return $this->belongsTo(User::class);
    }
}


