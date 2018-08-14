<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use Auth;

class ProductsController extends Controller
{
    public function index()
    {
        //$products = Product::all();
        $products = Product::orderBy('created_at', 'desc')->get();
        
        return $products;
    }
    
    public function show($id)
    {
        $product = Product::find($id);
        
        if(count($product)>0)
        {
            return response()->json($product);
        }
        
        return response()->json(["error"=>"product Not found"], 404);
    }
    
    public function store(Request $request)
    {
        //\Log::info($request->all());
        
        $exploded = explode(',',$request->image);
        
        $decoded = base64_decode($exploded[1]);
        
        if(str_contains($exploded[0], 'jpeg'))
            $ext = 'jpg';
        if(str_contains($exploded[0], 'png'))
            $ext = 'png';
        
        $filename = str_random().'.'.$ext;
        
        $path = public_path().'/uploadimage/'.$filename;
        
        file_put_contents($path, $decoded);
        
        $product = Product::create( $request->except('image') + [
                'user_id'=> Auth::id(), 
                'image'=> $filename
            ]);
        
        return $product;
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        $product->update($request->all());
        
        return response()->json($product);
    }
    
    public function destroy($id)
    {
        try{
            Product::destroy($id);
            
            return response([], 204);
        }catch(\Exception $e){
            return response(["Error to delete product", 500]);
        }
    }
}
