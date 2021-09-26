<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments(){
        return $this->hasMany(Appointment::class,'barber_id');
    }
}
