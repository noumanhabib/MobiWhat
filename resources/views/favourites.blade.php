@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <h2 class="mt-5 mb-4 text-center">Favourite mobiles</h2>
    <p class="text-center mb-4">Add mobile to favourite stack. Come to this page to check your favourite list. You can
        also remove mobiles from list.</p>

    <h4 class="mt-3">Favourite mobiles list</h4>
    <table class="table table-striped" id="fav-table">
        <thead>
            <tr>
                <th>No#</th>
                <th>Title</th>
                <th>Brand</th>
                <th>Image</th>
                <th></th>
            </tr>
        </thead>
        <tbody>


        </tbody>

    </table>
</div>
@endsection

@push('scripts')
<script>
    const favTableBody = document.querySelector("#fav-table tbody");
    if(favList.length > 0){
        url = `{{config('app.url')}}/api/mobile-list?q=favList`;
            ajaxRequest(url, function(data){
                data = JSON.parse(data);
                data.forEach((mobile, i) => {
                    let row = createFavRow(mobile, i+1);
                    favTableBody.appendChild(row);
                    addDeleteListener(mobile.id, row);
                });

            }, "GET", {favList});
    }

    function addDeleteListener(id, row){
        let deleteBtn = row.querySelector(".btn-trash-rm");
        deleteBtn.addEventListener("click", (e) => {
            removeFromFav(id);
            favTableBody.removeChild(row);
            $("#fav-added")[0].innerText = favList.length;
        })
    }
</script>
@endpush
