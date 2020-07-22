<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected $fillable = ['nama', 'NIP', 'email', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'avatar', 'password'];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
