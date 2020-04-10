<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->category) {
            $products = Product::whereJsonContains('category_id', $request->category)->latest()->get();
        } else {
            $products = Product::latest()->get();
        }

        $response = [
            'success' => true,
            'data'    => ProductResource::collection($products),
            'message' => 'Products fetched successfully.',
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
   
        $product = Product::create($input);

        $response = [
            'success' => true,
            'data'    => new ProductResource($product),
            'message' => 'Product added successfully.',
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
        $product = Product::find($id);
        
        if (is_null($product)) {
            return response()->json(['error'=>'Product not found!'], 404);
        }
        
        $response = [
            'success' => true,
            'data'    => new ProductResource($product),
            'message' => 'Product added successfully.',
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
   
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();

        $response = [
            'success' => true,
            'data'    => new ProductResource($product),
            'message' => 'Product added successfully.',
        ];

        return response()->json($response, 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
         
        if (is_null($product)) {
            return response()->json(['error'=>'Product not found!'], 404);
        }
        
        $product->delete();
        
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Product deleted successfully.',
        ];

        return response()->json($response, 200);
    }
}
