{{-- Show moiles for signle brand --}}
@extends("layouts.app")

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="mt-4 mb-4 text-capitalize">{{$brand}} Mobiles</h1>
    <div class="mobiles">
        @foreach ($mobiles as $mobile)
        @include("components.mobiles")
        @endforeach
    </div>
</div>
@endsection
