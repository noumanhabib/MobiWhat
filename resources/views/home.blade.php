@extends('layouts.app')
@section('searchBar')
@include("components.searchbar")
@endsection
@section('content')

<div class="quickBar">
    <div class="quickItem">
        <select name="quickBrands" id="quickBrands">
            <option value="">Brands</option>
            <option value="samsung">Samsung</option>
            <option value="hewavi">Hewavi</option>
            <option value="google">Google</option>
            <option value="samsung">Samsung</option>
            <option value="hewavi">Hewavi</option>
            <option value="google">Google</option>
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
            <option value="0.5">0.5 GB</option>
            <option value="1">1 GB</option>
            <option value="2">2 GB</option>
            <option value="3">3 GB</option>
            <option value="4">4 GB</option>
            <option value="5">5 GB</option>
        </select>
    </div>
    <div class="quickItem">
        <select name="quickRam" id="quickRam">
            <option value="">Battery</option>
            <option value="0.5">0.5 GB</option>
            <option value="1">1 GB</option>
            <option value="2">2 GB</option>
            <option value="3">3 GB</option>
            <option value="4">4 GB</option>
            <option value="5">5 GB</option>
        </select>
    </div>
    <div class="quickItem">
        <select name="quickRam" id="quickRam">
            <option value="">Camera & Video</option>
            <option value="0.5">0.5 GB</option>
            <option value="1">1 GB</option>
            <option value="2">2 GB</option>
            <option value="3">3 GB</option>
            <option value="4">4 GB</option>
            <option value="5">5 GB</option>
        </select>
    </div>

</div>

@include("components.slider")

<div class="container mt-5 mb-5">
    @include("components.mobiles")
</div>
@endsection
