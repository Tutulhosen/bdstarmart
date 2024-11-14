@extends('frontend.layout.app')

@section('main-content')
    @include('frontend.pages.navbar_without_slider')

    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            @if (!empty($cart))
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Products</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach($cart as $key => $item)
                            <?php 
                                $product=DB::table('products')->where('id', $item['product_id'])->first();
                            ?>
                                <tr>
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="" style="text-align: left ">
                                        <img src="{{ asset('images/galleries/' . $item['image']) }}" alt="" style="width: 50px;"> 
                                    </td>
                                    <td class="align-middle"> {{ $item['title'] }}</td>
                                    <td class="align-middle">{{ $item['price']-$item['discount'] }}</td>
                                    @if (!empty($product->size))
                                        
                                        <td class="align-middle">
                                            @php
                                                $sizes = json_decode($product->size); 
                                            @endphp
                                            <select name="size" class="size-selector" data-id="{{ $key }}">
                                                <option value="">--select--</option>
                                                @foreach (json_decode($sizes) as $size)
                                                    <?php 
                                                        if ($size== $item['size']) {
                                                            echo $selected='selected';
                                                        } else {
                                                            echo $selected=' ';
                                                        }
                                                        
                                                    ?>
                                                    <option value="{{$size}}" {{$selected}}>{{size_name($size)}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    
                                    @else
                                        <td class="align-middle"></td>
                                    @endif
                                    
                                    
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus" data-id="{{ $key }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary text-center product-quantity" value="{{ $item['qty'] }}" data-id="{{ $key }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus" data-id="{{ $key }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle total-price" data-id="{{ $key }}">{{ $item['total_price'] }} TK</td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-primary btn-remove" data-id="{{ $key }}"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                        </div>
                        
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold"> SubTotal</h5>
                                <h5 class="font-weight-bold" id="sub-total">{{ $sub_total }} TK</h5>
                            </div>
                            <a href="{{route('checkout.page')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            @else
            
            <section style="margin:auto; text-align:center">
                <div class="cart-section">
                    <div class="container">
                        <h3>Your cart is empty</h3>
                        <a href="{{route('home')}}" class="btn btn-primary" style="margin-top: 15px; border-radius:5px">Continue Shopping</a>
                    </div>
                </div>
            </section>
            
              
            @endif
            
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Quantity increase
            $('.btn-plus').click(function() {
                var id = $(this).data('id');
                updateQuantity(id, 1);
            });

            // Quantity decrease
            $('.btn-minus').click(function() {
                var id = $(this).data('id');
                updateQuantity(id, -1);
            });

            // Remove item from cart
            $('.btn-remove').click(function() {
                var id = $(this).data('id');
                removeItem(id);
            });

            // Update quantity function
            function updateQuantity(id, change) {
                var input = $('input[data-id="' + id + '"]');
                var newQty = parseInt(input.val()) + change;
                if (newQty < 1) newQty = 1; 
                input.val(newQty);

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        qty: newQty
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update total price for the specific item
                            $('.total-price[data-id="' + id + '"]').text( response.item_total_price + ' TK');

                            // Update subtotal
                            $('#sub-total').text( response.sub_total + ' TK');
                        }
                    }
                });
            }

            $('.size-selector').change(function() {
                var id = $(this).data('id'); 
                var selectedSize = $(this).val(); 
            
                $.ajax({
                    url: "{{ route('cart.updateSize') }}", 
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        size: selectedSize
                    },
                    success: function(response) {
                        if (response.success) {
                            // Toastr success notification
                            toastr.success('Size updated successfully!', 'Success', {
                                closeButton: true, // Adds the close (X) button
                                progressBar: true, // Shows the progress bar
                                positionClass: "toast-top-right", // Sets the position at the top right
                                timeOut: 3000, // Auto-closes after 3 seconds
                                extendedTimeOut: 1000
                            });
                        } else {
                            // Toastr error notification
                            toastr.error('Failed to update size.', 'Error', {
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                timeOut: 3000
                            });
                        }
                    },
                    error: function() {
                        // Toastr error notification in case of a server error
                        toastr.error('Something went wrong. Please try again.', 'Error', {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 3000
                        });
                    }
                });
            });


            
            // Remove item function
            function removeItem(id) {
                $.ajax({
                    url: "{{ route('cart.remove') }}", 
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove the row from the table
                            $('button[data-id="' + id + '"]').closest('tr').remove();

                            // Update the subtotal
                            $('#sub-total').text(response.sub_total + ' TK');

                            // Update the cart count
                            $('#cart_count').text(response.cart_count);

                            // If the cart is empty, redirect or show the empty cart message
                            if (response.cart_count === 0) {
                                window.location.href = "{{ route('shop.checkout') }}";
                            }
                        }
                    }
                });
            }

        });

    </script>
@endsection
