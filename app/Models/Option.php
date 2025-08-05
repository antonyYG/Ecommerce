<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    public function products(){
        return $this->belongsToMany(Product::class)
        ->using(OptionProduct::class)
        ->withPivot('features')
        ->withTimestamps();
    }
    public function features(){
        return $this->hasMany(Feature::class);
    }
    protected $fillable = [
        'name',
        'type'
    ];
}
