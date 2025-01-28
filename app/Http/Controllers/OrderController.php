<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Order_product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class OrderController extends Controller
{

    public function Order(Request $request)
    {
        $val_data = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*.product_id' => 'required|integer|exists:products,id',
            'data.*.ammount' => 'required|integer|min:1'
        ]);

        if ($val_data->fails()) {
            return response()->json(['message' => $val_data->errors()], 400);
        }

        $order = Order::create([
            'user_id'=> auth()->id(),
            'total_price'=>0,
            'Order_status'=>0,
            'Payment_status'=>0,
        ]);

        $totalprice = 0;
        foreach ($request->data as $value)
        {
            $productprice = 0;
            $products = Product::find($value['product_id']);
            if ($products->Quantity_products >= $value['ammount']) {
                $orderUser = Order_product::create([
                    'order_id' => $order->id,
                    'product_id' => $value['product_id'],
                    'Quantity_order' => $value['ammount'],
                ]);
                $productprice = $products->price * $value['ammount'];
                $totalprice += $productprice;
            }
            else{
                return response()->json(['message' => 'we dont have enough quntity']);
            }
        }

        $order->total_price = $totalprice;
        $order->save();
        return response()->json(['message' => 'Done'], 200);

    }
    public function get_all_Order()
    {

        $data=  Order::all();
        return response()->json([

            "status"=>true,
            "msg"=>"Don",
            "date"=>$data
        ],200);
    }
    public function get_Order()
    {

        $userId = auth()->id();
        $orders = Order::where('user_id', $userId)->get();
        return response()->json([
            //   'user_id'=> auth()->id(),
            "status"=>true,
            "msg"=>"Don",
            "date"=>$orders
        ],200);
    }


//
//        $order= Order::create(
//            [
//                'user_id'=>1,
//                'total_price'=>0,
//                'Order_status'=>0,
//                'Payment_status'=>0,
//            ]
//        );
//     foreach ($request->data as $value)
//     {
//
//         $totoal=0;
//         foreach ($request->data as $value)
//         {
//
//             $totoal=0;
//             $value->validate([
//                 'product_id' => 'required|integer|exists:product,id ',
//                 'ammount' => 'required|integer|min:1'
//             ]);
//         $orderUser= Order_product::create(
//             [
//                 'order_id'=>$order->id,
//                 'product_id'=>$value['product_id'],
//                 'Quantity_order'=>$value['ammount'],
//             ]
//         );
//
//         $order->total_price+=$totoal;
//         $order->save();
//
//     }
//        return response()->json(['message' => 'Done'], 200);

        //  return $request ;
//        $totalPrice = 0;
//        DB::beginTransaction();
//        try {
//            foreach ($validated['products'] as $medicationData) {
//                $medication = Product::findOrFail($medicationData['id']);
//
//                if ($medication->Quantity_products < $medicationData['quantity']) {
//                    throw new \Exception("Insufficient quantity for " . $medication->Trade_name);
//                }
//                $totalPrice += $medication->price * $medicationData['quantity'];
//            }
//            $order = Order::create([
//                'user_id' => auth()->id(),
//                'Order_status' => 1,
//                'total_price' => $totalPrice
//            ]);
//            foreach ($validated['products'] as $medicationData) {
//                Order_product::create([
//                    'order_id' => $order->id,
//                    'product_id' => $medicationData['id'],
//                    'Quantity_order' => $medicationData['quantity'],
//                    //   'price_per_item' => Medication::find($medicationData['id'])->price
//                ]);
//            }
//
//        } catch (\Exception $e) {
       // نخابرك نخابرك فيما بعد
//DB::rollback();
//return response()->json(['message' => 'Error creating order: ' . $e->getMessage()], 400);



}
