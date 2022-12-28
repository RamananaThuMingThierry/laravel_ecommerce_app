<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }
    
    public function allcategory()
    {
        $category = Category::where('status','0')->get();
        return response()->json([
            'status' => 200,
            'category' => $category
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
            'meta_title' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
            'description' => 'required|max:191',
        ]);

        if($validator->fails()){
            
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(), 
            ]);

        }else{
               $category = new Category;
               
                $category->meta_title = $request->meta_title;
                $category->meta_keyword = $request->meta_keyword;
                $category->meta_description = $request->meta_description;
                $category->slug = $request->slug;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->status = ($request->status === true ? "1" : "0");
                $category->save();
            
            return response()->json([
                'status' => 200,
                'message' => 'Enregistrement effectuée!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    public function nameCategory($id){
        $category = Category::find($id);
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    public function edit($id){
        $category = Category::find($id);

        if($category){
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No category id found'
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    
     public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
        ]);

        if($validator->fails()){
            
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(), 
            ]);

        }else{
            $category = Category::find($id);

            if($category){
                $category->meta_title = $request->meta_title;
                $category->meta_keyword = $request->meta_keyword;
                $category->meta_description = $request->meta_description;
                $category->slug = $request->slug;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->status = $request->status === true ? 1 : 0;
                $category->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Modification effectuée!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No category ID found!'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_category)
    {   
        $category = Category::find($id_category);

        if($category){
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully!',
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Category Id found"
            ]);
        }
    }
}
