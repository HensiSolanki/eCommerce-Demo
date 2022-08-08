<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = \App\Models\Category::all();
        // $products = \App\Models\Category::select(
        //     'id',
        //     'category_name',
        //     'category_slug',
        //     DB::raw("image AS image_thumb_url")
        // );
        return view('front.category', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::select(
            'products.id',
            'products.image',
            'products.price',
            'products.product_name',
            'products.category_id',
            'products.description',
            DB::raw("products.image AS image_thumb_url")
        )->join('categories', 'categories.id', '=', 'products.category_id')->where('products.category_id', $id)->get();

        return view('front/products', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        //
    }
}