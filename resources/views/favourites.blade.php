@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <h2 class="mt-5 mb-4 text-center">Favourite mobiles</h2>
    <p class="text-center mb-4">Add mobile to favourite stack. Come to this page to check your favourite list. You can
        also remove mobiles from list.</p>

    <h4 class="mt-3">Favourite mobiles list</h4>
    <table class=" table table-striped">
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
            <tr>
                <td>1</td>
                <td>Samsung Galaxy A20s</td>
                <td>Samsung</td>
                <td>
                    <img src="{{asset("storage/slides/mob1.jpg")}}" width="50" alt="">
                </td>
                <td>
                    <button class="btn btn-trash-rm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Samsung Galaxy A20s</td>
                <td>Samsung</td>
                <td>
                    <img src="{{asset("storage/slides/mob2.jpg")}}" width="50" alt="">
                </td>
                <td>
                    <button class="btn btn-trash-rm"><i class="fas fa-trash"></i></button>

                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Samsung Galaxy A20s</td>
                <td>Samsung</td>
                <td>
                    <img src="{{asset("storage/slides/mob3.jpg")}}" width="50" alt="">
                </td>
                <td>
                    <button class="btn btn-trash-rm"><i class="fas fa-trash"></i></button>

                </td>
            </tr>
        </tbody>

    </table>
</div>
@endsection

