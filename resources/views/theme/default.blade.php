<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('public/assets/images/favicon.png') !!}">
    <!-- Pignose Calender -->
    <link href="{!! asset('public/assets/plugins/pg-calendar/css/pignose.calendar.min.css') !!}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{!! asset('public/assets/plugins/chartist/css/chartist.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') !!}">

    <link href="{!! asset('public/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') !!}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{!! asset('public/assets/plugins/sweetalert/css/sweetalert.css') !!}" rel="stylesheet">
    <link href="{!! asset('public/assets/css/style.css') !!}" rel="stylesheet">

</head>
<style type="text/css">
    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
</style>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div id="main-wrapper">

        @include('theme.header')
        @include('theme.sidebar')
        <div class="content-body">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->
        <div class="card-content collapse show">
          <div class="card-body">
            <div class="row my-2">
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                  <!-- Modal Change Password-->
                  <div class="modal fade text-left" id="ChangePasswordModal" tabindex="-1" role="dialog" aria-labelledby="RditProduct"
                  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <label class="modal-title text-text-bold-600" id="RditProduct">Change Password</label>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id="errors" style="color: red;"></div>
                        
                        <form method="post" id="change_password_form">
                        {{csrf_field()}}
                          <div class="modal-body">
                            <label>Old Passwod: </label>
                            <div class="form-group">
                                <input type="password" placeholder="Enter Old Password" class="form-control" name="oldpassword" id="oldpassword">
                            </div>

                            <label>New Password: </label>
                            <div class="form-group">
                                <input type="password" placeholder="Enter New Password" class="form-control" name="newpassword" id="newpassword">
                            </div>

                            <label>Confirm Password: </label>
                            <div class="form-group">
                                <input type="password" placeholder="Enter Confirm Password" class="form-control" name="confirmpassword" id="confirmpassword">
                            </div>

                          </div>
                          <div class="modal-footer">
                            <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                            value="close">
                            <input type="submit" class="btn btn-outline-primary btn-lg" value="Submit">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Modal Settings-->
                  <div class="modal fade text-left" id="Selltings" tabindex="-1" role="dialog" aria-labelledby="RditProduct"
                  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <label class="modal-title text-text-bold-600" id="RditProduct">Setting</label>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id="errors" style="color: red;"></div>
                        
                        <form method="post" id="settings">
                        {{csrf_field()}}
                          <div class="modal-body">

                            <label>Tax (%): </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Tax in percentage (%)" value="{{{Auth::user()->tax}}}" class="form-control" name="tax" id="tax">
                            </div>

                            <label>Get current Location: </label>
                            <div class="form-group">
                                <a href="#" class="badge badge-primary px-2" onclick="getLocation()" >
                                    Click here to get your current location
                                </a>
                            </div>

                            <label>Latitude: </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="lat" id="lat" value="{{{Auth::user()->lat}}}" readonly="">
                            </div>

                            <label>Longitude</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="lang" id="lang" value="{{{Auth::user()->lang}}}" readonly="">
                            </div>

                            <label>Is Open?:</label>
                            <div class="form-group">
                            <label class="switch">
                            @if (Auth::user()->is_open == 1)
                                  <input type="checkbox" id="is_open" name="is_open" checked="">
                                  <span class="slider round"></span>
                            @else
                                  <input type="checkbox" id="is_open" name="is_open">
                                  <span class="slider round"></span>
                            @endif
                            </label>
                            </div>

                            <label>Delivery Charge: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Delivery Charge" value="{{{Auth::user()->delivery_charge}}}" class="form-control" name="delivery_charge" id="delivery_charge">
                            </div>

                          </div>
                          <div class="modal-footer">
                            <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                            value="close">
                            <input type="button" class="btn btn-outline-primary btn-lg" onclick="settings()"  value="Submit">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <!-- /#wrapper -->

    @include('theme.script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript">
        function myFunction() {
          alert("You don't have rights in Demo Admin panel");
        }
    </script>
    <script type="text/javascript">
        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
          }
        }

        function showPosition(position) {

            $('#lat').val(position.coords.latitude);
            $('#lang').val(position.coords.longitude);
        }
    </script>
    <script type="text/javascript">
        function changePassword(){     
            var oldpassword=$("#oldpassword").val();
            var newpassword=$("#newpassword").val();
            var confirmpassword=$("#confirmpassword").val();
            var CSRF_TOKEN = $('input[name="_token"]').val();
            
            if($("#change_password_form").valid()) {
                // $('#loaderimg').show();
                $.ajax({
                    headers: {
                        'X-CSRF-Token': CSRF_TOKEN 
                    },
                    url:"{{ url('admin/changePassword') }}",
                    method:'POST',
                    data:{'oldpassword':oldpassword,'newpassword':newpassword,'confirmpassword':confirmpassword},
                    dataType:"json",
                    beforeSend: function() {
                      $("#loading-image").show();
                    },
                    success:function(data){
                        $("#loading-image").hide();
                        if(data.error.length > 0)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<div class="alert alert-danger mt-1">'+data.error[count]+'</div>';
                            }
                            $('#errors').html(error_html);
                            setTimeout(function(){
                                $('#errors').html('');
                            }, 10000);
                        }
                        else
                        {
                            location.reload();
                        }
                    },error:function(data){
                       
                    }
                });
            }
        }

        function settings(){     
            var currency=$("#currency").val();
            var tax=$("#tax").val();
            var delivery_charge=$("#delivery_charge").val();
            var lat=$("#lat").val();
            var lang=$("#lang").val();
            var is_open = $("#is_open").prop("checked");
            var CSRF_TOKEN = $('input[name="_token"]').val();
            
            if($("#settings").valid()) {
                // $('#loaderimg').show();
                $.ajax({
                    headers: {
                        'X-CSRF-Token': CSRF_TOKEN 
                    },
                    url:"{{ url('admin/settings') }}",
                    method:'POST',
                    data:{'currency':currency,'tax':tax,'lat':lat,'lang':lang,'delivery_charge':delivery_charge,'is_open':is_open},
                    dataType:"json",
                    beforeSend: function() {
                      $("#loading-image").show();
                    },
                    success:function(data){
                        $("#loading-image").hide();
                        if(data.error.length > 0)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<div class="alert alert-danger mt-1">'+data.error[count]+'</div>';
                            }
                            $('#errors').html(error_html);
                            setTimeout(function(){
                                $('#errors').html('');
                            }, 10000);
                        }
                        else
                        {
                            location.reload();
                        }
                    },error:function(data){
                       
                    }
                });
            }
        }

        $(document).ready(function() {
            $( "#settings" ).validate({
                rules :{
                    currency:{
                        required: true
                    },
                    tax: {
                        required: true,
                    },                    
                },

            });        
        });

        $(document).ready(function() {
            $( "#change_password_form" ).validate({
                rules :{
                    oldpassword:{
                        required: true,
                        minlength:6
                    },
                    newpassword: {
                        required: true,
                        minlength:6,
                        maxlength:12,

                    },
                    confirmpassword: {
                        required: true,
                        equalTo: "#newpassword",
                        minlength:6,

                    },
                    
                },

            });        
        });
        var noticount = 0;

        (function noti() {
          var CSRF_TOKEN = $('input[name="_token"]').val();
          $.ajax({
              headers: {
                  'X-CSRF-Token': CSRF_TOKEN 
              },
              url:"{{ url('admin/getorder') }}",
              method: 'GET', //Get method,
              dataType:"json",
              success:function(response){
                noticount = localStorage.getItem("count");

                $('#notificationcount').text(response);
                if (response != 0) {
                  if (noticount != response) {
                    localStorage.setItem("count", response);

                    var audio = new Audio('https://infotechgravity.com/staging/public/assets/notification/notification.mp3');
                    audio.play();
                  }
                }else{
                  localStorage.setItem("count", response);
                }
                setTimeout(noti, 5000);
              }
          });
        })();

        function clearnoti(){
            var CSRF_TOKEN = $('input[name="_token"]').val();
            
            $.ajax({
                headers: {
                    'X-CSRF-Token': CSRF_TOKEN 
                },
                url:"{{ url('admin/clearnotification') }}",
                dataType:"json",
                success:function(response){
                    console.log(response);
                }
            });
        }
    </script>
</body>

</html>