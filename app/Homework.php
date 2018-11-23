<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function presentations() {
        return $this->hasMany(Presentation::class);
    }
}
