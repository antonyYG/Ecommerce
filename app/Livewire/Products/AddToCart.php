<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddToCart extends Component
{
    public $product;

    public $qty = 1;
    public $stock;

    public $selectedFeatures = [];

    public $variant;

    public function mount(){
        $this->selectedFeatures =$this->product->variants->first()->features->pluck('id','option_id')->toArray();
    
        $this->getVariant();
        
    }

    public function updatedSelectedFeatures()
    {
        $this->getVariant();
    }

    public function getVariant()
    {
        $this->variant =  $this->product->variants->filter(function($variant){
            return !array_diff($variant->features->pluck('id')->toArray(),$this->selectedFeatures);
        })->first();

        $this->stock = $this->variant->stock;
        $this->qty =1;
    }

    public function add_to_cart()
    {
        Cart::instance('shopping');

        // Buscar si ya existe un producto con el mismo SKU
        $cartItem = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->options->sku === $this->variant->sku;
        })->first();

        // Cantidad que ya hay en carrito (si no existe, será 0)
        $qtyInCart = $cartItem ? $cartItem->qty : 0;

        // Stock disponible real
        $stockDisponible = $this->variant->stock - $qtyInCart;

        // Validar stock
        if ($stockDisponible < $this->qty) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Stock insuficiente',
                'text' => 'No hay suficiente stock para la cantidad seleccionada'
            ]);
            return;
        }

        // Agregar al carrito
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'image' => $this->variant->image,
                'sku' => $this->variant->sku,
                'stock' => $this->variant->stock,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                                    ->pluck('description', 'id')
                                    ->toArray()
            ],
            'tax' => 18
        ]);

        if (auth()->check()) {
            Cart::store(auth()->id());
        }

        $this->dispatch('cartUpdated', Cart::count());

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho',
            'text' => 'El producto se añadió al carrito de compras'
        ]);
    }

    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
