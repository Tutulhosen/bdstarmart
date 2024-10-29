@extends('admin.layout.app')


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="headline">
                                <h3 class="text-center">Create  New </h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                <div class="form-group">
                                    <label for="size">Size </label>
                                    <input type="text" class="form-control" id="size" placeholder="Size">
                                </div>
                                <br>
                                
                                
                                <button type="button" class="btn btn-success mr-2" id="subnit_btn">Submit</button>
                                <button class="btn btn-dark">Cancel</button>
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    

<script>
    

    $(document).ready(function(){
        
        $('#subnit_btn').on('click', function(){
            let size = $('#size').val();
           
                // alert(name);
            if (size == '') {
                showToast('Enter A Size', 'error');
                return; 
            }


            let formData = new FormData();
            formData.append('size', size);
           
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.size.store') }}', 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    if (response.status==true) {
                        
                        showToast(response.success, 'success');
                        setTimeout(function() {
                            // Redirect to the list page
                            window.location.href = '/admin/size/list';  
                        }, 1500);
                        
                    }
                    
                },
                
            });
        });


    });

</script>

@endsection



