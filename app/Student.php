<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    //
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected $fillable = ['nama', 'NISN', 'kelas', 'email', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'password'];

    protected $hidden = [
        'password', 'remember_token',
    ];

}