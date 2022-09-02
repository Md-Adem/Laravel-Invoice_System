<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        $sections = sections::all();
        $products = products::all();

        return view('products.products', compact('sections', 'products'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $input = $request->all();

        // $validatedData = $request->validate([
        //     'product.name' => 'required',
        //     'section_id' => 'required',
        //     'description' => 'required',
        // ], [

        //     'section_name.required' => 'يرجى ادخال اسم لاقسم',
        //     'section_name.unique' => 'اسم القسم مسجل مسبقا',
        //     'description.required' => 'يرجى ادخال الوصف',
        // ]);

        products::create([

            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);

        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products');
    }


    public function show(products $products)
    {
        //
    }


    public function edit(products $products)
    {
        //
    }


    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

        $products = products::find($request->product_id);

        $products->update([

            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,

        ]);
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }


    public function destroy(Request $request)
    {
        $Products = Products::find($request->product_id);
        $Products->delete();
        session()->flash('Delete', 'تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
