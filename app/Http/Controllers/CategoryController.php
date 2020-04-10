<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }

    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::latest()->get();
            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('status', function($category) {
                            if($category->status == false) {
                                $btn = '<span class="badge bg-danger">InActive</span>';
                            } else {
                                $btn = '<span class="badge bg-success">Active</span>';
                            }    
                            return $btn;
                    })
                    ->addColumn('action', function($category) {
                        return "<a href=".route('categories.edit', $category->id)."><i class='nav-icon fas fa-edit'></i></a>&nbsp;&nbsp;<i class='nav-icon fas fa-trash text-danger btn-delete' data-url=".route('categories.destroy', [$category->id])."></i>";
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
        $category = array();
        return view('categories.create', compact('category'));
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
            'title' => 'required|unique:categories|max:255',
            'status' => 'required|boolean',
        ]);
        $inputs['slug'] = str_slug($inputs['title'], '-');
        
        Category::create($inputs);

        return redirect()->route('categories.index')->with('success', 'Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return redirect()->route('categories.edit', [$category->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $inputs = $request->validate([
            'title' => 'required|max:255|unique:categories,title,'.$category->id,
            'status' => 'required|boolean',
        ]);
        $inputs['slug'] = str_slug($inputs['title'], '-');
        
        $category->update($inputs);

        return redirect()->route('categories.index')->with('success', 'Category updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response('success');
    }
}
