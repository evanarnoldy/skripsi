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

    protected $fillable = ['nama', 'NISN', 'kelas', 'email', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'avatar', 'kelas', 'unit', 'password'];

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }

}
