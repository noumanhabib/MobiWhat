@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <form action="/advn-search" id="adv-form" method="post" onsubmit="submitForm()">
        @csrf
        <h2 class="text-center mt-4">Advance Search</h2>
        <p class="text-center mb-5">Choose different factors below according to your choice and start searching</p>
        <div class="d-flex justify-content-between flex-wrap mb-5">
            <div class="d-flex flex-column">
                <span>Choose Brand</span>
                <select id="search-brand" multiple="multiple" class="text-capitalize">
                    @foreach ($brands as $brand)
                    <option value="{{$brand->id}}" class="text-capitalize">{{$brand->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex flex-column">
                <span>Choose Availability</span>
                <select id="search-availbility" multiple="multiple">
                    <option value="1">Available</option>
                    <option value="0">Comming soon</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <p class="mb-2 p-0">Choose Price Range</p>
            <div id="search-price" class="range-slider">
                <span class="min-range-value"></span>
                <span class="max-range-value"></span>
            </div>
        </div>
        <div class="mt-2 mb-5">
            <p class="mb-2 p-0">Choose RAM Range</p>
            <div id="search-ram" class="range-slider">
                <span class="min-range-value"></span>
                <span class="max-range-value"></span>
            </div>
        </div>
        <div class="mb-5">
            <p class="mb-2 p-0">Choose Storage Range</p>
            <div id="search-storage" class="range-slider">
                <span class="min-range-value"></span>
                <span class="max-range-value"></span>
            </div>
        </div>
        <div class="mb-4">
            <p class="mb-2 p-0">Choose Battery Range</p>
            <div id="search-battery" class="range-slider">
                <span class="min-range-value"></span>
                <span class="max-range-value"></span>
            </div>
        </div>
        <div class="d-flex flex-wrap mb-4 justify-content-between align-items-center">
            <div class="w-45">
                <p class="m-1 p-0">Choose Screen Size</p>
                <div id="search-screen" class="range-slider">
                    <span class="min-range-value"></span>
                    <span class="max-range-value"></span>
                </div>
            </div>
            <div class="w-45">
                <div class="d-flex flex-column">
                    <span>Choose Screen Resolution</span>
                    <select id="search-resolution" multiple="multiple">
                        <option value="480">480 x 800</option>
                        <option value="640">640 x 1136</option>
                        <option value="720">720 x 1280</option>
                        <option value="750">750 x 1334</option>
                        <option value="1080">1080 x 1920</option>
                        <option value="1440">1440 x 2560</option>
                        <option value="2160">2160 x 3840(4K)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="connectivity mt-5 mb-4">
            <h4>Connectivity</h4>
            <div class="d-flex flex-wrap">
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="3g" id="input-3g"> 3G
                </div>
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="4g" id="input-4g"> 4G
                </div>
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="5g" id="input-5g"> 5G
                </div>
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="wifi" id="input-wifi"> WiFi
                </div>
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="infrared" id="input-infra"> Infra-red
                </div>
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="bluetooth" id="input-bluetooth"> Blue-tooth
                </div>
                <div class="pr-5">
                    <input type="checkbox" name="multiselecttech[]" value="gps" id="input-gps"> GPS
                </div>
            </div>
        </div>

        <div class="platform mt-2 mb-4">
            <h4>Platform</h4>
            <select class="w-100 d-block" id="search-platform" multiple="multiple">
                <option value="android">Android</option>
                <option value="window">Windows</option>
                <option value="ios">iOS</option>
                <option value="blackberry">BlackBerry (RIM)</option>
                <option value="symbian">Symbian</option>
                <option value="fp">Featured Phones</option>
                <option value="all_smart">All Smartphones</option>
            </select>
            <div class="d-flex flex-wrap mt-4 justify-content-between">
                <div class="w-45">
                    <p class="m-1 p-0">Choose CPU Range</p>
                    <div id="search-cpu" class="range-slider">
                        <span class="min-range-value"></span>
                        <span class="max-range-value"></span>
                    </div>
                </div>
                <div class="w-45">
                    <p class="m-1 p-0">Choose Cores Range</p>
                    <div id="search-cores" class="range-slider">
                        <span class="min-range-value"></span>
                        <span class="max-range-value"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="camera mt-4 mb-4">
            <h4>Camera</h4>
            <div class="d-flex flex-column mt-4">
                <div class="mb-2">
                    <p class="mb-2 p-0">Choose Primary Camera Range</p>
                    <div id="search-primary-camera" class="range-slider">
                        <span class="min-range-value"></span>
                        <span class="max-range-value"></span>
                    </div>
                </div>
                <div>
                    <input type="checkbox" name="back-flash" id="back-flash"> Camera Flash
                </div>
                <div class="mt-4 mb-2">
                    <p class="mb-2 p-0">Choose Secondary Camera Range</p>
                    <div id="search-sec-camera" class="range-slider">
                        <span class="min-range-value"></span>
                        <span class="max-range-value"></span>
                    </div>
                </div>
                <div>
                    <input type="checkbox" name="front-flash" id="front-flash"> Front Flash

                </div>
            </div>
        </div>

        <div class="search-btn d-flex justify-content-center mt-5 mb-5">
            <button type="submit" id="adv-search" class="btn btn-info btn-lg">Start Advance Search</button>
        </div>
    </form>
</div>
@push('scripts')
<script src="{{ asset("js/multiselect.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#search-brand').multiselect({
            maxHeight: 300,
            checkboxName: function(option) {
                return 'multiselectbrand[]';
            },
            nonSelectedText: 'Choose Brands',
            allSelectedText: 'All Selected',
            includeSelectAllOption: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for Brands',
            includeResetOption: true,
            includeResetDivider: true,
            resetText: "Reset",
            width: 300
        });
        $('#search-availbility').multiselect({
            maxHeight: 300,
            checkboxName: function(option) {
                return 'multiselectavailbility[]';
            },
            nonSelectedText: 'Choose Availbility',
            allSelectedText: 'All Selected',
            width: 300
        });
        $('#search-platform').multiselect({
            maxHeight: 300,
            checkboxName: function(option) {
                return 'multiselectplatform[]';
            },
            nonSelectedText: 'Choose OS',
            allSelectedText: 'All Selected',
            width: 300
        });
        $('#search-resolution').multiselect({
            maxHeight: 300,
            checkboxName: function(option) {
                return 'multiselectresolution[]';
            },
            nonSelectedText: 'Choose Resolution',
            allSelectedText: 'All Selected',
            width: 300
        });
        //Price Slider
        let price_slider = document.getElementById("search-price");
        jQuerySlider.create(price_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 200000],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 500],
                '10%': [2000, 1000],
                '25%': [5000, 2000],
                '40%': [10000, 5000],
                'max': [200000]
            }
        });
        handleMinMax(price_slider, 200000, "PKR");

        //RAM Slider
        let ram_slider = document.getElementById("search-ram");
        window.ram_slider = ram_slider;
        jQuerySlider.create(ram_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 12000],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 256],
                '16%': [768, 1000-768],
                '20%': [1000, 500],
                '40%': [3000, 1000],
                '50%': [4000, 2000],
                'max': [12000]
            }
        });
        handleMinMax(ram_slider, 12000, "MB", "ram");

        //Storage Slider
        let storage_slider = document.getElementById("search-storage");
        jQuerySlider.create(storage_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 1024],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 2],
                '10%': [8, 8],
                '22%': [16, 16],
                '33%': [32, 32],
                '44%': [64, 64],
                '55%': [128, 128],
                '66%': [256, 256],
                '77%': [512, 512],
                'max': [1024],
            }
        });
        handleMinMax(storage_slider, 1024, "GB");

        //Battery Slider
        let battery_slider = document.getElementById("search-battery");
        jQuerySlider.create(battery_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 12000],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 1000],
                'max': [12000],
            }
        });
        handleMinMax(battery_slider, 12000, "mah");

        //CPU Slider
        let cpu_slider = document.getElementById("search-cpu");
        jQuerySlider.create(cpu_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 10],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 0.5],
                'max': [10],
            }
        });
        handleMinMax(cpu_slider, 10, "Ghz");

        //Cores Slider
        let cores_slider = document.getElementById("search-cores");
        jQuerySlider.create(cores_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 12],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 2],
                'max': [12],
            }
        });
        handleMinMax(cores_slider, 12, "Cores");

        //Primary Camera Slider
        let primary_camera_slider = document.getElementById("search-primary-camera");
        jQuerySlider.create(primary_camera_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 128],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 2],
                '5%': [8, 8],
                '15%': [16, 16],
                'max': [128],
            }
        });
        handleMinMax(primary_camera_slider, 128, "MP");

        //Secondary Camera Slider
        let sec_camera_slider = document.getElementById("search-sec-camera");
        jQuerySlider.create(sec_camera_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 12],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 2],
                'max': [12],
            }
        });
        handleMinMax(sec_camera_slider, 12, "MP");

        //Screen size Slider
        let screen_slider = document.getElementById("search-screen");
        jQuerySlider.create(screen_slider, {
            connect: true,
            behaviour: 'tap',
            start: [0, 8],
            //    min,  max
            range: {
                // Starting at 500, step the value by 500,
                // until 4000 is reached. From there, step by 1000.
                'min': [0, 0.1],
                'max': [8],
            }
        });
        handleMinMax(screen_slider, 8, "Inch");

    });

    function handleMinMax(slider, max, append = "", filter = ""){
        var nodes = [
            slider.querySelector('.min-range-value'), // 0
            slider.querySelector('.max-range-value')  // 1
        ];
        slider.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            if(parseFloat(values[handle]) === 0 && handle === 0){
                nodes[handle].innerText = 'Min';
            }
            else if(parseFloat(values[handle]) === max && handle === 1){
                nodes[handle].innerText = 'Max';
            }
            else{
                if(filter === "ram" && parseInt(values[handle]) >= 1000){
                    nodes[handle].innerText = (parseInt(values[handle]) / 1000).toFixed(2) + " GB";
                }
                else{
                nodes[handle].innerText = values[handle] + " " + append;
                }
            }
        });
    }


    function submitForm(){
        let price = document.getElementById("search-price").noUiSlider.get();
        let ram = document.getElementById("search-ram").noUiSlider.get();
        let storage = document.getElementById("search-storage").noUiSlider.get();
        let battery = document.getElementById("search-battery").noUiSlider.get();
        let cpu = document.getElementById("search-cpu").noUiSlider.get();
        let cores = document.getElementById("search-cores").noUiSlider.get();
        let primaryCamera = document.getElementById("search-primary-camera").noUiSlider.get();
        let secCamera = document.getElementById("search-sec-camera").noUiSlider.get();
        let screen = document.getElementById("search-screen").noUiSlider.get();
        $("#adv-form").append(
            `
            <input type="hidden" value="${price[0]}" name="price[]" />
            <input type="hidden" value="${price[1]}" name="price[]" />
            <input type="hidden" value="${ram[0]}" name="ram[]" />
            <input type="hidden" value="${ram[1]}" name="ram[]" />
            <input type="hidden" value="${storage[0]}" name="storage[]" />
            <input type="hidden" value="${storage[1]}" name="storage[]" />
            <input type="hidden" value="${battery[0]}" name="battery[]" />
            <input type="hidden" value="${battery[1]}" name="battery[]" />
            <input type="hidden" value="${cpu[0]}" name="cpu[]" />
            <input type="hidden" value="${cpu[1]}" name="cpu[]" />
            <input type="hidden" value="${cores[0]}" name="cores[]" />
            <input type="hidden" value="${cores[1]}" name="cores[]" />
            <input type="hidden" value="${primaryCamera[0]}" name="primaryCamera[]" />
            <input type="hidden" value="${primaryCamera[1]}" name="primaryCamera[]" />
            <input type="hidden" value="${secCamera[0]}" name="secCamera[]" />
            <input type="hidden" value="${secCamera[1]}" name="secCamera[]" />
            <input type="hidden" value="${screen[0]}" name="screen[]" />
            <input type="hidden" value="${screen[1]}" name="screen[]" />

            `
        );
        return true;
    }

</script>
@endpush
@endsection

