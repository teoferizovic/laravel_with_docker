<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Owner;

class Car extends Model
{
    protected $hidden = ['created_at','updated_at'];
    
    public function owner() {
    	 return $this->hasOne(Owner::class);
    }
}
