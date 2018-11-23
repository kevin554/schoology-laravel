<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function homework() {
        return $this->belongsTo(Homework::class);
    }
}
