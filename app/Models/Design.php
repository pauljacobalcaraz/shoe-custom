<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    public function part()
    {
        return $this->belongsTo('\App\Models\Part');
    }
    public function shoe()
    {
        return $this->belongsTo('\App\Models\Shoe');
    }
    public function design_order()
    {
        return $this->belongsTo('\App\Model\DesignOrder');
    }
}
