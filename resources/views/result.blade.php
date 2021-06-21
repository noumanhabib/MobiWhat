@extends("layouts.app")

@section('content')
<div class="mt-5 container-fluid mb-5">
    <h2 class=" text-center mt-4 mb-4">Comparison Result</h2>
    <table class="table table-bordered table-striped comp-result-table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                @foreach ($factors as $factor)
                <th class=" text-capitalize">{{str_replace("_", " ", $factor)}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($mobiles as $mobile)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$mobile->name}}</td>
                @foreach ($factors as $factor)
                <td class="text-capitalize">{{$mobile[$factor]}}
                    @if ($factor === "price")
                    Rs
                    @elseif ($factor === "ram" || $factor === "storage")
                    GB
                    @elseif ($factor === "camera_main" || $factor === "camera_front")
                    MP
                    @elseif ($factor === "battery_capacity")
                    MAH
                    @elseif ($factor === "cpu")
                    Ghz
                    @elseif ($factor === "screen_size")
                    " Inches
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="container mt-5 mb-5">
    <h2 class=" text-center mb-4">Comparison Mobiles</h2>
    <div class="mobiles">
        @foreach ($mobiles as $mobile)
        @include("components.mobiles")
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    const table = document.querySelector("table.table.comp-result-table");
    let factors_array_size = parseInt("{{sizeof($factors)}}");
    let query_width = "(max-width: " + factors_array_size * 120 + "px)";
    console.log(query_width);
    const mediaQuery = window.matchMedia(query_width);
    function handleTabletChanges(e){
        if(e.matches){
            console.log("Query match. Chnage ");
            table.classList.add("comp-result-table-responsive");
        }
        else{
            table.classList.remove("comp-result-table-responsive");

        }

    }
    mediaQuery.addListener(handleTabletChanges);
    handleTabletChanges(mediaQuery);
</script>
@endpush
