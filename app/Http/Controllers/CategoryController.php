<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function All_product($id){

        $get =Category::find($id);
        return response()->json([
            $get->product
        ]) ;
//        $query = Product::query();
//
//        if ($request->has('category')) {
//            $query->whereHas('Category', function ($q) use ($request) {
//                $q->where('name', $request->category);
//            });
//        }
//        $medications = $query->select('Trade_name','Image')->get();
//        return response()->json($medications);

//
//        $id = $request->validate([
//            'category_id'=>'required'
//        ]);
       // $id = $request->category_id ;

    }
    public function createCategory(Request $request){

        $id = $request->validate([
            'name'=>'required'
        ]);
        Category::create([
            "name"=>$request->name
        ]);
        return response()->json([
            'mass'=>'add done'
        ],200);

    }
    public function all(){
      $data=  Category::all();
        return response()->json([
            "status"=>true,
           "msg"=>"Done",
            "date"=>$data
        ],200);
    }



}
