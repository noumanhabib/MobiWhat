@extends('layouts.app')

@section('content')
<div class="admin-container">
    <form action="{{isset($mobile) ? '/admin/mobiles/'.$mobile->id.'/update' : '/admin/mobiles/insert' }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @if(isset($mobile) && $mobile)
        @method('PUT')
        @endif
        <div class="container mt-4">
            <div class="heading">
                <p class="text-center h2">{{isset($mobile) ? 'Edit Mobile Info' : 'Add New Mobile'}}</p>
            </div>
            <div class="edit-info">

                <div class="info">
                    <p class="mr-3 text-bold text-capitalize"> Choose Brand </p>
                </div>
                <div class="info">
                    <select class=" text-capitalize" name="brand" id="brand" required>
                        <option value="">Choose Brand</option>
                        @foreach ($brands as $brand)
                        <option value="{{$brand->id}}" class="text-capitalize" @if (isset($mobile) && $mobile &&
                            $mobile->brand->id === $brand->id) selected @endif >{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    Choose mobile brand from list
                </div>

                @foreach ($strings as $string => $value)

                <div class="info">
                    <p class="mr-3 text-bold text-capitalize"> {{$value[0]}} </p>
                </div>
                <div class="info">
                    <input type="text" value="{{isset($mobile) ? $mobile[$string] : $mobile_helper[$string]}}"
                        name="{{$string}}" id="{{$string}}" required> {{$value[1]}}
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    {{$value[2]}}
                </div>

                @endforeach
                @foreach ($textareas as $text => $value)
                <div class="info area-info">
                    <p class="mr-3 text-bold text-capitalize">{{$value[0]}} : </p>
                </div>
                <div class="info area-info">
                    <textarea id="{{$text}}" name="{{$text}}" rows="2" value="" class="form-control md-textarea"
                        required style="margin-top: 0px; margin-bottom: 0px; width:350px; height: 150px;">
                        @if(isset($mobile)) {{$mobile[$text]}} @endif
                        @if(isset($mobile_helper)) {{$mobile_helper[$text]}} @endif
                    </textarea>
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    {{$value[2]}}
                </div>
                @endforeach

                @foreach ($images as $image => $value)
                <div class="info image-info">
                    <p class="mr-3 text-bold text-capitalize">{{$value[0]}} Image : </p>
                    @if(isset($mobile))
                    @if($mobile)
                    <img class="mr-4" width="70px" src="/storage{{$mobile[$image]}}" alt="First Image">
                    @endif
                    @endif
                </div>
                <div class="info">
                    <input accept="image/*" class="mt-3" type="file" id="{{$image}}" name="{{$image}}"
                        {{ isset($mobile) ? null : 'required'}}>
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    {{$value[2]}}
                </div>
                @endforeach
                @foreach ($floats as $float => $value)
                <div class="info">
                    <p class="mr-3 text-bold text-capitalize">{{$value[0]}} : </p>
                </div>
                <div class="info">
                    <input type="number" step="0.001"
                        value="{{isset($mobile) ? $mobile[$float] : $mobile_helper[$float]}}" name="{{$float}}"
                        id="{{$float}}" required> {{$value[1]}}
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    {{$value[2]}}
                </div>
                @endforeach
                @foreach ($integers as $integer => $value)
                <div class="info">
                    <p class="mr-3 text-bold text-capitalize">{{$value[0]}} : </p>
                </div>
                <div class="info">
                    <input type="number" value="{{isset($mobile) ? $mobile[$integer] : $mobile_helper[$integer]}}"
                        name="{{$integer}}" id="{{$integer}}" required> {{$value[1]}}
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    {{$value[2]}}
                </div>
                @endforeach
                @foreach ($checkboxes as $check => $value)
                <div class="info">
                    <p class="mr-3 text-bold text-capitalize">{{$value[0]}} : </p>
                </div>
                <div class="info">
                    <input type="checkbox" name="{{$check}}" id="{{$check}}" @if(isset($mobile) && $mobile[$check])
                        checked @endif @if(isset($mobile_helper) && $mobile_helper[$check]) checked @endif>
                </div>
                <div class="input-info-p invalid-feedback d-block">
                    {{$value[2]}}
                </div>
                @endforeach
                <div class="info">
                    <p class="mr-3 text-bold text-capitalize">Choose Images : </p>
                </div>
                <div class="info">
                    <input id="file_input" type="file" name="images[]" multiple>
                </div>

            </div>

            <h4>Buy Links</h4>
            <div class="edit-info" id="buylink">
                <div class="name mt-4 d-flex flex-column justify-content-start align-items-start">
                    <span>Enter Company name</span>
                    <input type="text" name="buylinknames[]" required>
                </div>
                <div class="link mt-4 d-flex flex-column justify-content-start align-items-start">
                    <span>Enter url</span>
                    <input style="width: 250px;" type="text" name="buylinks[]" required>
                </div>
            </div>

            <div class="add-link">
                <p>Left blank unused links fields</p>
                <span class="btn btn-secondary" id="addLink">Add New Link</span>
            </div>

            <div class="d-flex justify-content-center mt-3 mb-5">
                <a href="/admin" style="margin-right: 20px;" class="btn btn-lg btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-lg btn-primary">Save</button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    const addLink = document.getElementById("addLink");
    const linksDiv = document.getElementById("buylink");
    addLink.addEventListener("click", e => {
        linksDiv.innerHTML += `
            <div class="name mt-4 d-flex flex-column justify-content-start align-items-start">
                <span>Enter Company name</span>
                <input type="text" name="buylinknames[]">
            </div>
            <div class="link mt-4 d-flex flex-column justify-content-start align-items-start">
                <span>Enter url</span>
                <input style="width: 250px;" type="text" name="buylinks[]">
            </div>
        `;
    })
</script>
@endpush
