<?php

namespace App\Observers;

use App\Models\Variant;

use illuminate\Support\Str;

class VariantObserver
{
    public function created(Variant $variant)
    {

        if ($variant->product->options->count() == 0) {
            
            $variant->sku = $variant->product->sku;
            $variant->stock =10;
            $variant->save();
            return;
        }

        //Generar un sku numerico de 12 digitos
        $variant->sku = Str::random(12);
        $variant->save();

    }
}
