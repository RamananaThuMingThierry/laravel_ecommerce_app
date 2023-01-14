<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $product = Product::all();
        return response()->json([
            'status' => 200,
            'produits' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|max:191',
            'meta_title' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
            'brand' => 'required|max:20',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'quantity' => 'required|max:4',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048|image',
        ]);

        if($validator->fails()){
            
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(), 
            ]);

        }else{
             
            $product = new Product;

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->id_category = $request->id_category;
            $product->description = $request->description;
              
            $product->meta_title = $request->meta_title;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_description = $request->meta_description;
            
            $product->brand = $request->brand;
            $product->selling_price = $request->selling_price;
            $product->original_price = $request->original_price;
            $product->quantity = $request->quantity;
            
            if($request->hasFile("image")){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' .$extension;
                $file->move("uploads/product/", $filename);
                $product->image = 'uploads/product/'.$filename;
            }
            
            $product->featured = $request->featured == true ? "1" : "0";
            $product->popular = $request->popular == true ? "1" : "0";
            $product->status = $request->status == true ? "1" : "0";
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Enregistrement effectuée!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function retreive($id)
    {
        $product = Product::find($id);
        
        if($product){
            return response()->json([
                'status' => 200,
                'product' => $product
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Not found id product'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'id_category' => 'required|max:191',
            'meta_title' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
            'brand' => 'required|max:20',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'quantity' => 'required|max:4'
        ]);

        if($validator->fails()){    
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(), 
            ]);
        }else{
            $product =  Product::find($id);

            if($product){
                $product->name = $request->name;
                $product->slug = $request->slug;
                $product->id_category = $request->id_category;
                $product->description = $request->description;
                  
                $product->meta_title = $request->meta_title;
                $product->meta_keyword = $request->meta_keyword;
                $product->meta_description = $request->meta_description;
                
                $product->brand = $request->brand;
                $product->selling_price = $request->selling_price;
                $product->original_price = $request->original_price;
                $product->quantity = $request->quantity;
                
                if($request->hasFile("image")){
                    $path = $product->image;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' .$extension;
                    $file->move("uploads/product/", $filename);
                    $product->image = 'uploads/product/'.$filename;
                }
                
                $product->featured = $request->featured;
                $product->popular = $request->popular;
                $product->status = $request->status;
                $product->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Modification effectuée!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Product Not Found'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function fetchproduct($slug){

        $category = Category::where('slug', $slug)->where('status', '0')->first();

        if($category){
            
            $products = Product::where('id_category', $category->id)->where('status','0')->get();
        
            if($products){
                return response()->json([
                    'status' => 200,
                    'product_data' => [
                        'products' => $products,
                        'categorys' => $category
                    ]
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'No Product Available'
                ]);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Category Found'
            ]);
        }
    }
}
