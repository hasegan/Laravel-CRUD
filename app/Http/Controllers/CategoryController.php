<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::latest()->paginate(5);

        return view('category.index', compact('category'))->with(
            request()->input('page')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the input
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        //create a new Category in the DB
        Category::create($request->all());
        //redirect the user and send friendly message
        return redirect()
            ->route('category.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        //update the  Product in the DB
        // $product->update($request->all());
        $data = $request->all();
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->save();
        //redirect the user and send friendly message
        return redirect()
            ->route('category.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {   // stop deletion if there are products with this category
        $productWithThisCategory = Product::where('category_id', $category->id);
        if ($productWithThisCategory->exists()) {
            return redirect()
                ->route('category.index')
                ->with(
                    'danger',
                    'Category cannot be deleted (there are products directly related to the category ' .
                        $category->name .
                        ')'
                );
        } else {
            //delete the product
            $category->delete();
            //redirect user + display success message
            return redirect()
                ->route('category.index')
                ->with('success', 'Category deleted successfully');
        }
    }
}
