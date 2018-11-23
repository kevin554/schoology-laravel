<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }

    public function homeworks() {
        return $this->hasMany(Homework::class);
    }

    public function signedStudents() {
        return $this->hasMany(SignedStudent::class);
    }
}
