@extends('layouts.app')
@section('searchBar')
@include("components.searchbar")
@endsection
@section('content')

<div class="container mt-5 mb-5">
    <div class="d-flex mb-5 align-items-center">
        <h2 class="top-year-heading">Top of 2021</h2>
        <select name="top-mobile-year" id="top-mobile-year">
            <option value="">Choose year</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
        </select>
    </div>
    @include("components.mobiles")
</div>
<div class="container mt-5 mb-5">
    <div class="d-flex mb-5 align-items-center">
        <h2 class="top-year-heading">Top of Samsung</h2>
        <select name="top-mobile-brand" id="top-mobile-brand">
            <option value="">Choose Brands</option>
            <option value="samsung">Samsung</option>
            <option value="hewavi">Hewavi</option>
            <option value="google">Google</option>
            <option value="samsung">Samsung</option>
            <option value="hewavi">Hewavi</option>
            <option value="google">Google</option>
        </select>
    </div>
    @include("components.mobiles")
</div>
@endsection
