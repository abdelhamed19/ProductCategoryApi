<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        return response()->json(["message"=>"All products",$category]);
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
        ]);
        Category::create([
            "name"=>$request->name,
            "description"=>$request->description,
            "slug"=>Str::slug($request->name),
            ]
        );

        return response()->json(["message"=>"Category created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Category::find($id);
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
        $category =Category::find($id);
        $category->update($request->all());
        return response()->json(["message"=>"Category updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        $category->delete();
        return response()->json(["message"=>"Category deleted successfully"]);
    }

    public function Search(Request $request)
    {
        return Category::where("name","Like","%".$request->name."%")->get();
    }
    public function getProductsByCategory(int $id)
    {
        $category=Category::find($id);
        return $category->products;
    }
    public function getTrashedCategories()
    {
        return Category::onlyTrashed()->get();
    }
    public function restore(int $id)
    {
        $category=Category::withTrashed()->find($id);
        $category->restore();
        return response()->json(["message"=>"Category restored successfully"]);
    }
}
