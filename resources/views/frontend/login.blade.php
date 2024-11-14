@extends('frontend.layout.app')

@section('main-content')
@include('frontend.pages.navbar_without_slider')
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="login-section">
                        <div class="login-container">
                
                            <h2>Login</h2>
                            <form action="{{route('frontend.customer.login')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Phone or Email</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Phone or Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                            
                                    {{-- <div style="display: flex; align-items: center;">
                
                                        <input type="checkbox" id="remember" name="remember" style="margin-right: 10px;margin-top: 7px;">
                                        <label for="remember">Remember Me</label>
                                    </div> --}}
                                
                                <div style="text-align: center;">
                                    <button class="btn btn-success" type="submit">Login</button>
                                </div>
                            </form><br>
                            <p>
                                Don't have an account yet? <a href="{{route('frontend.register')}}">Sign Up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
       

</div>
@endsection