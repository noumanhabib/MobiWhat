<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Buylink;
use App\Models\Image;
use App\Models\Mobile;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /* db_filed_name => [Showname, Unit, Placeholder] */
    private $integers = [
        "core" => ['Cpu Cores', '', 'Enter number i.e. 2,4,8...'],
        "resolution_width" => ['Resolution Width', 'pixels', 'Enter number i.e. 240,480,1080...'],
        "resolution_height" => ['Resolution Hight', 'pixels', 'Enter number i.e. 240,480,1080...'],
        "ram" => ['RAM', 'GB', 'Enter number i.e. 2,8,12...'],
        "battery_capacity" => ['Mobile Battery Capacity', 'MAH', 'Enter number i.e. 1200,4800,5000...'],
        "storage" => ['Internal Storage', 'GB', 'Enter number i.e. 32, 64, 128...'],
        "camera_main" => ['Back Camera Resolution', 'Maga Pixel', 'Enter number i.e. 20, 48, 64...'],
        "camera_front" => ['Front Camera Resolution', 'Maga Pixel', 'Enter number i.e. 12, 16, 20...'],
        "camera_main_video" => ['Back Camera Video Quality', 'Pixels', 'Enter number i.e. 240,480,1080...'],
        "camera_front_video" => ['Front Camera Video Quality', 'Pixels', 'Enter number i.e. 240,480,1080...'],
        "top_of_year" => ['Top In Year', '', 'Enter year(2021, 2020) etc to show mobile in top years. Top must be true']
    ];
    private $strings = [
        "name" => ['Mobile Name', '', 'Enter full mobile name'],
        "os" => ['Operating System', '', 'Enter full OS name'],
        "availability" => ['Availability', '', 'available | comming soon'],
        "ui" => ['System UI', '', 'UI description/techname'],
        "dimensions" => ['Dimensions', 'mm', 'Enter x seperated value i.e. 159.7 x 73.9 x 7.3 mm'],
        "sim" => ['About SIMs', '', 'Enter SIM info i.e. Dual SIM, Dual Standby'],
        "colors" => ['Mobile Colors', '', 'Enter , seperated color list i.e. Dusk Blue, Sunset Dazzle,...'],
        "gpu" => ['About GPU', '', 'Enter GPU info i.e. Mali-G57 MC3...'],
        "display_technology" => ['Display Tech Info', '', 'Enter display tech info i.e. AMOLED Capacitive Touchscreen, 16M Colors,...'],
        "external_card" => ['About External Card', '', 'Enter value i.e. microSDXC (dedicated slot)...'],
        "camera_main_string" => ['About Main Camera(s)', '', 'Enter back camera(s) full info i.e. Triple Camera: 64 MP...'],
        "camera_front_string" => ['About Front Camera(s)', '', 'Enter front camera(s) full info i.e. Triple Camera: 64 MP...'],
        "usb" => ['USB Info', '', 'Enter string i.e. Yes + A-GPS support...'],
        "mobile_data_connection" => ['Data Connections Info', '', 'i.e. GPRS, Edge, 3G (HSPA 42.2/5.76 Mbps), 4G, LTE...'],
        "audio" => ['About Device Audio', '', 'i.e. 3.5mm Audio Jack, 24-bit/192kHz audio...'],
        "audio_format" => ['Audio Format(s)', '', 'Enter / separated value i.e. MP4/MP3/WAV/...'],
        "browser" => ['Browser Support Info', '', 'i.e. HTML5...'],
        "messaging" => ['Built-In Massages', '', 'Enter string i.e. SMS(threaded view), MMS, Email, Push Mail, IM..'],
        "games" => ['Games Support Info', '', 'Enter description i.e. Built-in + Downloadable...'],
        "fast_charging" => ['About Fast Charging', '', 'i.e. Fast charging 33W, 63% in 30 min...'],
        "video_review" => ['Mobile Video Review Link', '', 'Enter url i.e. https://review.mobile.video...']
    ];

    private $checkboxes = [
        "is_top" => ['Top Mobile', '', 'Show mobile in top list or not(check/uncheck)'],
        "2g" => ['Support 2G Connection', '', 'Show mobile in top list or not(check/uncheck)'],
        "3g" => ['Support 3G Connection', '', 'Show mobile in top list or not(check/uncheck)'],
        "4g" => ['Support 4G Connection', '', 'Show mobile in top list or not(check/uncheck)'],
        "5g" => ['Support 5G Connection', '', 'Show mobile in top list or not(check/uncheck)'],
        "flash_main" => ['Mobile has back flash', '', 'Mobile has back flash(check/uncheck)'],
        "flash_front" => ['Mobile has front flash', '', 'Mobile has front flash(check/uncheck)'],
        "wifi" => ['Mobile has Wifi', '', 'Mobile has wifi(check/uncheck)'],
        "hotspot" => ['Mobile has Hotspot', '', 'Mobile has hotspot(check/uncheck)'],
        "bluetooth" => ['Mobile has Bluetooth', '', 'Mobile has bluetooth(check/uncheck)'],
        "gps" => ['Mobile has GPS', '', 'Mobile has gps(check/uncheck)'],
        "fingerprint" => ['Mobile has Fingerprint', '', 'Mobile has fingerprint sensor(check/uncheck)'],
        "infrared" => ['Mobile has Infar-red', '', 'Mobile has infrared sensor(check/uncheck)'],
        "gyro" => ['Mobile gas Gyro', '', 'Mobile has gyro sensor(check/uncheck)'],
        "compass" => ['Mobile has Compass', '', 'Mobile has compass sensor(check/uncheck)'],
    ];

    private $floats = [
        "weight" => ['Weight', 'gm', 'Enter decimal/number i.e. 120,280,179...'],
        "cpu" => ['CPU', 'Ghz', 'Enter decimal/number i.e. 2,8,12...'],
        "screen_size" => ['Screen Size', 'Inches', 'Enter decimal/number i.e. 2,8,12...'],
        "price" => ['Price', 'Ruppes', 'Enter decimal/number i.e. 2000,8000,12000...'],
    ];

    private $textareas = [
        "description" => ['Mobile Description', '', 'Enter full mobile description']
    ];

    private $images = [
        "cover" => ['Cover', '', 'Enter mobile cover image. It is the main image']
    ];


    public function home(Request $request)
    {
        $mobiles = Mobile::all();
        return view('admin.home', ['mobiles' => $mobiles]);
    }

    public function delete(Request $request)
    {
        $ids = $request->input("mobiledelete");
        foreach ($ids as $id) {
            $mobile = Mobile::find($id);
            $mobile->deleteImages();
            $mobile->deleteReviews();
            $mobile->deleteLinks();
            $mobile->delete();
        }

        return redirect("/admin")->with("message", "Mobiles deleted successfully");
    }
    public function destroy(Request $request, $id)
    {
        $mobile = Mobile::find($id);
        $i = $mobile->deleteImages();
        $mobile->deleteReviews();
        $mobile->deleteLinks();
        $mobile->delete();
        return redirect("/admin")->with("message", "Mobile deleted successfully. " . $i . " images deleted of this mobile");
    }
    /**
     * Show add view
     */
    public function add(Request $request)
    {
        $brands = Brand::all();
        $mobile_helper = Mobile::find(1);
        return view('admin.mobile', ["mobile_helper" => $mobile_helper, "brands" => $brands, "integers" => $this->integers, "strings" => $this->strings, "checkboxes" => $this->checkboxes, "floats" => $this->floats, "textareas" => $this->textareas, "images" => $this->images]);
    }

    /**
     * Insert post data to database
     */
    public function save(Request $request)
    {
        $mobile = new Mobile;

        if ($request->has("brand") && $request->input("brand")) {
            $mobile->brand_id = $request->input("brand");
        } else {
            return redirect()->back()->with("error", "No brand is selected");
        }

        foreach ($this->integers as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            } else {
                return redirect()->back()->with("error", "$key field is empty");
            }
        }
        foreach ($this->strings as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            } else {
                return redirect()->back()->with("error", "$key field is empty");
            }
        }
        foreach ($this->floats as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            } else {
                return redirect()->back()->with("error", "$key field is empty");
            }
        }
        foreach ($this->textareas as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            } else {
                return redirect()->back()->with("error", "$key field is empty");
            }
        }

        foreach ($this->checkboxes as $key => $value) {
            if ($request->has($key) && $request->input($key) === "on") {
                $mobile[$key] = true;
            } else {
                $mobile[$key] = false;
            }
        }
        foreach ($this->images as $key => $value) {
            $image = $request->file($key);
            if ($image) {
                $fileName = str_replace(' ', '-', round(microtime(true) * 1000) . $image->getClientOriginalName());
                $image->move(public_path() . '/storage/images/', $fileName);
                $mobile->cover = "/images/" . $fileName;
            } else {
                return redirect()->back()->with("error", "No $key image selected");
            }
        }

        $mobile->save();

        $mobileImages = $request->file("images");
        if ($mobileImages) {
            foreach ($mobileImages as $image) {
                $dbImage = new Image;
                $fileName = str_replace(' ', '-', round(microtime(true) * 1000) . $image->getClientOriginalName());
                $image->move(public_path() . '/storage/images/', $fileName);
                $dbImage->url = "/images/" . $fileName;
                $dbImage->mobile_id = $mobile->id;
                $dbImage->save();
            }
        }

        $buylinknames = $request->input("buylinknames");
        $buylinks = $request->input("buylinks");
        if ($buylinknames && $buylinks) {
            for ($i = 0; $i < sizeof($buylinknames); $i++) {
                if (!$buylinknames[$i] || !$buylinks[$i]) {
                    continue;
                }
                $newLink = new Buylink;
                $newLink->mobile_id = $mobile->id;
                $newLink->name = $buylinknames[$i];
                $newLink->url = $buylinks[$i];
                $newLink->save();
            }
        }

        return redirect("/admin")->with("message", "New mobile added successfuly");
    }
    /**
     * Show edit data view
     */
    public function edit(Request $request, $id)
    {
        $mobile = Mobile::findOrFail($id);
        $brands = Brand::all();
        return view('admin.mobile', ["mobile" => $mobile, "brands" => $brands, "integers" => $this->integers, "strings" => $this->strings, "checkboxes" => $this->checkboxes, "floats" => $this->floats, "textareas" => $this->textareas, "images" => $this->images]);
    }
    /**
     * Update post data to database
     */
    public function update(Request $request, $id)
    {
        $mobile = Mobile::find($id);
        if ($request->has("brand") && $request->input("brand")) {
            $mobile->brand_id = $request->input("brand");
        }

        foreach ($this->integers as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            }
        }
        foreach ($this->strings as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            }
        }
        foreach ($this->floats as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            }
        }
        foreach ($this->textareas as $key => $value) {
            if ($request->has($key) && $request->input($key)) {
                $mobile[$key] = $request->input($key);
            }
        }

        foreach ($this->checkboxes as $key => $value) {
            if ($request->has($key) && $request->input($key) === "on") {
                $mobile[$key] = true;
            } else {
                $mobile[$key] = false;
            }
        }
        foreach ($this->images as $key => $value) {
            //Replace image
            $image = $request->file($key);
            if ($image) {
                $mobile->deleteImage($key);
                $fileName = str_replace(' ', '-', round(microtime(true) * 1000) . $image->getClientOriginalName());
                $image->move(public_path() . '/storage/images/', $fileName);
                $mobile[$key] = "/images/" . $fileName;
            }
        }
        $mobile->save();

        $mobileImages = $request->file("images");
        if ($mobileImages) {
            foreach ($mobileImages as $image) {
                $dbImage = new Image;
                $fileName = str_replace(' ', '-', round(microtime(true) * 1000) . $image->getClientOriginalName());
                $image->move(public_path() . '/storage/images/', $fileName);
                $dbImage->url = "/images/" . $fileName;
                $dbImage->mobile_id = $mobile->id;
                $dbImage->save();
            }
        }

        $buylinknames = $request->input("buylinknames");
        $buylinks = $request->input("buylinks");
        if ($buylinknames && $buylinks) {
            for ($i = 0; $i < sizeof($buylinknames); $i++) {
                if (!$buylinknames[$i] || !$buylinks[$i]) {
                    continue;
                }
                $newLink = new Buylink;
                $newLink->mobile_id = $mobile->id;
                $newLink->name = $buylinknames[$i];
                $newLink->url = $buylinks[$i];
                $newLink->save();
            }
        }

        return redirect("/admin")->with("message", "Mobile updated successfuly");
    }
}