<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Traits\MyFunctions;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReportingController extends ApiController
{
    use MyFunctions;

    public function bestSelledCategories()
    {
        $data = Category::selectRaw('categories.image, SUM(order_items.quantity) as total_sales')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('variations', 'products.id', '=', 'variations.product_id')
            ->join('order_items', 'variations.id', '=', 'order_items.variation_id')
            ->groupBy('categories.id')
            ->orderBy('total_sales', 'desc')
            ->get();

        return $this->showAll($data);

    }

    public function bestSelledProductsLimit10()
    {
        $products = Product::selectRaw('*, SUM(order_items.quantity) as total_sales')
            ->join('variations', 'products.id', '=', 'variations.product_id')
            ->join('order_items', 'variations.id', '=', 'order_items.variation_id')
            ->groupBy('products.id')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();


        $arrayProducts = [];
        foreach ($products as $product) {
            if (count($product->variations) > 0) {
                if ($product->stock != 0) {
                    array_push($arrayProducts, $product);
                }
            }
        }


        return $this->showArray($arrayProducts);
    }

    public function totalOrdersByMonth()
    {


        $data1 = Order::select(DB::raw('SUM(total) as montoVentas'), DB::raw('MONTH(created_at) as mes'))
            ->groupBy(DB::raw('MONTH(created_at)'))->get()->toArray();

        $response = [];

        foreach ($data1 as $item) {

            $item['mes'] = $this->monthNumberToString($item['mes']);

            array_push($response, $item);
        }

        return $this->showArray($response);


        /* $data = DB::select('SELECT SUM(total) as montoVentas,MONTH(created_at) as mes
                                     FROM orders GROUP BY MONTH(created_at) ORDER BY created_at ASC LIMIT 12');


         $response = [];

         foreach ($data as $item) {

             $item->mes = $this->monthNumberToString($item->mes);

             array_push($response, $item);
         }

         return $this->showArray($response);*/
    }

    /**
     * Devuelve estadisticas de la tienda
     * @return JsonResponse
     */
    public function sumStats()
    {
        $sumAlOrdersAmount = DB::select('SELECT SUM(total) as montoVentas FROM orders');

        $countProducts = Product::all()->count();
        $countOrders = Order::all()->count();
        $countUser = User::all()->count();
        $totalVentas = $sumAlOrdersAmount[0]->montoVentas;


        $data = [
            'sumAmounOrders' => $totalVentas * 1,
            'countProducts' => $countProducts,
            'countUsers' => $countUser,
            'countOrders' => $countOrders,
        ];


        return $this->showArray($data);


    }

    /**
     * Total de ventas por usuario(mejores usuarios)
     * @param Request $request
     * @return JsonResponse
     */
    public function bestSalesAmoutClient(Request $request)
    {

        if ($request->limit) {
            $data = User::select('users.id as user_codigo', 'orders.id as order_codigo', 'users.*', 'orders.*')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->orderByDesc('orders.total')
                ->limit($request->limit)
                ->get();
            return $this->showAll($data);
        } else {
            $data = User::select('users.*', 'orders.total')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->orderByDesc('orders.total')
                ->get();
            return $this->showAll($data);
        }
    }
}
