<?php 
    $facebook= DB::table('social_link')->where('title', 'Facebook')->where('status', 1)->first();
    $twitter= DB::table('social_link')->where('title', 'twitter')->where('status', 1)->first();
    $youtube= DB::table('social_link')->where('title', 'Youtube')->where('status', 1)->first();
    $instagram= DB::table('social_link')->where('title', 'Instagram')->where('status', 1)->first();
    $logo= DB::table('logo')->where('status', 1)->first();
    $admin= DB::table('users')->where('role_id', 1)->first();
?>
<div class="container-fluid">
    {{-- <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="">FAQs</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Help</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Support</a>
            </div>
            <p style="font-weight: bolder; color:#D19C97">Your One-Stop Shop for Everyday Essentials</p>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div> --}}
    <div class="row align-items-center py-3 px-xl-5">
        <div class="logo text-center">
            @if (!empty($logo))
                @if ($logo->image)
                <a href="{{route('home')}}"><img src="{{asset('images/logo/' . $logo->image)}}" alt="" class="logo-img"></a>
                @else
                <a href="{{route('home')}}"><img src="{{asset('frontend/uploads/6649146b6febe.png')}}" alt="" class="logo-img"></a>
                @endif
            @else
                <a href="{{route('home')}}"><img src="{{asset('frontend/uploads/6649146b6febe.png')}}" alt="" class="logo-img"></a>
            @endif
        </div>
        
        <div class="col-lg-6 col-6 text-left">
            <form id="searchForm" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products" id="searchQuery">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                          {{-- <i class="fa fa-search"></i> --}}
                            <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-6 text-right">
            <a href="{{route('shop.checkout')}}" class="btn border" id="add_to_cart">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge" id="cart_count">0</span> 
            </a>
        </div>
        
    </div>
</div>

@section('scripts')
    <script>

    </script>
@endsection