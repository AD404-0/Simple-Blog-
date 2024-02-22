<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    public function index()
    {
           $producrsFromDB = Product::all();
            return view('products.index', ['products' => $producrsFromDB]);
    }

    public function create()
    {
        return view('products.careate');
    }

    
        public function store(Request $request)
        {
            $product = new Product();
            $product->title = $request->input('title');
            $product->email = $request->input('email');
            $product->categoryId = $request->input('category_id');
        
            // Handle the image upload
            if($request->hasFile('photo')) {
                $image = $request->file('photo');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/products');
                $image->move($destinationPath, $name);
                $product->profile_image = $name;
            }
        
            $product->save();
            return redirect()->route('products.index');
        }

        public function edit($id)
        {

            $product = Product::find($id);
            return view('products.update', ['product' => $product]);
            
        }


        public function update(Request $request, $id)
        {
            $product = Product::find($id);
            $product->title = $request->input('title');
            $product->email = $request->input('email');
            $product->categoryId = $request->input('category_id');
        
            // Handle the image upload
            if($request->hasFile('photo')) {
                $image = $request->file('photo');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/products');
                $image->move($destinationPath, $name);
                $product->profile_image = $name;
            }
        
            $product->save();

            return redirect()->route('products.index');
           


        }

        public function destroy($id){
            $product = Product::find($id);
            $product->delete();
            return redirect()->route('products.index');
        }

}

      


       

       







