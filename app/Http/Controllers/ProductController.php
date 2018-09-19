<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Product;
use App\Stock;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        //$products = Product::all();
        $products = Product::orderBy('created_at', 'desc')->get();
        
        return view('product.index', ['products' => $products]);
    }
    
    public function show($id)
    {
        $product = Product::with('stocks')->find($id);
        //return $product;
        
        if(count($product)>0)
        {
            return view('product.show',['product'=>$product]);
        }
        
        return response()->json(["error"=>"product Not found"], 404);
    }
    
    public function create()
    {
        return view('product.create');
    }
    
    public function store(Request $request)
    {
        //\Log::info($request->all());
        
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255|unique:products',
            'model' => 'required|min:2',
        ]);
        
        $product = Product::create( $request->all());
        
        return redirect('/products');
    }
    
    public function edit($id)
    {
        $product = Product::find($id);
        
        return view('product.edit', ['product'=>$product]);
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => "required|min:3|max:255|unique:products,name,$id",
            'model' => 'required|min:2',
        ]);
        
        $product = Product::find($id);
        
        $product->update($request->all());
        
        return redirect('/products');
    }
    
    public function destroy($id)
    {
        try{
            Product::destroy($id);
            
            return redirect('/products');
        }catch(\Exception $e){
            return response(["Error to delete product", 500]);
        }
    }
    
    public function search(Request $request)
    {
        $search = $request->productName;
        
        $query = Product::where('name', 'LIKE', '%'.$search.'%')->get(); 
        
        // The array we're going to return
        $data = [];
        
        // Let's Map the results from [$query]
        $porducts = $query->map(function($item){
            
            $data['id'] = $item->id;
            $data['label'] = $item->name;
            $data['model'] = $item->model;
            return $data;
          
        });
        
        return $porducts;
    }
    
    public function stockAndPrice(Request $request)
    {
        $id = $request->id;
        
        $stock = DB::select("SELECT sum(quantity) as quantity, sum(price * quantity) / sum(quantity) as average
                            FROM  `stocks` 
                            WHERE product_id =?",[$id]);
        
        return $stock;
        
    }
}
