<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = ['pertanyaan', 'jenis', 'kategori'];

    public function answers()
    {
        return $this->belongsTo(Answer::class);
    }
}
