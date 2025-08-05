<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
    public function variants(){
        return $this->hasMany(Variant::class);
    }
    public function options(){
        return $this->belongsToMany(Option::class)
        ->using(OptionProduct::class)
        ->withPivot('features')
        ->withTimestamps();
    } 

    protected $fillable = [
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'stock',
        'subcategory_id'
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->image_path),
        );
    }
}
