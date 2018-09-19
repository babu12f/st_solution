<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Stock;
use App\Product;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::with('product')->get();
        
        return view('purchase.index', ['purchases'=>$purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'supplier' => 'required|min:3|max:255|',
            'costing' => 'required|numeric',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_id' => 'required|numeric'
        ]);
        
        $purchase = Purchase::create( $request->except('product_name'));
        
        $product_id = $request->product_id;
        $price = $request->price;
        $quantity = $request->quantity;
        
        $stock = Stock::where('product_id', $product_id)
                        ->where('price', $price)
                        ->first();
        
        if($stock)
        {
            // Already in stock same price and product
            // Update quantiy
            $stock->quantity = $stock->quantity + $quantity;
            $stock->save();
        }
        else
        {
            // Check product_id present in stock 
            $lot = Stock::where('product_id', $product_id)->max('lot_no');
            
            if(!$lot)
            {
                // Add new lot in stock
                Stock::create([
                        'lot_no' => 1,
                        'product_id' => $product_id,
                        'price' => $price,
                        'quantity' => $quantity
                    ]);
            }
            else
            {
                // Increase lot_not by one and create stock
                Stock::create([
                        'lot_no' => ++$lot,
                        'product_id' => $product_id,
                        'price' => $price,
                        'quantity' => $quantity
                    ]);
            }
        }
        
        return redirect('/purchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete / decrease all stock form stock
        $purchase = Purchase::find($id);
        
        $product_id = $purchase->product_id;
        $price = $purchase->price;
        $quantity = $purchase->quantity;
        
        $stock = Stock::where('product_id', $product_id)
                        ->where('price', $price)->first();
        
        // Decrease stock quentity form purchase
        $stock->quantity = $stock->quantity - $quantity;
        $stock->save();
        
        try{
            $purchase->delete();
            
            return redirect('/purchase');
        }catch(\Exception $e){
            return response(["Error to delete product", 500]);
        }
    }
}
