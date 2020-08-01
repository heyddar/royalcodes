<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];
    public function channel()
    {
        $this->belongsTo(Channel::class);
    }
    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function answers()
    {
        $this->hasMany(Answer::class);
    }
}
