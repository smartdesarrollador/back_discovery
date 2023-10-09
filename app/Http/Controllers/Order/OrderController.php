<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Mail\CreateOrder;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use MercadoPago\Payment;
use MercadoPago\SDK;

class OrderController extends ApiController
{
   public function index(Request $request)
    {


        if (isset($request['from']) && isset($request['to'])) {
            $orders = Order::all()->sortByDesc('created_at')->toArray();
            $data = [];
            foreach ($orders as $order) {
                if ($order['unix_timestamp'] >= $request['from'] && $order['unix_timestamp'] <= $request['to']) {
                    array_push($data, $order);
                }
            }
            return $this->showArray($data);

        }
        if (isset($request['page'])) {
            $paginated = Order::orderBy('unix_timestamp', 'desc')->Paginate(50)->jsonSerialize();

            return $this->showArray($paginated);
        }

        $orders = Order::all()->sortByDesc('created_at')->toArray();
        return $this->showArray($orders);
    }
    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return JsonResponse
     */
    public function show(Order $order)
    {
        /*return $order->withTrashed()->load('OrderItems.Variation.Product.Category');*/

        return $this->showOne($order->load('OrderItems.Variation.Product'));
    }
    public function createOrder(Request $request)
    {


        SDK::setAccessToken(config('values.mercado_pago_access_token'));

        $arrayData = json_decode($request->getContent(), true);


        /** @var User $authenticatedUser */
        $authenticatedUser = JWTAuth::authenticate($request->bearerToken());


        $payment = new Payment();

        // TODO
        //COBRAR EL COSTO DE ENVIO


        $payment->transaction_amount = ($arrayData['validateShoppingCart']['free_shipping']) ? $arrayData['validateShoppingCart']['total'] : $arrayData['validateShoppingCart']['total'] + $arrayData['personalInfo']['district']['shipping_cost'];


        $payment->token = $arrayData['token'];
        $payment->description = "Compra de Productos Discovery Store";
        $payment->installments = 1;
        $payment->payment_method_id = $arrayData['paymentMethodId'];
        $payment->payer = array(
            "email" => $authenticatedUser->email
        );
        $payment->save();


        if ($payment->status !== "approved") {
            return $this->errorResponse($payment->error->message, 404);
        }


        return DB::transaction(function () use ($arrayData, $authenticatedUser) {


            /** Creating order @var Order $order */
            $unixTimeStamp = time();
            $order = Order::create([
                'user_id' => $authenticatedUser->id,
                'address' => $arrayData['personalInfo']['address'],
                'first_name' => $arrayData['personalInfo']['firstName'],
                'last_name' => $arrayData['personalInfo']['lastName'],
                'dni' => $arrayData['personalInfo']['dni'],
                'district_name' => $arrayData['personalInfo']['district']['name'],
                'district_id' => $arrayData['personalInfo']['district']['id'],
                'phoneNumber' => $arrayData['personalInfo']['phoneNumber'],
                'shipping_cost' => $arrayData['personalInfo']['district']['shipping_cost'],
                'is_free_shipping' => ($arrayData['validateShoppingCart']['free_shipping']) ? 1 : 0,
                'total' => ($arrayData['validateShoppingCart']['free_shipping']) ? $arrayData['validateShoppingCart']['total'] : $arrayData['validateShoppingCart']['total'] + $arrayData['personalInfo']['district']['shipping_cost'],
                'additionalInformation' => $arrayData['personalInfo']['aditionalInformation'],
                'tracking_code' => 'DP' . $unixTimeStamp,
                'unix_timestamp' => $unixTimeStamp
            ]);


            foreach ($arrayData['validateShoppingCart']['valid_items'] as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'variation_id' => $item['variationId'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                DB::update('UPDATE variations SET stock = stock- ? WHERE id= ?', [$item['quantity'], $item['variationId']]);
            }

            Mail::to($authenticatedUser->email)->send(new CreateOrder($arrayData['personalInfo'], $order, $arrayData['validateShoppingCart']['valid_items']));

            return $this->showOne($order, 'Success');


        });


    }

    public function getOrder($trackingId)
    {
        $order = Order::where('tracking_code', '=', $trackingId)->first();
        if (!$order) {
            return $this->errorResponse('Not Found', 404);
        }
        return $this->showOne($order);


        /* $order = DB::select('SELECT * FROM orders WHERE tracking_code = ?', [$trackingId]);

         return $this->showArray($order);*/
    }

    public function demo(Request $request)
    {


        $authenticatedUser = JWTAuth::authenticate($request->bearerToken());



        $newToken  =   JWTAuth::fromUser($authenticatedUser);

        return $newToken;
    }
    public function getPendingOrders()
    {
        $orders = Order::where('status', '=', 'PROCESANDO')->orderBy('unix_timestamp', 'DESC')->get();
        return $this->showAll($orders);
    }
    public function changeOrderStatus(Request $request)
    {
        $requestArray = $request->all();


        $status = '';

        if ($requestArray['status'] == '0') {
            $status = 'PROCESANDO';
        } else if ($requestArray['status'] == '1') {
            $status = 'COMPLETADO';
        } else {
            return $this->errorResponse('Bad Request', 400);
        }

        Order::whereId($requestArray['id'])->update([
            'status' => $status,
        ]);;
        return $this->successMessageResponse('cambiado correctamente');
    }

}
