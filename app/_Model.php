<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Model extends Model
{
    protected $fillable = [
        'name', 'brand_id', 'description', 'img'
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
