<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Store;
use App\Models\Variation;

class CartController extends ApiController
{
    //
    public function validateCart(Request $request)
    {
        $array = json_decode($request->getContent(), true);
        $validated = ['total' => 0, 'free_shipping' => false, 'valid_items' => [], 'invalid_items' => []];
        foreach ($array['cartItems'] as $item) {
            $product = Product::find($item['product_id'])->toArray();
            unset($product['variations']);
            $item['product'] = $product;
            $variation = Variation::find($item['variationId'])->toArray();
            $item['variation'] = $variation;
            /*SI LA CANTIDAD NO ESTA DISPONIBLE, DEVOLVEMOS UN ARREGLO CON ITEMS INVÁLIDOS, PARA QUITARLOS DE EL CARRITO*/
            $item['price'] = $variation['price'];
            if ($variation['stock'] >= $item['quantity']) {
                $validated['total'] += $variation['price'] * $item['quantity'];
                array_push($validated['valid_items'], $item);
            } else {
                array_push($validated['invalid_items'], $item);
            }
        }
        $min_value_free_shipping = Store::all()->first()->min_value_free_shipping;

        if ($validated['total'] >= $min_value_free_shipping) {
            $validated['free_shipping'] = true;
        }

        $validated['total'] = round($validated['total'], 1);
        return $this->showArray($validated);

    }
}
