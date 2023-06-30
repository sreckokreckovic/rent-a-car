<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $with=['user','auto'];
    use HasFactory;
    protected $guarded=['id'];
    public function user(){
        return $this->belongsTo(User::class,'customer');
    }
    public function auto(){
        return $this->belongsTo(Car::class,'car');
    }
}
