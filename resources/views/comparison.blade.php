@extends("layouts.app")

@section('content')
<div class="container mb-5">
    <h2 class="mt-5 mb-4 text-center">Compare mobiles</h2>
    <p class="text-center mb-4">Add mobile to compare stack. Come to this page and start comparing. You have to choose
        different factor for
        comparing.</p>

    <h4 class="mt-3">Mobile list for comparison</h4>
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

    <h4 class="mt-5">Choose compare factors</h4>
    <div class="compare-factors d-flex flex-wrap mt-4">
        <div class="factor-item">
            <span class="badge badge-success">Price</span>
            <div>
                <input type="checkbox" name="price" id="price-low"> Low
            </div>
            <div>
                <input type="checkbox" name="price" id="price-high"> High
            </div>
        </div>
        <div class="factor-item">
            <span class="badge badge-success">RAM</span>
            <div>
                <input type="checkbox" name="ram" id="ram-low"> Low
            </div>
            <div>
                <input type="checkbox" name="ram" id="ram-high"> High
            </div>
        </div>
        <div class="factor-item">
            <span class="badge badge-success">Battery</span>
            <div>
                <input type="checkbox" name="battery" id="battery-low"> Low
            </div>
            <div>
                <input type="checkbox" name="battery" id="battery-high"> High
            </div>
        </div>
        <div class="factor-item">
            <span class="badge badge-success">CPU</span>
            <div>
                <input type="checkbox" name="cpu" id="cpu-low"> Low
            </div>
            <div>
                <input type="checkbox" name="cpu" id="cpu-high"> High
            </div>
        </div>
        <div class="factor-item">
            <span class="badge badge-success">Storage</span>
            <div>
                <input type="checkbox" name="storage" id="storage-low"> Low
            </div>
            <div>
                <input type="checkbox" name="storage" id="storage-high"> High
            </div>
        </div>
    </div>

    <button class="btn btn-primary mt-5">Start Comparing</button>
</div>
@endsection

@push('scripts')
<script>
    //Using jQuery to disable name grouped checkbox.
    $('input[type="checkbox"]').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);
    });
</script>
@endpush

