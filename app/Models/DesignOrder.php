<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DesignOrder extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function designs()
    {
        return $this->hasMany('\App\Models\Design');
    }
    public function order()
    {
        return $this->belongsTo('\App\Models\Order');
    }
}
