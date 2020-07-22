<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class WaliKelas extends Authenticatable
{
    use Notifiable;

    protected $table = 'wali_kelas';

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected $fillable = ['nama', 'NIP', 'email', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'avatar', 'kelas_diampu', 'unit', 'password'];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
