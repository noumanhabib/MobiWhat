@extends('layouts.app')

@section('content')

<div class="container mt-5 mb-5 mobile">
    <h2 class="title text-center text-capitalize">{{$mobile->name}}</h2>
    <p class="description">
        {{$mobile->description}}
    </p>

    <div class="mobile-images">
        @foreach ($mobile->images as $image)
        <img src="{{asset('storage' . $image->url)}}" alt="{{$mobile->name}} image">
        @endforeach
    </div>

    <div class="d-flex justify-content-end">
        <button id="add-to-fav" class="btn btn-primary">Add to favourites <i class="fa fa-plus ml-2"></i></button>
    </div>
    <div class="d-flex justify-content-end mt-2 mb-4">
        <button id="add-to-comp" class="btn btn-success">Add for comparison <i class="fa fa-plus ml-2"></i></button>
    </div>

    {{-- Accordine --}}
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Gernal Information
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="info-item">
                        <div class="item-name"> Brand </div>
                        <div class="item-value">{{$mobile->brand->name}}</div>
                    </div>
                    <div class="info-item">
                        <div class="item-name"> Price </div>
                        <div class="item-value">{{$mobile->price}} Rs</div>
                    </div>
                    <div class="info-item">
                        <div class="item-name"> Ram </div>
                        <div class="item-value">{{$mobile->ram}} GB</div>
                    </div>
                    <div class="info-item">
                        <div class="item-name"> Storage </div>
                        <div class="item-value">{{$mobile->storage}} GB</div>
                    </div>
                    <div class="info-item">
                        <div class="item-name"> Battery </div>
                        <div class="item-value">{{$mobile->battery_capacity}} mah</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        All specifications
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="all-info-item">
                        <div class="info-item-group">Build</div>
                        <div class="info-item-name">
                            <div>OS</div>
                            <div>UI</div>
                            <div>Weight</div>
                            <div>SIM</div>
                            <div>Colors</div>
                        </div>
                        <div class="info-item-value">
                            <div class=" text-capitalize">{{$mobile->os}}</div>
                            <div>{{$mobile->ui}}</div>
                            <div>{{$mobile->weight}}</div>
                            <div>{{$mobile->sim}}</div>
                            <div>{{$mobile->colors}}</div>
                        </div>
                    </div>
                    <div class="all-info-item">
                        <div class="info-item-group">Processor</div>
                        <div class="info-item-name">
                            <div>CPU</div>
                            <div>GPU</div>
                            <div>Cores</div>
                        </div>
                        <div class="info-item-value">
                            <div>{{$mobile->cpu}} Ghz</div>
                            <div>{{$mobile->gpu}}</div>
                            <div>{{$mobile->core}}</div>
                        </div>
                    </div>
                    <div class="all-info-item">
                        <div class="info-item-group">Display</div>
                        <div class="info-item-name">
                            <div>Technology</div>
                            <div>Screen Size</div>
                            <div>Resolution</div>
                        </div>
                        <div class="info-item-value">
                            <div>{{$mobile->display_technology}}</div>
                            <div>{{$mobile->screen_size}}</div>
                            <div>{{$mobile->resolution_width}} x {{$mobile->resolution_height}} Pixels</div>
                        </div>
                    </div>
                    <div class="all-info-item">
                        <div class="info-item-group">Memory</div>
                        <div class="info-item-name">
                            <div>Ram</div>
                            <div>Internal Storage</div>
                            <div>External Card</div>
                        </div>
                        <div class="info-item-value">
                            <div>{{$mobile->ram}} GB</div>
                            <div>{{$mobile->storage}} GB</div>
                            <div>{{$mobile->external_card}}</div>
                        </div>
                    </div>
                    <div class="all-info-item">
                        <div class="info-item-group">Camera</div>
                        <div class="info-item-name">
                            <div>Main Camera</div>
                            <div>Front Camera</div>
                        </div>
                        <div class="info-item-value">
                            <div>{{$mobile->camera_main_string}}</div>
                            <div>{{$mobile->camera_front_string}}</div>
                        </div>
                    </div>
                    <div class="all-info-item">
                        <div class="info-item-group">Battery</div>
                        <div class="info-item-name">
                            <div>Battery capacity</div>
                            <div>Fast charging</div>
                        </div>
                        <div class="info-item-value">
                            <div>{{$mobile->battery_capacity}}</div>
                            <div>{{$mobile->fast_charging}}</div>
                        </div>
                    </div>
                    <div class="all-info-item">
                        <div class="info-item-group">Price</div>
                        <div class="info-item-name">
                            <div>Pakistan</div>
                            <div>India</div>
                            <div>America</div>
                            <div>France</div>
                            <div>Euorpe</div>
                        </div>
                        <div class="info-item-value">
                            <div>{{$mobile->price}} Rs</div>
                            <div>{{$mobile->price / 1.5}} Irs</div>
                            <div>{{$mobile->price / 160}} $</div>
                            <div>{{$mobile->price / 160}} $</div>
                            <div>{{$mobile->price / 160}} $</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Buy Links
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    @foreach ($mobile->links as $link)
                    <div class="info-item">
                        <div class="item-name"> {{$link->name}} </div>
                        <div class="item-value"> <a href="{{$link->url}}" target="_blank" rel="noopener noreferrer"> Go
                                To {{$link->name}} </a> </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingFoure">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseFoure" aria-expanded="false" aria-controls="collapseFoure">
                        Reviews
                    </button>
                </h2>
            </div>
            <div id="collapseFoure" class="collapse" aria-labelledby="headingFoure" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="d-flex">
                        <div data-rating="{{$mobile->rating}}" id="mobile-rating"></div>
                        <span class="ml-4">({{round($mobile->rating, 1)}}/5)</span>
                    </div>
                    <div class="mt-4 mb-4">
                        <h3>Give Review</h3>
                        <form action="/mobile/{{$mobile->id}}/review" method="post"
                            onsubmit="return handleReviewForm()">
                            @csrf
                            <div>Name: <input class="ml-3" type="text" name="user_name" id="user_name" required></div>
                            <div class=" d-flex align-items-center mt-4">Rating: <span class="ml-3"
                                    id="given_star"></span> </div>
                            <div class="d-flex mt-3 flex-column">
                                <p class="m-0 p-0">Write Your Experience</p>
                                <textarea id="description" name="description" rows="2" class="form-control md-textarea"
                                    required style="margin-top: 0px; margin-bottom: 0px; width:350px; height: 150px;">
                                </textarea>
                            </div>
                            <input type="hidden" name="given_star" id="given_star_input" required>
                            <div class="invalid-feedback" id="review-error"></div>
                            <button type="submit" class="btn mt-3 btn-secondary">Add Review</button>
                        </form>
                    </div>
                    <div class="mobile-reviews">
                        @foreach ($mobile->reviews as $review)
                        @if ($loop->iteration > 10)
                        @break
                        @endif
                        <div class="review-item">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <p class=" text-capitalize">User Name: {{$review->user_name}}</p>
                                <div class="d-flex align-items-center">
                                    <div data-rating="{{$review->given_star}}" class="review-rating"></div>
                                    <span class="ml-4">({{round($review->given_star, 1)}}/5)</span>
                                </div>
                            </div>
                            <p class="review-desc mt-2 mb-1">
                                {{substr($review->description, 0, 200)}}
                                @if (strlen($review->description) > 200)
                                ...
                                @endif
                            </p>
                            <p>Date : {{$review->created_at ? $review->created_at->toDateString() : "Unknown"}}</p>
                        </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /* Removing white spaces of textareas */
    document.getElementById("description").setAttribute("value", "");
    document.getElementById("description").innerText = "";


    const addToFavBtn = document.getElementById("add-to-fav");
    const addToCompBtn = document.getElementById("add-to-comp");
    let mobile_id = parseInt("{{$mobile->id}}");

    if(favList.includes(mobile_id)){
        addToFavBtn.innerText = "In Favourite List";
        addToFavBtn.setAttribute("disabled", true);
    }
    else{
        addToFavBtn.addEventListener("click", (e) => {
            addToFav(mobile_id);
            addToFavBtn.innerText = "In Favourite List";
            $("#fav-added")[0].innerText = favList.length;
            addToFavBtn.setAttribute("disabled", true);
        });
    }


    if(compList.includes(mobile_id)){
        addToCompBtn.innerText = "In Comparison List";
        addToCompBtn.setAttribute("disabled", true);
    }
    else{
        addToCompBtn.addEventListener("click", (e) => {
            addToComp(mobile_id);
            addToCompBtn.innerText = "In Comparison List";
            addToCompBtn.setAttribute("disabled", true);
        });
    }

    var myRater = window.rater({element: document.querySelector("#mobile-rating"), starSize: 20});
    myRater.setRating( parseFloat( parseFloat(myRater.element.dataset.rating).toFixed(1)) );
    myRater.disable();

    const userReviewRate = document.querySelectorAll(".review-rating");
    var userReviewRateList = [];
    userReviewRate.forEach(rate => {
        let newRater = window.rater({element: rate, starSize: 14});
        newRater.setRating( parseFloat( parseFloat(newRater.element.dataset.rating).toFixed(1)) );
        newRater.disable();
        userReviewRateList.push(newRater);
    });

    const input = document.getElementById("given_star_input");
    var formRater = window.rater(
        {
            element: document.getElementById("given_star"),
            starSize: 20,
            rateCallback: function rateCallback(rating, done) {
                formRater.setRating(rating);
                input.setAttribute("value", rating);
                done();
            }
        }
    );

    const error = document.getElementById("review-error");

    function handleReviewForm(){
        let description = document.getElementById("description").value.trim();
        let given_star_input = input.value;
        error.classList.remove("d-block");
        if(!description && description.length < 20){
            error.classList.add("d-block");
            error.innerText = "Must enter upto 20 characters for review";
            return false;
        }
        if(given_star_input < 1){
            error.classList.add("d-block");
            error.innerText = "Give at least 1 star";
            return false;
        }
        return true;
    }
</script>
@endpush
