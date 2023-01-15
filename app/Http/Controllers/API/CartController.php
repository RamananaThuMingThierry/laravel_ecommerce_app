<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\carts;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
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
    public function addtocart(Request $request)
    {
        if(auth('sanctum')->check()){

            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $product_quantity = $request->product_quantity;

            $productcheck = Product::where('id', $product_id)->first();
            if($productcheck){
                
                if(carts::where('product_id', $product_id)->where('user_id', $user_id)->exists()){
                    return response()->json([
                        'status' => 409,
                        'message' => $productcheck->name.' Already added to cart'
                    ]);
                }else{

                    $cartitem = new carts;

                    $cartitem->user_id = $user_id;
                    $cartitem->product_id = $product_id;
                    $cartitem->product_quantity = $product_quantity;
                    $cartitem->save();

                    return response()->json([
                        'status' => 201,
                        'message' => 'Added to cart'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Product not found'
                ]);    
            }
        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to Add to Cart'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartitem = carts::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 200,
                'cart' => $cartitem
            ]);
        }else{
            return response()->json([
                'status' => 401,
                'message' => "Login to view Cart Data",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function edit(carts $carts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function updatequantity($cart_id, $scope)
    {
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartitem = carts::where('id', $cart_id)->where('user_id', $user_id)->first();
            if($scope == "in"){
                $cartitem->product_quantity += 1;
            }else if($scope =="desc"){
                $cartitem->product_quantity -= 1;
            }
            $cartitem->update();
            
            return response()->json([
                'status' => 200,
                'message' => 'Quantity update',
            ]);

        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ]);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function destroy($cart_id)
    {
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartitem = carts::where('id', $cart_id)->where('user_id', $user_id)->first();

            if($cartitem){
                $cartitem->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'Cart Item Removed Successfully',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Cart Item not Found',
                ]);
            }
        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ]);
        }
    }
}
