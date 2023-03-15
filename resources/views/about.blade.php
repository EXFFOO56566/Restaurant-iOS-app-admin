
@extends('theme.default')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">About</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <span id="msg"></span>
                    <h4 class="card-title">About</h4>
                    <p class="text-muted"><code></code>
                    </p>
                    <div id="privacy-policy-three" class="privacy-policy">
                        <form method="post" name="about" id="about" enctype="multipart/form-data">
                            @csrf
                            <textarea class="form-control" id="ckeditor" name="about">{{$getabout->about_content}}</textarea>
                            <div class="form-group">
                                <label for="image" class="col-form-label">About Image:</label>
                                <input type="file" class="form-control" name="image" id="image">
                                <input type="hidden" name="removeimg" id="removeimg">
                                <img src='{!! asset("public/images/about/".$getabout->image) !!}' class='img-fluid mt-3' style='max-height: 150px;'>
                            </div>
                            <div class="gallery"></div>
                            <hr>
                            <p>Footer Settings</p>
                            <div class="form-group">
                                <label for="fb" class="col-form-label">Facebook Link:</label>
                                <input type="text" class="form-control" name="fb" id="fb" value="{{$getabout->fb}}">
                            </div>
                            <div class="form-group">
                                <label for="twitter" class="col-form-label">Twitter Link:</label>
                                <input type="text" class="form-control" name="twitter" id="twitter" value="{{$getabout->twitter}}">
                            </div>
                            <div class="form-group">
                                <label for="insta" class="col-form-label">Instagram Link:</label>
                                <input type="text" class="form-control" name="insta" id="insta" value="{{$getabout->insta}}">
                            </div>
                            <div class="form-group">
                                <label for="android" class="col-form-label">Android App Link:</label>
                                <input type="text" class="form-control" name="android" id="android" value="{{$getabout->android}}">
                            </div>
                            <div class="form-group">
                                <label for="ios" class="col-form-label">iOS App Link:</label>
                                <input type="text" class="form-control" name="ios" id="ios" value="{{$getabout->ios}}">
                            </div>

                            <div class="form-group">
                                <label for="copyright" class="col-form-label">Copyright:</label>
                                <input type="text" class="form-control" name="copyright" id="copyright" value="{{$getabout->copyright}}">
                            </div>
                            <hr>
                            <p>Contacts Settings</p>
                            <div class="form-group">
                                <label for="mobile" class="col-form-label">Mobile:</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" value="{{$getabout->mobile}}">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{$getabout->email}}">
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-form-label">Address:</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{$getabout->address}}">
                            </div>
                            <button type="submit" name="update" class="btn mb-1 btn-primary mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('ckeditor');
</script>
<script type="text/javascript">
$(document).ready(function() {

    $('#about').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $.ajax({
            url:"{{ URL::to('admin/about/update') }}",
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
                    $('.gallery').html('');
                    $('.image').val('');
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#msg').html(msg);
                    $(window).scrollTop(0);
                    setTimeout(function(){
                      $('#msg').html('');
                    }, 5000);
                }
            },
        })
    });
});

$(document).ready(function() {
var imagesPreview = function(input, placeToInsertImagePreview) {
    if (input.files) {
        var filesAmount = input.files.length;
        $('.gallery').html('');
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

 $('#image').on('change', function() {
    imagesPreview(this, '.gallery');
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