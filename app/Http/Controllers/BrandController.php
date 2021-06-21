<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function brands(Request $request)
    {
        $p = $request->query('p');
        if ($p === null) {
            $brands = Brand::all();
            return response(json_encode($brands), 200);
        }
        if ($p === "top") {
            $brands = Brand::limit(6)->get();
            return response(json_encode($brands), 200);
        }

        return response("Querey parameters are wrong", 500);
    }

    public function show(Request $request, $name)
    {
        $name = strtolower($name);
        $brand = Brand::where("name", $name)->first();
        $mobiles = [];
        if ($brand) {
            $mobiles = $brand->mobiles()->orderBy("ram", "DESC")->get();
        }
        return view('brand', ['mobiles' => $mobiles, 'brand' => $name]);
    }
}