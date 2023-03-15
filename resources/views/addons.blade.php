@extends('theme.default')

@section('content')
<style type="text/css">
    .pac-container {
    z-index: 10000 !important;
}
</style>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Addons</a></li>
        </ol>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAddons" data-whatever="@addAddons">Add Addons</button>

        <!-- Add Addons -->
        <div class="modal fade" id="addAddons" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Addons</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="add_addons" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <div class="form-group">
                            <label for="cat_id" class="col-form-label">Category:</label>
                            <select name="cat_id" class="form-control" id="cat_id">
                                <option value="">Select Category</option>
                                <?php
                                foreach ($getcategory as $category) {
                                ?>
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item_id" class="col-form-label">Item:</label>
                            <select name="item_id" class="form-control" id="item_id">
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Addons Name:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Addons Name">
                        </div>
                        <div class="form-group">
                            <label class="radio-inline mr-3">
                                <input type="radio" name="type" id="type" value="free" checked="true" onChange="getValue(this)"> Free</label>
                            <label class="radio-inline mr-3">
                                <input type="radio" name="type" id="type" value="paid" onChange="getValue(this)"> Paid</label>
                            <label class="radio-inline">
                        </div>

                        <div class="form-group" id="paid" style="display:none">
                            <label for="price" class="col-form-label">Price:</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="Price">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Addons -->
        <div class="modal fade" id="EditAddons" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="editaddons" class="editaddons" id="editaddons" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabeledit">Edit Addons</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <span id="emsg"></span>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="id" name="id">
                            <div class="form-group">
                                <label for="getcat_id" class="col-form-label">Category:</label>
                                <select name="cat_id" class="form-control" id="getcat_id">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($getcategory as $category) {
                                    ?>
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="item_id" class="col-form-label">Item:</label>
                                <select name="item_id" class="form-control" id="getitem_id">
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="getname" class="col-form-label">Addons Name:</label>
                                <input type="text" class="form-control" name="name" id="getname" placeholder="Addons Name">
                            </div>

                            <div class="form-group">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="type" id="type" value="free" checked="true" onChange="getValue(this)"> Free</label>
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="type" id="type" value="paid" onChange="getValue(this)"> Paid</label>
                                <label class="radio-inline">
                            </div>

                            <div class="form-group" id="paid">
                                <label for="getprice" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" name="price" id="getprice" placeholder="Price">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btna-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Addons</h4>
                    <div class="table-responsive" id="table-display">
                        @include('theme.addonstable');
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
     
    $('#add_addons').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $.ajax({
            url:"{{ URL::to('admin/addons/store') }}",
            method:"POST",
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                var msg = ''; 
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#msg').html(msg);
                    setTimeout(function(){
                      $('#msg').html('');
                    }, 5000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    AddonsTable();
                    $('#message').html(msg);
                    $("#addAddons").modal('hide');
                    $("#add_addons")[0].reset();
                    setTimeout(function(){
                      $('#message').html('');
                    }, 5000);
                }
            },
        })
    });

    $('#editaddons').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $.ajax({
            url:"{{ URL::to('admin/addons/update') }}",
            method:'POST',
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#emsg').html(msg);
                    setTimeout(function(){
                      $('#emsg').html('');
                    }, 5000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    AddonsTable();
                    $('#message').html(msg);
                    $("#EditAddons").modal('hide');
                    $("#editaddons")[0].reset();
                    setTimeout(function(){
                      $('#message').html('');
                      location.reload();
                    }, 1000);
                }
            },
        });
    });

    $('#cat_id').change(function()
    {
        var cat_id=$('#cat_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:"{{ URL::to('admin/addons/getitem') }}",
            data:{      
            'cat_id':cat_id
            },
            dataType: "json",
            success: function(response) {
                let html ='';
                for(i in response){              
                    html+='<option value="'+response[i].id+'">'+response[i].item_name+'</option>'
                }
                $('#item_id').html(html);
            },
        });
    });
    $('#getcat_id').change(function()
        {
            var cat_id=$('#getcat_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:"{{ URL::to('admin/addons/getitem') }}",
                data:{      
                'cat_id':cat_id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response.length);
                    let html ='';
                    for(i in response){              
                        html+='<option value="'+response[i].id+'">'+response[i].item_name+'</option>'
                    }
                    $('#getitem_id').html(html);
                },
            });
        });
});
function GetData(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/addons/show') }}",
        data: {
            id: id
        },
        method: 'POST', //Post method,
        dataType: 'json',
        success: function(response) {
            jQuery("#EditAddons").modal('show');
            $('#id').val(response.ResponseData.id);
            $('#getcat_id').val(response.ResponseData.cat_id);
            $('#getitem_id').val(response.ResponseData.item_id);
            $('#getname').val(response.ResponseData.name);
            $('#getprice').val(response.ResponseData.price);
            if (response.ResponseData.price == "0") {
                $("input[name=type][value=free]").attr('checked', 'checked');
            } else {
                $("input[name=type][value=paid]").attr('checked', 'checked');
            }
            let html ='';
            for(i in response.item){ 
                let select=(response.item[i].id==response.ResponseData.item_id)? 'selected' : '' ;             
                html+='<option value="'+response.item[i].id+'" '+select+' >'+response.item[i].item_name+'</option>'
            }
            $('#getitem_id').html(html);
        },
        error: function(error) {
        }
    })
}
function StatusUpdate(id,status) {
    // dd(id);
    swal({
        title: "Are you sure?",
        text: "Do you want to change status of this addons?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, change it!",
        cancelButtonText: "No, cancel plz!",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('admin/addons/status') }}",
                data: {
                    id: id,
                    status: status
                },
                method: 'POST',
                success: function(response) {
                    if (response == 1) {
                        swal({
                            title: "Approved!",
                            text: "Category status has been changed.",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                swal.close();
                                AddonsTable();
                            }
                        });
                    } else {
                        swal("Cancelled", "Something Went Wrong :(", "error");
                    }
                },
                error: function(e) {
                    swal("Cancelled", "Something Went Wrong :(", "error");
                }
            });
        } else {
            swal("Cancelled", "Your record is safe :)", "error");
        }
    });
}

function getValue(x) {
  if(x.value == 'free'){
    document.getElementById("paid").style.display = 'none'; // you need a identifier for changes
  }
  else{
    document.getElementById("paid").style.display = 'block';  // you need a identifier for changes
  }
}

function AddonsTable() {
    $.ajax({
        url:"{{ URL::to('admin/addons/list') }}",
        method:'get',
        success:function(data){
            $('#table-display').html(data);
            $(".zero-configuration").DataTable()
        }
    });
}
 $(document).ready(function() {
     var imagesPreview = function(input, placeToInsertImagePreview) {
          if (input.files) {
              var filesAmount = input.files.length;
              $('div.gallery').html('');
              var n=0;
              for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.onload = function(event) {
                       $($.parseHTML('<div>')).attr('class', 'imgdiv').attr('id','img_'+n).html('<img src="'+event.target.result+'" class="img-fluid"><span id="remove_"'+n+' onclick="removeimg('+n+')">&#x2716;</span>').appendTo(placeToInsertImagePreview); 
                      n++;
                  }
                  reader.readAsDataURL(input.files[i]);                                  
             }
          }
      };

     $('#file').on('change', function() {
         imagesPreview(this, 'div.gallery');
     });
 
});
var images = [];
function removeimg(id){
    images.push(id);
    $("#img_"+id).remove();
    $('#remove_'+id).remove();
    $('#removeimg').val(images.join(","));
}
</script>
@endsection