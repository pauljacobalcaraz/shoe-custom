<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo('\App\Models\Status');
    }
    public function shoe()
    {
        return $this->belongsTo('\App\Models\Shoe');
    }
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
    public function design_order()
    {
        return $this->hasMany('\App\Models\DesignOrder');
    }
}
