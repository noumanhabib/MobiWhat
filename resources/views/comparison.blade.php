@extends("layouts.app")

@section('content')
<div class="container mb-5">
    <h2 class="mt-5 mb-4 text-center">Compare mobiles</h2>
    <p class="text-center mb-4">Add mobile to compare stack. Come to this page and start comparing. You have to choose
        different factor for
        comparing.</p>

    <h4 class="mt-3">Mobile list for comparison</h4>
    <table id="comp-table" class="table table-striped">
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

    <h4 class="mt-5">Choose compare factors</h4>
    <div class="compare-factors d-flex flex-wrap mt-4 justify-content-between">
        <div class="factor-group">
            <div><input type="checkbox" name="price" id="price"> Price</div>
            <div><input type="checkbox" name="ram" id="ram"> Ram</div>
            <div><input type="checkbox" name="storage" id="storage"> Storage</div>
            <div><input type="checkbox" name="battery" id="battery"> Battery</div>
        </div>
        <div class="factor-group">
            <div><input type="checkbox" name="cpu" id="cpu"> Cpu</div>
            <div><input type="checkbox" name="cores" id="cores"> Cores</div>
            <div><input type="checkbox" name="os" id="os"> OS</div>
            <div><input type="checkbox" name="screen_size" id="screen_size"> Screen Size</div>
        </div>
        <div class="factor-group">
            <div><input type="checkbox" name="back_camera" id="back_camera"> Back Camera</div>
            <div><input type="checkbox" name="front_camera" id="front_camera"> Front Camera</div>
        </div>
    </div>
    <p id="comp-error" class="invalid-feedback mt-4 mb-0">At least 2 mobiles must be in compare stack to start comparing
    </p>

    <button id="comp-btn" class="btn btn-primary mt-5">Start Comparing</button>
</div>
@endsection

@push('scripts')
<script>
    //Using jQuery to disable name grouped checkbox.
    $('input[type="checkbox"]').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);
    });

    //Adding data to table
    const compTableBody = document.querySelector("#comp-table tbody");
    if(compList.length > 0){
        url = `{{config('app.url')}}/api/mobile-list?q=compList`;
            ajaxRequest(url, function(data){
                data = JSON.parse(data);
                data.forEach((mobile, i) => {
                    let row = createCompRow(mobile, i+1);
                    compTableBody.appendChild(row);
                    addDeleteListener(mobile.id, row);
                });

            }, "GET", {compList});
    }

    function addDeleteListener(id, row){
        let deleteBtn = row.querySelector(".btn-trash-rm");
        deleteBtn.addEventListener("click", (e) => {
            removeFromComp(id);
            compTableBody.removeChild(row);
        });
    }
    const compBtn = document.getElementById("comp-btn");
    const compError = document.getElementById("comp-error");
    //Check boxes
    const price = document.getElementById("price");
    const back_camera = document.getElementById("back_camera");
    const ram = document.getElementById("ram");
    const front_camera = document.getElementById("front_camera");
    const battery = document.getElementById("battery");
    const os = document.getElementById("os");
    const cpu = document.getElementById("cpu");
    const cores = document.getElementById("cores");
    const storage = document.getElementById("storage");
    const screen_size = document.getElementById("screen_size");
    compBtn.addEventListener("click", e => {
        if(compList.length < 2){
            compError.innerText = "At least 2 mobiles must be in compare stack to start comparing";
            compError.classList.add("d-block");
            return;
        }

        if(price.checked == false && back_camera.checked == false && ram.checked == false && front_camera.checked == false && battery.checked == false && os.checked == false && cpu.checked == false && cores.checked == false && storage.checked == false && screen_size.checked == false){
            compError.innerText = "Please choose atleast one compare factor";
            compError.classList.add("d-block");
            return;
        }
        let query = "factors=[";
        if(price.checked){
            query += "\"price\","
        }
        if(back_camera.checked){
            query += "\"camera_main\","
        }
        if(ram.checked){
            query += "\"ram\","
        }
        if(front_camera.checked){
            query += "\"camera_front\","
        }
        if(battery.checked){
            query += "\"battery_capacity\","
        }
        if(os.checked){
            query += "\"os\","
        }
        if(cpu.checked){
            query += "\"cpu\","
        }
        if(cores.checked){
            query += "\"core\","
        }
        if(storage.checked){
            query += "\"storage\","
        }
        if(screen_size.checked){
            query += "\"screen_size\","
        }

        query = query.substr(0, query.length-1);

        query += "]&comp=" + JSON.stringify(compList);

        let url = "http://localhost:8000/comparison?" + query;
        window.location.href = url;
    })

</script>
@endpush
