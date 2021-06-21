<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Mobile;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function mobiles(Request $request)
    {

        $p = $request->query('p');
        if ($p === null) {
            $mobiles = Mobile::select("id", "price", "is_top")->where('is_top', true)->orderBy("price", "desc")->get();
            return response(json_encode($mobiles), 200);
        }
        $pageNumber = (int) $p;
        if ($pageNumber < 1) {
            return response("Query parameter value is wrong", 500);
        }
        $start = ($pageNumber * 10) - 10;
        $mobiles = Mobile::select("id")->skip($start)->take(10)->get();

        return response(json_encode($mobiles), 200);
    }
    public function topMobiles(Request $request)
    {
        $p = $request->query('p');
        if ($p === "year") {
            $field = (int) $request->query('field');
            if ($field === 2021 || $field === 2020 || $field === 2019 || $field === 2018) {
                $top_of_year = Mobile::select("mobiles.*", "brands.name as brand_name")->join('brands', 'mobiles.brand_id', '=', 'brands.id')->where("is_top", true)->where("top_of_year", $field)->orderBy("price")->get();

                return response(json_encode($top_of_year), 200);
            }
        }
        if ($p === "brand") {
            $field = $request->query('field');
            try {
                $brand = Brand::where("name", $field)->first();
                if ($brand) {
                    $top_of_brand = $brand->mobiles()->where("is_top", true)->get();
                    return response(json_encode($top_of_brand), 200);
                }
            } catch (Exception $e) {
                return response("Query parameter value is wrong", 500);
            }
        }
        return response("Query parameter value is wrong", 500);
    }

    public function mobileList(Request $request)
    {
        $q = $request->query('q');
        $mobiles = [];
        if ($q != null && $q != "") {
            $list = $request->input($q);
            if (sizeof($list) > 0) {
                $mobiles = Mobile::select("mobiles.*", "brands.name as brand_name")->join('brands', 'mobiles.brand_id', '=', 'brands.id')->whereIn('mobiles.id', $list)->get();
            }
            return response(json_encode($mobiles), 200);
        }
        return response("Query parameter value is wrong", 500);
    }

    public function review(Request $request, $id)
    {
        $mobile = Mobile::findOrFail($id);
        $review = new Review;

        $review->mobile_id = $mobile->id;
        $review->user_name = $request->input("user_name");
        $review->given_star = $request->input("given_star");
        $review->description = $request->input("description");
        $review->save();

        return redirect()->back()->with("message", "Review added successfuly");
    }
}