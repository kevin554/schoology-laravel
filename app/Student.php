<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    public function presentations() {
        return $this->hasMany(Presentation::class);
    }

    public function signedIn() {
        return $this->hasMany(SignedStudent::class);
    }
}
