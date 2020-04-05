<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Korelasi extends Model
{
    protected $table = 'korelasi';

    public function siswa()
    {
        return $this->belongsTo(Student::class);
    }

}
