<?php
    $logo= DB::table('logo')->where('status', 1)->first();
    $admin= DB::table('users')->where('role_id', 1)->first();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- toster link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    {{-- sweet alert link  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link rel="shortcut icon" href="{{asset('logo-icon.png')}}" />
    <style>
        body {
            background-color: #f5f7fa; /* Soft background color */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; /* Focused card color */
        }
        .card-header img {
            display: block;
            margin: 0 auto;
            width: 80px;
            height: 80px;
        }
        .form-label {
            text-align: left; /* Align label to the left */
        }
    </style>
</head>
<body>

    <div class="card p-4" style="max-width: 400px; width: 100%;">
        <div class="card-header text-center">
            <!-- Logo Image -->
            @if (!empty($logo))
            <img src="{{asset('images/logo/' . $logo->image)}}" alt="" style="width: 80px; ">
                
            @endif
        </div>
        <div class="card-body">
            <h4 class="card-title mb-4 text-center">Login</h4>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="input_user" class="form-control input_user" id="input_user" placeholder="Enter email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control input_pass" name="input_pass" id="input_pass" placeholder="Enter password">
                </div>
                <div class="d-grid">
                    <button type="button" class="btn btn-primary login_btn">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- jQuery (necessary for Toastr) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    // Function to show a Toastr alert
    function showToast(message, type) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            showMethod: 'slideDown',
            timeOut: 3000 // 3 seconds
        };

        // Type can be 'success', 'info', 'warning', or 'error'
        toastr[type](message);
    }
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $('.login_btn').on('click', function(){
            var email= $('.input_user').val();
            var password= $('.input_pass').val();
            if (email == '') {
                showToast('Enter Your Email', 'error');
                return; 
            }

            if (password == '') {
                showToast('Enter Your Password', 'error');
                return; 
            }

            let formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.loged_in') }}', 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    if (response.status==true) {
                        showToast(response.message, 'success');
                        location.href = "{{route('admin.dashboard.index')}}"
                    }
                    if (response.status==false) {
                        
                        showToast(response.message, 'error');
                        
                    }
                    
                },
                
            });
        })
    });
</script>