<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index', [
            'products' => Product::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules=array(
            'title' => 'required',
            'description' => 'required',
            'files.*' => 'nullable|mimes:jpeg,png,jpg,gif|max:10240'
        );

        $validator=Validator::make($request->all(),$rules);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('storage'),$imageName);

        $product = new Product;
        $product->image = $imageName;
        $product->title = $request->title;
        $product->description = $request->description;

        $product->save();

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => 'Validation error occurs',
                'errors' => $validator->errors()
            ]);
        }else{
            return response()->json([
                'message' => 'product Created !!!'
            ]);
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = product::where('id', $id)->first();
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id', $id)->first();
        return view('products.edit', ['product' => $product]);
    }
            
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10240'
        ]);

        $product = Product::where('id', $id)->first();

        if (isset($request->image)) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage'), $imageName);
            $product->image = $imageName;
        }

        $product->title = $request->title;
        $product->description = $request->description;

        $product->save();

        return response()->json([
            'message' => 'product Updated !!!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = product::where('id', $id)->first();
        $product->delete();
        return back()->withSuccess('product Deleted !!!');
    }
}
