<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    public function user()
    {
        return $this ->belongsTo(Student::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Question::class);
    }

    protected $guarded = ['student_id'];
}
