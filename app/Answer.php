<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    public function user()
    {
        return $this ->belongsTo('App\Student');
    }

    public function pertanyaan()
    {
        return $this->belongsTo('App\Question');
    }
}
