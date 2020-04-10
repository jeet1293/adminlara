<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Product;
use App\Model\ProductImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Nullable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $categories = Product::latest()->get();
            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('status', function($product) {
                            if($product->status == false) {
                                $btn = '<span class="badge bg-danger">InActive</span>';
                            } else {
                                $btn = '<span class="badge bg-success">Active</span>';
                            }    
                            return $btn;
                    })
                    ->addColumn('action', function($product) {
                        return "<a href=".route('products.edit', $product->id)."><i class='nav-icon fas fa-edit'></i></a>&nbsp;&nbsp;<a href=".route('products.image.create', $product->id)."><i class='nav-icon fas fa-image'></i></a>&nbsp;&nbsp;<i class='nav-icon fas fa-trash text-danger btn-delete' data-url=".route('products.destroy', [$product->id])."></i>";
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', '1')->pluck('title', 'id')->all();
        $product = array();
        return view('products.create', compact('categories', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'category_id' => 'required',
            'title' => 'required|unique:products|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable',
        ]);
        $inputs['slug'] = str_slug($inputs['title'], '-');

        if($request->hasfile('image')) 
        { 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('uploads/products/', $filename);
            $inputs['image'] = $filename;
        }
        Product::create($inputs);

        return redirect()->route('products.index')->with('success', 'Product Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return redirect()->route('products.edit', [$product->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', '1')->pluck('title', 'id')->all();
        return view('products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $inputs = $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255|unique:products,title,'.$product->id,
            'status' => 'required|boolean',
            'description' => 'nullable',
        ]);
        $inputs['slug'] = str_slug($inputs['title'], '-');
        
        if($request->hasfile('image')) 
        { 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('uploads/products/', $filename);
            $inputs['image'] = $filename;

            $image_path = 'uploads/products/'.$product->image; 
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        $product->update($inputs);

        return redirect()->route('products.index')->with('success', 'Product updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $image_path = 'uploads/products/'.$product->image; 
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $folderPath = public_path('uploads/gallery/'.$product->id);
        File::deleteDirectory($folderPath);
        
        $product->delete();

        return response('success');
    }

    public function productImage(Request $request, Product $product)
    {
        $images = ProductImage::where('product_id', $product->id)->get();
        return view('products.image', compact('images', 'product'));
    }

    public function uploadProductImage(Request $request, Product $product)
    {
        if($request->hasfile('file')) 
        { 
            $file = $request->file('file');
            $fileSize = $file->getSize();
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('uploads/gallery/'.$product->id.'/', $filename);
            $inputs['image'] = asset('uploads/gallery/').'/'.$product->id.'/'.$filename;
            $inputs['name'] = $filename;
            $inputs['product_id'] = $product->id;
            $inputs['size'] = $fileSize;


            ProductImage::create($inputs);
        }
        return response()->json(['success'=>$filename]);
    }
}
