@extends('frontend.layout.app')

@section('main-content')
    @include('frontend.pages.navbar_without_slider')

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="card">
                    <h5 class="font-weight-bold card-header">কাস্টমার ইনফরমেশন</h5>
                    <div class="card-body p-2">
                        <p class="text-center">অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে <span class="text-danger">অর্ডার কনফার্ম করুন</span> বাটনে ক্লিক করুন</p>
                        <form action="{{ route('checkout') }}" method="post" id="checkout_form" class="checkout_form">
                            @csrf
                            <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                            <input type="hidden" name="total_price_sum" id="total_price_sum" value="0">
                            
                            

                            <div class="form-group">
                                <label for="full_name">আপনার নাম <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="আপনার নাম লিখুন" required="">
                            </div>

                            <div class="form-group">
                                <label for="customer_phone">আপনার মোবাইল <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_phone" name="phone_number" placeholder="আপনার মোবাইল লিখুন" minlength="11" required="">
                            </div>

                            <div class="form-group">
                                <label for="customer_address">আপনার ঠিকানা <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="customer_address" name="delivery_address" placeholder="আপনার ঠিকানা লিখুন" required=""></textarea>
                            </div>

                            <div class="form-group">
                                <label for="shipping_method">আপনার এরিয়া সিলেক্ট করুন <span class="text-danger">*</span></label>
                                <select name="shipping_method" id="shipping_method" class="form-control" required="">
                                    <option value="">--এরিয়া সিলেক্ট করুন--</option>
                                    @foreach ($delivery_charge as $item)
                                        <option value="{{$item->charge}}">{{$item->name_bn}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-2" style="height: 50px" id="conf_order_btn">অর্ডার কনফার্ম করুন</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        @foreach ($cart as $item)
                            <div class="d-flex justify-content-between">
                                <p>{{$item['title']}} (Qty: {{$item['qty']}}
                                    @if ($item['size'])
                                       , size: {{size_name($item['size'])}}
                                    @endif)
                                </p>
                                <p>{{$item['total_price']}} TK</p>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Charge:</h6>
                            <h6 class="font-weight-medium " id="delivery_charge_display">0 TK</h6>
                        </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="final_total">0 TK</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
@endsection

@section('scripts')
<script>
    // Calculate the total sum of all products
    let totalSum = 0;
    @foreach ($cart as $item)
        totalSum += parseFloat({{ $item['total_price'] }});
    @endforeach
    document.getElementById('total_price_sum').value = totalSum;

    // Display initial total
    document.getElementById('final_total').innerText = totalSum + ' TK';

    // Handle the shipping method selection
    document.getElementById('shipping_method').addEventListener('change', function() {
        let shippingCost = parseFloat(this.value);
        document.getElementById('shipping_cost').value = shippingCost;

        // Update delivery charge in the view
        document.getElementById('delivery_charge_display').innerText = shippingCost + ' TK';

        // Calculate the final total
        let finalTotal = totalSum + shippingCost;
        document.getElementById('final_total').innerText = finalTotal + ' TK';
    });
    $(document).ready(function(){
        $('#checkout_form').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally
               
                 // Gather form data
                let formData = $(this).serialize();
                
            
                
                // AJAX request
                $.ajax({
                    url: '{{ route("checkout") }}', 
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val() 
                    },
                    success: function(response) {
                        // Clear localStorage
                        localStorage.clear();

                        // Show Toastr success notification with a cancel button
                        toastr.options = {
                            "closeButton": true, // Adds the close (X) button
                            "progressBar": true, // Progress bar at the bottom
                            "positionClass": "toast-top-right", // Position of the toaster
                            "onclick": null, // No click handler
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000", // Auto-close after 5 seconds
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut",
                        };

                        // Display success message with a cancel button
                        toastr.success('Order placed successfully!', 'Success', {
                            closeButton: true,
                            tapToDismiss: false, // Disables auto-dismiss when clicked
                            timeOut: 0, // Ensures the toast doesn't disappear automatically
                            extendedTimeOut: 0, // Keeps it until user manually closes
                            onclick: function() {
                                toastr.clear(); // Optional: dismiss toaster on click
                            }
                        });

                        setTimeout(function() {
                            if (response.isCustomerlogin==true) {
                                window.location.href = '{{ route("user.profile") }}';
                            } else {
                                let id =response.id;
                                window.location.href = '{{ route("product.invoice") }}';
                            }
                        }, 3000);
                    },
                    error: function(response) {
                        // Handle validation errors or other errors
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                alert(value); // Display error messages (customize as needed)
                            });
                        } else {
                            alert('Something went wrong, please try again.');
                        }
                    }
                });
            });
    })
</script>
@endsection
