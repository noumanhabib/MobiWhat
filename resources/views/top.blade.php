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
    <div class="mobiles" id="top-year">
        @foreach ($top_of_year as $mobile)
        @include("components.mobiles")
        @endforeach
    </div>
</div>
<div class="container mt-5 mb-5">
    <div class="d-flex mb-5 align-items-center">
        <h2 class="top-year-heading">Top of Samsung</h2>
        <select name="top-mobile-brand" id="top-mobile-brand" class="text-capitalize">
            <option value="">Choose Brands</option>
            @foreach ($brands as $brand)
            <option value="{{$brand->name}}" class="text-capitalize">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mobiles" id="top-brand">
        @foreach ($top_of_brand as $mobile)
        @include("components.mobiles")
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var year = 2021;
        var brand = "samsung";
        $("#top-mobile-year").on("change", function(e){
            let choosenYear = parseInt(e.target.value);
            if(choosenYear === year){
                return;
            }
            if(choosenYear === 2021 || choosenYear === 2020 || choosenYear === 2019 || choosenYear === 2018){
                let url = `http://localhost:8000/api/top_mobiles?p=year&field=${choosenYear}`;
                ajaxRequest(url, function(data) {
                    year = choosenYear;
                    var jsonData = JSON.parse(data);
                    updateTopMobile(jsonData, "#top-year");
                });
            }
            else{
                return;
            }
        });

        $("#top-mobile-brand").on("change", function(e){
            let choosenBrand = e.target.value;
            if(choosenBrand === brand || choosenBrand === ""){
                return;
            }

            let url = `http://localhost:8000/api/top_mobiles?p=brand&field=${choosenBrand}`;
            ajaxRequest(url, function(data) {
                brand = choosenBrand;
                var jsonData = JSON.parse(data);
                updateTopMobile(jsonData, "#top-brand", brand);
            });

        });

    });

</script>
@endpush
