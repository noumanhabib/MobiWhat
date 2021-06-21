@extends('layouts.app')
@section('content')
<div class=" container mt-5 mb-5 admin-container">
    <div class="d-flex mb-4">
        <button id="all-delete" class="btn font-1-2 btn-danger mr-5">Delete <i class="fa fa-trash"></i> </button>
        <a href="/admin/mobiles/add" class="btn font-1-2 btn-success">Add <i class="fas ml-2 fa-plus-square"></i></a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Brand</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mobiles as $mobile)
            <tr>
                <td><input type="checkbox" value="{{$mobile->id}}" name="mobiledelete[]" /></td>
                <td>{{$mobile->name}}</td>
                <td><img src="/storage{{$mobile->cover}}" width="50" alt="Mobile Image"></td>
                <td>{{$mobile->price}}</td>
                <td class="text-capitalize">{{$mobile->brand->name}}</td>
                <td>
                    <a class="update-btn" href="/admin/mobiles/{{$mobile->id}}/edit"><i class="fas fa-2x fa-pen-square"
                            aria-hidden="true"></i></a>
                    <form class=" d-inline-block" action="/admin/mobiles/{{$mobile->id}}/delete" method="post">
                        @csrf
                        @method('delete')
                        <button class="delete-btn"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form id="all-delete-form" action="/admin/mobiles/delete" method="post" class="d-none" hidden>
        @csrf
        @method('delete')
    </form>
</div>
@endsection

@push('scripts')
<script>
    const allDelete = document.getElementById("all-delete");
    const deleteCheckboxes = $("input[name='mobiledelete[]']");

    allDelete.addEventListener("click", e => {
        let i = 0;
        for (let index = 0; index < deleteCheckboxes.length; index++) {
            const element = deleteCheckboxes[index];
            if(element.checked){
                i++;
            }
        }
        if(i > 0){
            $("#all-delete-form").append(deleteCheckboxes);
            $("#all-delete-form").submit();
        }
    });
</script>
@endpush
