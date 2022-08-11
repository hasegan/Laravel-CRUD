<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Quantity;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->with('quantity')
            ->latest()
            ->paginate(5);
        $quantities = Quantity::all();
        return view('products.index', compact('products'))->with(
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
        $categories = Category::all();
        return view('products.create', compact('categories'))->with(
            request()->input('page')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        Quantity $quantity
    ) {
        // validate the input
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'select_category' => 'required',
            'quantity' => 'required',
        ]);
        //create a new Product in the DB
        $data = $request->all();
        $product->name = $data['name'];
        $product->details = $data['details'];
        $product->category_id = $data['select_category'];
        $product->save();
        $quantity->product_id = $product->id;
        $quantity->quantity = $data['quantity'];
        $quantity->save();
        //redirect the user and send friendly message
        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $quantity = Quantity::where('product_id', $product->id)->first();
        return view('products.show', compact('product', 'quantity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $allCategories = Category::all();
        $quantity = Quantity::where('product_id', $product->id)->first();
        return view(
            'products.edit',
            compact('product', 'allCategories', 'quantity')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'quantity' => 'required',
        ]);

        $data = $request->all();
        $product->name = $data['name'];
        $product->details = $data['details'];
        $product->category_id = $data['select_category'];
        $product->save();
        //$quantity = Quantity::where('product_id',$product->id);
        $product->quantity->quantity = $data['quantity'];
        $product->quantity->save();
        //redirect the user and send friendly message
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //delete the product
        $product->delete();

        // /delete quantity for the product being deleted
        $quantityToDelete = Quantity::where('product_id', $product->id);
        if ($quantityToDelete) {
            $quantityToDelete->delete();
        }
        //redirect user + display success message
        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
