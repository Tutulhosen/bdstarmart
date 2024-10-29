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
                                <h3 class="text-center">Update Sub Category</h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Sub Category Name</label>
                                    <input type="text" class="form-control" id="name" value="{{$sub_category_info->name}}" placeholder="Username">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="category"> Category </label>
                                    <select name="category" id="category" class="form-control">
                                        @foreach ($category_list as $item)
                                            <?php
                                                if ($sub_category_info->category_id==$item->id) {
                                                    $selected= 'selected';
                                                } else {
                                                    $selected='';
                                                }
                                                
                                            ?>
                                            <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <button type="button" class="btn btn-success mr-2" id="cat_update_btn" value="{{$sub_category_info->id}}">Submit</button>
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
        
        $('#cat_update_btn').on('click', function(){
        let name = $('#name').val();
        let category = $('#category').val();
        let id = $(this).val();
       
        

        if (name == '') {
            showToast('Enter A Category Name', 'error');
            return; 
        }

        

        let formData = new FormData();
        formData.append('name', name);
        formData.append('category', category);
        formData.append('id', id);
        formData.append('_token', '{{ csrf_token() }}'); 

        $.ajax({
            url: '{{ route('admin.sub.cat.update') }}', 
            method: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
                if (response.status==true) {
                    
                    showToast(response.success, 'success');
                    setTimeout(function() {
                        // Redirect to the list page
                        window.location.href = '/admin/sub/cat/list';  
                    }, 1500);
                    
                }
                if (response.status==false) {
                    
                    showToast(response.error, 'success');
                    
                }
                
            },
            
        });
    });





    });

</script>

@endsection



