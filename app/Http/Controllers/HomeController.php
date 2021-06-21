<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Mobile;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $brands = Brand::limit(6)->get();
        $mobiles = Mobile::limit(50)->orderBy("price", "DESC")->get();
        return view('home', ['mobiles' => $mobiles, 'brands' => $brands]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function brands()
    {
        $brands = Brand::limit(6)->get();
        return view('brands', ['brands' => $brands]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function top()
    {
        $brands = Brand::limit(6)->get();
        $top_of_year = Mobile::where("is_top", true)->where("top_of_year", 2021)->orderBy("price")->get();

        $top_of_brand = Brand::find(1)->mobiles()->where("is_top", true)->get();
        return view('top', ['top_of_year' => $top_of_year, 'top_of_brand' => $top_of_brand, 'brands' => $brands]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mobile($id)
    {
        $mobile = Mobile::findOrFail($id);
        $rating = $mobile->reviews()->avg("given_star");
        $mobile["rating"] = $rating;
        return view('mobile', ['mobile' => $mobile]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $brands = Brand::all();
        return view('search', ['brands' => $brands]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function comparison(Request $request)
    {
        $l = $request->query("comp");
        $f = $request->query("factors");
        $list = json_decode($l);
        $factors = json_decode($f);

        if ($list && $factors) {
            $mobiles = Mobile::whereIn("id", $list)->get();
            return view("result", ["mobiles" => $mobiles, "factors" => $factors]);
        }
        return view('comparison');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function favourites()
    {
        return view('favourites');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function querySearch(Request $request)
    {
        $query = $request->input('query');
        $query = "%" . $query . "%";
        $brand = $request->input('brand');
        $mobiles = [];
        if ($brand === "") {
            $mobiles = Mobile::where('name', 'like', $query)->get();
        } else {
            $brand = Brand::where("name", $brand)->first();
            if ($brand) {
                $mobiles = $brand->mobiles()->where('name', 'like', $query)->get();
            } else {
                $mobiles = Mobile::where('name', 'like', $query)->get();
            }
        }

        return view('brand', ['mobiles' => $mobiles, 'brand' => "Search Query Result: " . sizeof($mobiles)]);
    }


    public function searchHints(Request $request)
    {
        $query = $request->input("query");
        $query = "%" . $query . "%";
        $mobiles = Mobile::select("name")->where('name', 'like', $query)->limit(8)->get();
        return response($mobiles->toJson(), 200);
    }

    public function quickSearch(Request $request)
    {
        $type = $request->query('p');
        if ($type === null || $type === "") {
            return redirect()->back();
        }
        $value = $request->query('q');
        if ($value === null || $value === "") {
            return redirect()->back();
        }
        if ($type === "cpu" || $type === "ram" || $type === "battery_capacity" || $type === "camera_main_video") {
            $value = (int) $value;
        }

        $mobiles = Mobile::where($type, $value)->get();
        return view('brand', ['mobiles' => $mobiles, 'brand' => "Search Query Result: " . sizeof($mobiles)]);
    }





    public function advnSearch(Request $request)
    {
        $brand_choice = $request->input("multiselectbrand");
        $mobiles = Mobile::select("mobiles.*", "brands.name as brand_name")->join('brands', 'mobiles.brand_id', '=', 'brands.id');
        if ($brand_choice && sizeof($brand_choice) > 0) {
            $mobiles = $mobiles->whereIn("brands.id", $brand_choice);
        }
        $availability = $request->input("multiselectavailbility");
        if ($availability && sizeof($availability) === 1) {
            $available = $availability[0] === "0" ? "comming soon" : "available";
            $mobiles = $mobiles->where("mobiles.availability", $available);
        }
        $resolution_width = $request->input("multiselectresolution");
        if ($resolution_width && sizeof($resolution_width) > 0) {
            $mobiles = $mobiles->whereIn("mobiles.resolution_width", $resolution_width);
        }

        $multiselecttech = $request->input("multiselecttech");
        if ($multiselecttech && sizeof($multiselecttech) > 0) {
            $tech = [];
            foreach ($multiselecttech as $key => $value) {
                $tech["mobiles." . $value] = true;
            }
            $mobiles = $mobiles->where($tech);
        }

        $multiselectplatform = $request->input("multiselectplatform");
        if ($multiselectplatform && sizeof($multiselectplatform) > 0) {
            $mobiles = $mobiles->whereIn("mobiles.os", $multiselectplatform);
        }
        $back_flash = $request->input("back-flash");
        $front_flash = $request->input("front-flash");
        if ($back_flash && $back_flash === "on") {
            $mobiles = $mobiles->where("mobiles.flash_main", true);
        }
        if ($front_flash && $front_flash === "on") {
            $mobiles = $mobiles->where("mobiles.flash_front", true);
        }
        $price = $request->input("price");
        if ($price && sizeof($price) === 2) {
            $mobiles = $mobiles->whereBetween("price", $price);
        }
        $ram = $request->input("ram");
        if ($ram && sizeof($ram) === 2) {
            $ram[0] = $ram[0] / 1000;
            $ram[1] = $ram[1] / 1000;
            $mobiles = $mobiles->whereBetween("ram", $ram);
        }
        $storage = $request->input("storage");
        if ($storage && sizeof($storage) === 2) {
            $mobiles = $mobiles->whereBetween("storage", $storage);
        }
        $battery = $request->input("battery");
        if ($battery && sizeof($battery) === 2) {
            $mobiles = $mobiles->whereBetween("battery_capacity", $battery);
        }
        $cpu = $request->input("cpu");
        if ($cpu && sizeof($cpu) === 2) {
            $mobiles = $mobiles->whereBetween("cpu", $cpu);
        }
        $cores = $request->input("cores");
        if ($cores && sizeof($cores) === 2) {
            $mobiles = $mobiles->whereBetween("core", $cores);
        }
        $primaryCamera = $request->input("primaryCamera");
        if ($primaryCamera && sizeof($primaryCamera) === 2) {
            $mobiles = $mobiles->whereBetween("camera_main", $primaryCamera);
        }
        $secCamera = $request->input("secCamera");
        if ($secCamera && sizeof($secCamera) === 2) {
            $mobiles = $mobiles->whereBetween("camera_front", $secCamera);
        }
        $screen = $request->input("screen");
        if ($screen && sizeof($screen) === 2) {
            $mobiles = $mobiles->whereBetween("screen_size", $screen);
        }

        $mobiles = $mobiles->get();
        return view('brand', ['mobiles' => $mobiles, 'brand' => "Search Query Result: " . sizeof($mobiles)]);
    }
}
