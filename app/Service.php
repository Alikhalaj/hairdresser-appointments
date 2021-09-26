<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded=[];


    public function patch(){
        return "/service/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
