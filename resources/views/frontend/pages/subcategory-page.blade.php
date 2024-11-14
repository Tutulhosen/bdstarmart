@extends('frontend.layout.app')

@section('main-content')

@include('frontend.pages.navbar_without_slider')
@if (!empty($products))
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
    </div>
    <div class="row px-xl-5 pb-3 h-30" >
        @foreach ($products as $product)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img style="height:250px" class="img-fluid w-100" src="{{asset('images/galleries/'.$product['thumbnail'])}}" alt="{{ $product['title'] }}">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $product['title'] }}</h6>
                        <div class="d-flex justify-content-center">
                            @if ($product['discount_price'] < $product['price'])
                                <h6>{{$product['discount_price']}}</h6><h6 class="text-muted ml-2"><del>{{$product['price']}}</del></h6>
                            @else
                                <h6>{{$product['price']}}</h6>
                            @endif
                            
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('frontend.single.product.page', $product['id'])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        
                        <button class="btn btn-sm text-dark p-0 order_now_btn_direct"   data-price="{{ $product['price']-$product['discount'] }}" data-id="{{ $product['id'] }}">
                            <i class="fa fa-receipt mr-1 text-success"></i> Order Now
                        </button>
                        
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
           
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <div>
                        {!! $pagination->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
            
         
        </div>
        <div class="col-4"></div>
    </div>
       

</div>
@else
    <div class="row">
        <div class="col-12 text-center pt-5">
            <h2 class="text-center">কোনো পণ্য পাওয়া যায়নি।</h2> 
        </div>
    </div>
@endif

@endsection