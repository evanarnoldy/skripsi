<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    //
    protected $table = 'hasil';

    protected $guarded = [];

    protected $fillable = ['student_id', 'skor', 'kesimpulan'];

    public function user()
    {
        return $this ->belongsTo(Student::class);
    }

    public function jawaban()
    {
        return $this->belongsTo(Answer::class);
    }
}
