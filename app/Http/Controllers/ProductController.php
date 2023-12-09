<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product=Product::all();
        return response()->json(["message"=>"All products",$product]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>["required"],
            "description"=>["required"],
            "price"=>["required"],
            "category_id"=>["required","integer"],
        ]);
        Product::create([
            "name"=>$request->name,
            "description"=>$request->description,
            "price"=>$request->price,
            "slug"=>Str::slug($request->name),
            "category_id"=>$request->category_id
            ]
        );
        return response()->json(["message"=>"Product created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produsct=Product::find($id);
        $produsct->update($request->all());
        return response()->json(["message"=>"Product updated successfully"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::find($id);
        $product->delete();
        return response()->json(["message"=>"Product deleted successfully"]);
    }

     /**
     * Remove the specified resource from storage.
     */
    public function Search(Request $request)
    {
        return Product::where("name","Like","%".$request->name."%")->get();
    }
    public function getCategoryByProducts(int $id)
    {
        $product=Product::find($id);
        return $product->category;
    }
    public function getTrashedProducts()
    {
        return Product::onlyTrashed()->get();
    }
    public function restore(int $id)
    {
        $product=Product::withTrashed()->find($id);
        $product->restore();
        return response()->json(["message"=>"Product restored successfully"]);
    }
}
