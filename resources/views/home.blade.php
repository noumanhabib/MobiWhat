@extends('layouts.app')
@section('searchBar')
@include("components.searchbar")
@endsection
@section('content')

<div class="quickBar">
    <div class="quickItem">
        <select name="quickBrands" id="quickBrands" class="text-capitalize">
            <option value="">Brands</option>
            @foreach ($brands as $brand)
            <option value="{{$brand->name}}" class="text-capitalize">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="quickItem">
        <select name="quickOs" id="quickOs">
            <option value="">OS</option>
            <option value="android">Android</option>
            <option value="iphone">Iphone</option>
            <option value="google">Google</option>
            <option value="android">Android</option>
            <option value="hewavi">Hewavi</option>
            <option value="google">Google</option>
        </select>
    </div>
    <div class="quickItem">
        <select name="quickCpu" id="quickCpu">
            <option value="">CPU</option>
            <option value="2">2 GHz</option>
            <option value="3">3 GHz</option>
            <option value="4">4 GHz</option>
            <option value="5">5 GHz</option>
            <option value="6">6 GHz</option>
            <option value="7">7 GHz</option>
        </select>
    </div>
    <div class="quickItem">
        <select name="quickRam" id="quickRam">
            <option value="">RAM</option>
            <option value="2">2 GB</option>
            <option value="3">3 GB</option>
            <option value="4">4 GB</option>
            <option value="5">5 GB</option>
            <option value="6">6 GB</option>
            <option value="7">7 GB</option>
        </select>
    </div>
    <div class="quickItem">
        <select name="quickBattery" id="quickBattery">
            <option value="">Battery</option>
            <option value="500">500 mah</option>
            <option value="1000">1000 mah</option>
            <option value="3000">3000 mah</option>
            <option value="6000">6000 mah</option>
            <option value="10000">10000 mah</option>
            <option value="15000">15000 mah</option>
        </select>
    </div>
    <div class="quickItem">
        <select name="quickVideo" id="quickVideo">
            <option value="">Resolution & Video</option>
            <option value="144">144p</option>
            <option value="240">240p</option>
            <option value="360">360p</option>
            <option value="480">480p</option>
            <option value="720">720p</option>
            <option value="1080">1080p</option>
        </select>
    </div>
</div>

@include("components.slider")

<div class="container mt-5 mb-5">
    <div class="mobiles">
        @foreach ($mobiles as $mobile)
        @include("components.mobiles")
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#quickBrands").on("change", function(e){
        let brand = e.target.value;
        if(brand === ""){
            return;
        }
        window.location.href = `{{config('app.url')}}/brand/${brand}`;
    });
    $("#quickOs").on("change", function(e){
        let brand = e.target.value;
        if(brand === ""){
            return;
        }
        window.location.href = `{{config('app.url')}}/quick-search?p=os&q=${brand}`;
    });
    $("#quickCpu").on("change", function(e){
        let brand = e.target.value;
        if(brand === ""){
            return;
        }
        window.location.href = `{{config('app.url')}}/quick-search?p=cpu&q=${brand}`;
    });
    $("#quickRam").on("change", function(e){
        let brand = e.target.value;
        if(brand === ""){
            return;
        }
        window.location.href = `{{config('app.url')}}/quick-search?p=ram&q=${brand}`;
    });
    $("#quickBattery").on("change", function(e){
        let brand = e.target.value;
        if(brand === ""){
            return;
        }
        window.location.href = `{{config('app.url')}}/quick-search?p=battery_capacity&q=${brand}`;
    });
    $("#quickVideo").on("change", function(e){
        let brand = e.target.value;
        if(brand === ""){
            return;
        }
        window.location.href = `{{config('app.url')}}/quick-search?p=camera_main_video&q=${brand}`;
    });

</script>
@endpush

