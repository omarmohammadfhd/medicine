<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function Product_details($id)
    {
        $medication = Product::find($id);

        if (!$medication) {
            return response()->json(['message' => 'Medication not found'], 404);
        }

        return response()->json($medication);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'scientific_name' => 'required|max:255',
            'Trade_name' => 'required | max:255',
            'category_id' => 'required|exists:categories,id',
            'Company_name' => 'required|max:255',
            'Quantity_products' => 'required|integer',
            'Expiation_date' => 'required|date',
            'Price' => 'required',
            'Image' => ['Image', 'mimes:jpeg,png,bmp,jpg,gif,svg']
        ]);
        $image = $request->file('Image');
        $products_image = null;
        if ($request->hasFile('Image')) {
            $products_image = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Image'), $products_image);
            $products_image = 'image/' . $products_image;
        }

        $products_store = Product::query()->create($validatedData);
        if (!$products_store) {
            return response()->json([
                'success' => false,
                'massage' => 'not added successfully'
            ]);

        } else {
            return response()->json([
                'massage' => ' product added successfully'
            ]);
        };

    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $query->whereHas('Category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->has('name')) {
            $query->where('scientific_name', 'like', '%' . $request->name . '%')
                ->orWhere('Trade_name', 'like', '%' . $request->name . '%');
        }

        $medications = $query->get();

        return response()->json($medications);
    }


    public function show(Request $request)
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('scientific_name', 'like', '%' . $request->name . '%')
                ->orWhere('Trade_name', 'like', '%' . $request->name . '%');
        }
        $medications = $query->get();
//            $medication = Product::find($request);
//
//            if (!$medication) {
//                return response()->json(['message' => 'Medication not found'], 404);
//            }

        return response()->json($medications);
    }

    public function get_all_product()
{
    $data=  Product::all();
    return response()->json([
        "status"=>true,
        "msg"=>"Don",
        "date"=>$data
    ],200);
}



}
