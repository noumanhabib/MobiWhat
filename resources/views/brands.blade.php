@extends('layouts.app')
@section('searchBar')
@include("components.searchbar")
@endsection
@section('content')

<div class="container mt-5 mb-5">
    <div class="brand-sort">
        <input class="brand-sort-input active" type="radio" name="brand-sort" id="brand-sort-top" attr="Top">
        <input class="brand-sort-input" type="radio" name="brand-sort" id="brand-sort-az" attr="A-Z">
    </div>

    <div class="brands" id="brands-list">
    </div>
</div>

@push('scripts')
<script>
    var topList;
    var azList;
    $(document).ready(function() {
        var listBrandTop = [];
        ajaxRequest("http://localhost:8000/api/brands", function(data){
            let brands = JSON.parse(data);
            brands.forEach(d => {
                listBrandTop.push(d.name);
            });
            updateBrandList(listBrandTop, "#brands-list");

            topList = [...listBrandTop];
            azList= listBrandTop.sort();
        });

        $("#brand-sort-az").on("change", function(e) {
            if(e.target.value === "on"){
                e.target.classList.add("active");
                $("#brand-sort-top")[0].classList.remove("active");
                $("#brand-sort-top")[0].checked = false;

                updateBrandList(azList, "#brands-list");
            }
        });
        $("#brand-sort-top").on("change", function(e) {
            if(e.target.value === "on"){
                e.target.classList.add("active");
                $("#brand-sort-az")[0].classList.remove("active");
                $("#brand-sort-az")[0].checked = false;

                updateBrandList(topList, "#brands-list");
            }
        });
    });
</script>
@endpush
@endsection
