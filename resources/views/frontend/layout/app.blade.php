<?php 
    $meta=DB::table('meta')->where('status', 1)->first();
    $user=DB::table('users')->where('role_id', 1)->first();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BDSTARMART</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{asset('bdstarmart/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('bdstarmart/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('bdstarmart/css//style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    @include('frontend.layout.top-header')
    <!-- Topbar End -->


   

    @section('main-content')
        
    @show

    <!-- Footer Start -->
    @include('frontend.layout.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('bdstarmart/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('bdstarmart/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{asset('bdstarmart/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{asset('bdstarmart/mail/contact.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('bdstarmart/js/main.js')}}"></script>
</body>

</html>
