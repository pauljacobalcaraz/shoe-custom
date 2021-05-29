<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shoe extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function brand()
    {
        return  $this->belongsTo('\App\Models\Brand');
    }

    public function designs()
    {
        return $this->hasMany('\App\Models\Design');
    }
    public function orders()
    {
        return $this->hasMany('\App\Models\Order');
    }
}


/* 
shoe has many parts
each part has many designs

shoes
parts
designs


*/