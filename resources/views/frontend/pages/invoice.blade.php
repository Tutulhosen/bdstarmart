
@extends('frontend.layout.app')

@section('main-content')
<section>
    
    <section class="py-md-5">
        <div class="cart-section">
            <div class="container">
                <div class="row py-md-5">
                    <div class="col-12 text-center">
                        <h1 class="mb-md-4" style="color: green;font-weight: bold">Order Place Successfully</h1>
                        <p style="color: green">আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে আমাদের কল সেন্টার থেকে ফোন করে আপনার অর্ডারটি কনফার্ম করা হবে</p>
                        <a href="{{route('home')}}" class="btn btn-success px-5" style="background-color: green">প্রোডাক্ট বাছাই করুন</a>
                    </div>
                </div>
            </div>
        </div>
    
    
    
</section>
@endsection



