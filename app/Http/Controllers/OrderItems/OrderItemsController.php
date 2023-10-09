<?php

namespace App\Http\Controllers\OrderItems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Variation;

class OrderItemsController extends ApiController
{
     public function getOrderItemsByOrderId($orderId)
    {

        $filteredData = [];
        $orderItems = OrderItems::all()->where('order_id', '=', $orderId)->toArray();

        foreach ($orderItems as $item) {


            $item['variation'] = Variation::findOrFail($item['variation_id'])->toArray();


            $item['product'] = Product::withTrashed()->findOrFail($item['variation']['product_id'])->toArray();

            array_push($filteredData, $item);
        }

        return $this->showArray($filteredData);
    }
}
