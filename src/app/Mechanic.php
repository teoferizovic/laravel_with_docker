<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Car;

class Mechanic extends Model
{
    protected $hidden = ['created_at','updated_at'];
    /**
     * Get the car's owner.
    */
    public function carOwner()
    {
        return $this->hasOneThrough('App\Owner', 'App\Car');
    }

    public function car() {
    	 return $this->hasOne(Car::class);
    }
}
