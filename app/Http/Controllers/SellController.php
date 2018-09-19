<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sell;
use App\Stock;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sells = Sell::with('product')->get();
        
        return view('sell.index', ['sells'=>$sells]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sell.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        
        $validatedData = $request->validate([
            'product_id' => 'required',
            'customer' => 'required|min:3|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'stock' => 'required',
            'total' => 'required'
        ]);
        
        $sell = Sell::create( $request->except(['stock','total', 'product_name']));
        
        $quantity = $request->quantity;
        $product_id = $request->product_id;
        
        $stocks = Stock::where('product_id', $product_id)->get();
        
        foreach($stocks as $s)
        {
            if($s->quantity >= $quantity)
            {
                $s->quantity = $s->quantity - $quantity;
                $s->save();
                break;
            }
            else
            {
                $quantity =  $quantity - $s->quantity;
                $s->quantity = 0;
                $s->save();
            }
        }
        
        return redirect('/sells/create');
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

    public function destroy($id)
    {
        
        $sell = Sell::find($id);
        $sell->delete();
        
        return redirect('/sells');
    }
}
