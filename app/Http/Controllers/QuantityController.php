<?php

namespace App\Http\Controllers;

use App\Models\Quantity;
use App\Models\Product;
use Illuminate\Http\Request;

class QuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quantities = Quantity::with('product')
            ->latest()
            ->paginate(5);
        //$categories = Category::all();
        //dd($products);

        return view('quantity.index', compact('quantities'))->with(
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
        // $quantities = Quantity::all();
        $products = Product::all();
        return view('quantity.create', compact('products'))->with(
            request()->input('page')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quantity $quantity)
    {
        $request->validate([
            'select_product' => 'required',
            'quantity' => 'required',
        ]);
        //create a new Quantity item in the DB
        $data = $request->all();
        $quantity->product_id = $data['select_product'];
        $quantity->quantity = $data['quantity'];
        $quantity->save();

        //redirect the user and send friendly message
        return redirect()
            ->route('quantity.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quantity  $quantity
     * @return \Illuminate\Http\Response
     */
    public function show(Quantity $quantity)
    {
        return view('quantity.show', compact('quantity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quantity  $quantity
     * @return \Illuminate\Http\Response
     */
    public function edit(Quantity $quantity)
    {
        $allProducts = Product::all();
        return view('quantity.edit', compact('quantity', 'allProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quantity  $quantity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quantity $quantity)
    {
        $request->validate([
            'select_product' => 'required',
            'quantity' => 'required',
        ]);

        $data = $request->all();
        $quantity->product_id = $data['select_product'];
        $quantity->quantity = $data['quantity'];
        $quantity->save();
        //redirect the user and send friendly message
        return redirect()
            ->route('quantity.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quantity  $quantity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quantity $quantity)
    {
        $quantity->delete();
        //redirect user + display success message
        return redirect()
            ->route('quantity.index')
            ->with('success', 'Product deleted successfully');
    }
}
