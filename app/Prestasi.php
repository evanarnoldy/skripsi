<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected  $guarded = ['student_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
