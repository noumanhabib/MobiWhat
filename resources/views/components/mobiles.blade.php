<div class="mobile-card mobile-list">
    <img src="{{asset("storage" . $mobile->cover)}}" alt="Mobile image">
    <div class="mobile-card-body">
        <p class="title">{{$mobile->name}}</p>
        <p class="brand text-capitalize">{{$mobile->brand->name}}</p>
        <p class="price">{{$mobile->price}} PKR</p>
        <p class="mobile-specs">
            <span class="badge badge-primary">{{$mobile->ram}}GB Ram</span>
            <span class="badge badge-dark">{{$mobile->storage}}GB Storage</span>
            <span class="badge badge-success">{{$mobile->battery_capacity}} mah Battery</span>
        </p>
    </div>
    <div class="mobile-right-specs">
        <div class="expand-icon">
            <i class="far fa-heart pr-3 fav-icon-i"></i>
            <i class="fa fa-expand"></i>
        </div>
        <span class="badge badge-info">{{$mobile->os}}</span>
        <br />
        @if($mobile["4g"])
        4G LTE
        @elseif ($mobile["3g"])
        3G
        @elseif ($mobile["2g"])
        2G
        @else
        1G
        @endif
        <br />
        {{$mobile->screen_size}}" Display <br />
        {{$mobile->camera_main}}MP Back Camera <br />
        {{$mobile->camera_front}}MP Front Camera
    </div>
    <a href="/mobile/{{$mobile->id}}" class="overlay"></a>
    <input type="hidden" value="{{$mobile->id}}" class="forMobileId">
</div>
