<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function threads()
    {
        $this->hasMany(Thread::class);
    }
}
