<?php

namespace App\Http\Controllers\API;

use App\Models\carts;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function commandes(Request $request){

        if(auth('sanctum')->check()){

            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:191',
                'lastname' => 'required|max:191',
                'phone' => 'required|max:191',
                'email' => 'required|max:191',
                'address' => 'required|max:191',
                'city' => 'required|max:191',
                'address' => 'required|max:191',
                'zipcode' => 'required|max:191',
                'state' => 'required|max:191',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ]);
            }else{

                $user_id = auth('sanctum')->user()->id;
                
                $order = new Order;
                
                $order->user_id = $user_id;
                $order->firstname = $request->firstname;
                $order->lastname = $request->lastname;
                $order->phone = $request->phone;
                $order->email = $request->email;
                $order->address = $request->address;
                $order->city = $request->city;
                $order->zipcode = $request->zipcode;
                $order->state = $request->state;
                $order->payment_mode = "COD";
                $order->tracking_no = "fundaecom".rand(1111,9999);
                $order->save();

                $carts = carts::where('user_id', $user_id)->get();
                
                $orderitems = [];                
                foreach($carts as $item){
                    
                    $orderitems[] = [
                        'product_id' => $item->product_id,
                        'quantity' => $item->product_quantity,
                        'price' => $item->product->selling_price,
                    ];

                    $item->product->update([
                        'quantity' => $item->product->quantity - $item->product_quantity
                    ]);
                    
                }


                $order->orderitems()->createMany($orderitems);
                carts::destroy($carts);
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Order placed successfully'
                ]);
            }

        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
