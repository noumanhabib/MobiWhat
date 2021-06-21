<div class="searchBar">
    <div>
        <input placeholder="Search Mobile" type="text" id="search-bar-input" class="searchInput">
        <span class="invalid-feedback" id="query-error" role="alert" style="position: absolute;left: 5px;">
            <strong>Query must be greater then 2 character</strong>
        </span>
        <span class="searchIcon" id="search-btn">
            <i class="fa fa-search"></i>
        </span>
        <span class="brandFilter">
            <select name="brandInput" id="brandInput" class="text-capitalize">
                <option value="">Brands</option>
                @foreach ($brands as $brand)
                <option value="{{$brand->name}}" class="text-capitalize">{{ $brand->name }}</option>
                @endforeach

            </select>
        </span>

        <div class="options" id="options">

        </div>
    </div>

    {{-- Hidden POST form --}}
    <form action="/search" method="post" id="search-form" class="d-none" hidden>
        @csrf
        <input type="text" id="form-query" name="query" value="">
        <input type="text" id="form-brand" name="brand" value="">
    </form>
</div>
@push('scripts')

<script>
    const searchBtn = document.getElementById("search-btn");
    const error = document.getElementById("query-error");
    const formQuery = document.getElementById("form-query");
    const formBrand = document.getElementById("form-brand");
    const searchForm = document.getElementById("search-form");
    searchBtn.addEventListener("click", (e) => {
        let brand = document.getElementById("brandInput").value;
        let query = document.getElementById("search-bar-input").value;
        error.classList.remove("d-block");
        if (query.length <= 2) {
            error.classList.add("d-block");
            return;
        }
        formQuery.setAttribute("value", query);
        formBrand.setAttribute("value", brand);
        searchForm.submit();
    });

    const searchInput = document.getElementById("search-bar-input");
    var requesting = false;
    var query;
    $(searchInput).keyup(function(e) {
        query = e.target.value;
        if (query.length <= 2) {
            return;
        }
        if(!requesting){
            setTimeout(() => {
                query = e.target.value;
                if (query.length <= 2) {
                    return;
                }
                console.log("Requesting : ", query);
                requesting = false;
                requestHints(query, "#options");
            }, 700);
            requesting = true;
        }
    });



</script>
@endpush
