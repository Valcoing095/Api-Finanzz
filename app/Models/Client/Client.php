<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
