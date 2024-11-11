@extends('frontend.layout.app')

@section('main-content')
    @include('frontend.pages.navbar_without_slider')

    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <!-- Product Images Carousel -->
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        @foreach($single_product_data['gallery'] as $index => $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="w-100" style="height: 450px" src="{{ asset('images/galleries/' . $image) }}" alt="{{ $single_product_data['title'] }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $single_product_data['title'] }}</h3>
                
                <h5 class=" mb-4"> Price:  {{ $single_product_data['price'] }} TK</h5>
                <h5 class=" mb-4" style="color: rebeccapurple"> Discount:  {{ $single_product_data['discount'] ?? 0 }} TK</h5>
                <h5 class=" mb-4 total_value"> Total:  {{ $single_product_data['discount_price'] }} TK</h5>
                <input type="hidden" id="total_value_hidden" value="{{ $single_product_data['discount_price'] }}">

                @if (!empty($single_product_data['size']))
                    <div class="d-flex mb-3">
                        <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                        <form>
                            @foreach (json_decode($single_product_data['size']) as $index => $size)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="size-{{ $index }}" name="size" value="{{ $size }}">
                                    <label class="custom-control-label" for="size-{{ $index }}">{{ size_name($size) }}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                @endif
                
                <!-- Quantity input -->
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus"><i class="fa fa-minus"></i></button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" id="qty"  value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart and Order Now buttons -->
                <div class="d-flex align-items-center mb-4 pt-2">
                    <button class="btn btn-primary px-3 add-to-cart-btn" id="add_cart_btn" data-id="{{ $single_product_data['id'] }}">
                        <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                    </button> &nbsp;
                    <button class="btn btn-order px-3 order-now-btn" id="order_now_btn" data-id="{{ $single_product_data['id'] }}">
                        <i class="fa fa-receipt mr-1"></i> Order Now
                    </button>
                </div>

                <div class="mt-md-5 custom-phone">
                    <h4>ফোনে অর্ডারের জন্য ডায়াল করুন</h4>
                    <h4 class="font-weight-bold ml-4">
                        <a href="tel:01784116079">
                            <i class="fa fa-phone-square"></i>
                            {{ $company_info->company_phone }}
                        </a>
                    </h4>
                </div>

                <div class="col-12 mt-3 delivery_details" style="padding: 0">
                    <table class="table" style="color:#08c !important">
                        <tbody>
                            @foreach ($delivery_charge as $item)
                            <tr class="ml-2">
                                <td style="padding-left: 0; border-bottom: 1px solid #ddd; padding-left:10px;">
                                    {{ $item->name_bn }}
                                </td>
                                <td style="border-bottom: 1px solid #ddd;">
                                    <b>{{ $item->charge }}</b>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                </div>
                <div class="tab-content tab-content-mod">
                    <div class="tab-pane active">
                        <div>
                            {!! $single_product_data['description'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- You May Also Like Section -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @if (!empty($related_product))
                        @foreach ($related_product as $product)
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img style="height:250px" class="img-fluid w-100" src="{{asset('images/galleries/'.$product['thumbnail'])}}" alt="{{ $product['title'] }}">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{ $product['title'] }}</h6>
                                    <div class="d-flex justify-content-center">
                                        @if ($product['discount_price'] < $product['price'])
                                            <h6>{{ $product['discount_price'] }}</h6><h6 class="text-muted ml-2"><del>{{ $product['price'] }}</del></h6>
                                        @else
                                            <h6>{{ $product['price'] }}</h6>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="{{ route('frontend.single.product.page', $product['id']) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                    <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h2 style="text-align: center">No product found</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle quantity changes
        $('.quantity button').on('click', function() {
            var button = $(this);
            var input = button.parent().parent().find('input');
            var oldValue = input.val();
            var discountPrice = {{ $single_product_data['discount_price'] }};
            var newVal = oldValue;

            if (button.hasClass('btn-plus')) {
                newVal = parseFloat(oldValue) + 1;
            } else {
                if (oldValue > 1) {
                    newVal = parseFloat(oldValue) - 1;
                }
            }

            input.val(newVal);
            var totalValue = discountPrice * newVal;
            $('.total_value').text('Total: ' + totalValue + ' TK');
            $('#total_value_hidden').val(totalValue);
        });

        // Handle Add to Cart action
        $('#add_cart_btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            var qty = $('#qty').val();
            var total_value_hidden = $('#total_value_hidden').val();
            var selectedSize = $('input[name="size"]:checked').val();
            
            if (!selectedSize) {
                var size = null;
            }else{
                var size =selectedSize;
            }
           
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    qty: qty,
                    size: size,
                    total_value_hidden: total_value_hidden,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Product added to cart successfully!');

                       
                        $('#cart_count').text(response.cart_count);

                       
                    } else if (response.already_in_cart) {
                        alert('Product is already in the cart.');
                    } else {
                        alert('Failed to add product to cart: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Failed to add product to cart.');
                }
            });
        });

        $('#order_now_btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            var qty = $('#qty').val();
            var total_value_hidden = $('#total_value_hidden').val();
            var selectedSize = $('input[name="size"]:checked').val();
           
            if (!selectedSize) {
                var size = null;
            }else{
                var size =selectedSize;
            }
           
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    qty: qty,
                    size: size,
                    total_value_hidden: total_value_hidden,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                            
                        $('#cart_count').text(response.cart_count);
                        window.location.href = "{{ route('shop.checkout') }}";

                    
                    } else if (response.already_in_cart) {
                        window.location.href = "{{ route('shop.checkout') }}";
                    } else {
                        alert('Something went wrong.');
                    }
                },
                error: function(xhr) {
                    alert('Failed to add product to cart.');
                }
            });
        });

        
    });
</script>
@endsection
