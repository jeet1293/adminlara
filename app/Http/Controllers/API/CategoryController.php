<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Model\Category;
use Illuminate\Http\Request;
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
        $categories = Category::latest()->get();

        $response = [
            'success' => true,
            'data'    => CategoryResource::collection($categories),
            'message' => 'Categories fetched successfully.',
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
   
        $category = Category::create($input);

        $response = [
            'success' => true,
            'data'    => new CategoryResource($category),
            'message' => 'Category added successfully.',
        ];

        return response()->json($response, 200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        
        if (is_null($category)) {
            return response()->json(['error'=>'Category not found!'], 404);
        }
        
        $response = [
            'success' => true,
            'data'    => new CategoryResource($category),
            'message' => 'Category added successfully.',
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
   
        $category->name = $input['name'];
        $category->detail = $input['detail'];
        $category->save();

        $response = [
            'success' => true,
            'data'    => new CategoryResource($category),
            'message' => 'Category added successfully.',
        ];

        return response()->json($response, 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
         
        if (is_null($category)) {
            return response()->json(['error'=>'Category not found!'], 404);
        }
        
        $category->delete();
        
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Category deleted successfully.',
        ];

        return response()->json($response, 200);
    }
}
