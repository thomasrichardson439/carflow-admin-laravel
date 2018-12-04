@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="action" style="padding-top: 40px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2 offset-0 form-pd">
                            <h5 class="text-center mb-4"><a href="{{url('/main')}}">Car Flo</a></h5>
                            <h5 class="text-center">Add details to finish your Car Owner registration</h5>
                            <p class="text-center"><a href="{{url('/register-driver')}}" style="color: red;">Want to create Driver account?</a></p>
                        </div>
                        <div class="col-12 col-md-8 offset-md-2 offset-0 form-border form-pd">
                            <form id="form-register" action="{{ route('save_car_owner') }}" method="post" enctype="multipart/form-data">
                                <div class="buttons my-4">
                                    @csrf
                                    @include('main._alerts')
                                    <div class="alert alert-danger mb-3 main-font" id="custom-validation-errors"></div>
                                    <p class="help-text mt-4">
                                        PERSONAL INFORMATION
                                    </p>
                                    <input type="hidden" name="email" value="{{ old('email') }}" class="form-control">
                                    <input type="hidden" name="password" value="{{ old('password') }}" class="form-control">
                                    <p class="mt-1 mb-0">
                                        Full name
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="full_name" id="full_name" required >
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Phone number
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="phone" id="phone" required >
                                    </p>
                                    <hr>
                                    <p class="mt-1 mb-0">
                                        PICK UP AND DROP OFF ADDRESS
                                    </p>
                                    <p>
                                        <span style="font-weight: 300;">Where do you want drivers to pickup and return your car?</span>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Address
                                    </p>
                                    <p>
                                        <input id="lot" name="pickup_location_lat" type="hidden" value="">
                                        <input id="lat" name="pickup_location_lon" type="hidden" value="">
                                        <input id="return_lat" name="return_location_lat" type="hidden" value="">
                                        <input id="return_lon" name="return_location_lon" type="hidden" value="">
                                        <input id="return_location" name="full_return_location" type="hidden" value="">
                                        <input id="autocomplete" name="full_pickup_location" onFocus="geolocate()" value="" type="text" class="form-control" required/>
                                    </p>
                                    <hr>

                                    {{--car details--}}
                                    <p class="help-text mt-4">
                                        CAR DETAILS
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Category
                                    </p>
                                    <p>
                                        <select class="form-control" name="category_id" id="category_id" required>
                                            @foreach ($carCategories as $category)
                                                <option @if (old('category_id') == $category->id) selected @endif
                                                value="{{ $category->id }}"
                                                >{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Car Make
                                    </p>
                                    <p>
                                        <select class="form-control" name="manufacturer_id" id="manufacturer_id" required>
                                            @foreach ($carManufacturers as $manufacturer)
                                                <option @if (old('manufacturer_id') == $manufacturer->id) selected @endif
                                                value="{{ $manufacturer->id }}"
                                                >{{ $manufacturer->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Car model
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="model" id="model" required >
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Year of production
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="year" id="year" required >
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Number of seats
                                    </p>
                                    <p>
                                        <input type="number" class="form-control" name="seats" id="seats" required >
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Color
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="color" id="color" required >
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Plate
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="plate" id="plate" required >
                                        <input type="hidden" name="allowed_recurring" value="0">
                                    </p>

                                    <p class="mt-1 mb-0 mt-4">
                                        Photo of the car
                                    </p>
                                    <table class="result-tbl result_tbl_form1" style="width: 100%;">
                                        <tr class="img_1">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" onerror="this.src='{{asset('images/no-face.png')}}'" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td class="img-name">IMG_72828.jpg</td>
                                            <td class="btn-remove text-right"><a href="javascript:remove_img(1)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file1" class="file" name="car_photo"/>
                                    </label>

                                    <p class="mt-1 mb-0 mt-4">
                                        Upload TLC/Diamon sticker
                                    </p>
                                    <table class="result-tbl result_tbl_form2" style="width: 100%;">
                                        <tr class="img_2">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" onerror="this.src='{{asset('images/no-face.png')}}'" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(2)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file2" name="tlc_photo" class="file"/>
                                    </label>

                                    <p class="mt-1 mb-0 mt-4">
                                        Upload FH-1 Insurance
                                    </p>
                                    <table class="result-tbl result_tbl_form3" style="width: 100%;">
                                        <tr class="img_3">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" onerror="this.src='{{asset('images/no-face.png')}}'" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(3)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file3" name="fh_photo" class="file"/>
                                    </label>
                                    <div class="accept-owner2">
                                        <input class="styled-checkbox" id="chk_terms_owner" type="checkbox" >
                                        <label for="chk_terms_owner">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms_owner">Owners Contract</a></label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" href="#" id="btn_form2">Submit information</button>
                                    <p id="message"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modal_terms_owner" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <iframe class="doc" src="https://docs.google.com/gview?url=http://54.183.254.243/docs/Car_Flo_Owner_Contract.doc&embedded=true"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_custom_script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('params.googleMapsKey') }}&libraries=places&callback=initAutocomplete" async defer></script>
    <script>
        var autocomplete;
        function initAutocomplete() {
            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete')));
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
//            $("#address").val("");
            $("#lot").val("");
            $("#lat").val("");
            var place = autocomplete.getPlace();
            var location  = place.geometry.location;
//            $("#address").val(place.name);
            $("#lat").val(location.lat());
            $("#lot").val(location.lng());
            $("#return_lat").val($("#lat").val());
            $("#return_lon").val($("#lot").val());
            $("#return_location").val($("#autocomplete").val());
        }

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script>
        var FILE = [null,null,null,null];
        function remove_img(image_id) {
            $(".result_tbl_form" + image_id).css("display", "none");
            FILE[image_id] = null;
            console.log(FILE);
            var $el = $('#file'+image_id);
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();

            return false;
        }
        $(document).ready(function (e) {
            $(".result-tbl").css("display", "none");
            var email = sessionStorage.getItem("email");
            var password = sessionStorage.getItem("password");
            if(email == undefined || password == undefined){
                document.location.href = "{{route('home-page')}}";
            }else{
                $("input[name='email']").val(email);
                $("input[name='password']").val(password);
            }
            $('form#form-register').on('submit', function(e) {
                $('#custom-validation-errors').hide();
                if($('#chk_terms_owner').is(':checked') == false){
                    e.preventDefault();
                    $('#custom-validation-errors').show();
                    $('#custom-validation-errors').html('You need to agree to Owners Contract.');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;
                }
            });

            var maxsize = 500 * 1024; // 500 KB
            $('#max-size').html((maxsize/1024).toFixed(2));

            $('.file').change(function() {
                $('#custom-validation-errors').hide();
                var target_id = $(this).attr('id').replace("file","");
                var file = this.files[0];
                FILE[target_id] = file;
                $('#custom-validation-errors').html('<b>Unvalid image format. Allowed formats: JPG, JPEG, PNG.</b>');
//                if ( !( (file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]) ) )
//                {
//                    $('#custom-validation-errors').show();
//                    $('#custom-validation-errors').html('<b>Unvalid image format. Allowed formats: JPG, JPEG, PNG.</b>');
//                    return false;
//                }
                if ( file.size > maxsize )
                {
                    $('#custom-validation-errors').show();
                    $('#custom-validation-errors').html('<b>The size of image you are attempting to upload is ' + (file.size/1024).toFixed(2) + ' KB, maximum size allowed is ' + (maxsize/1024).toFixed(2) + ' KB</b>');
                    return false;
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".result_tbl_form" + target_id).css("display", "table");
                    $("tr.img_"+target_id + " img").attr('src', e.target.result);
                    var file_name = FILE[target_id].name;
                    if(file_name.length > 40){
                        file_name = file_name.substring(0, 40) + "...";
                    }
                    $("tr.img_"+target_id + " .img-name").html(file_name);
                    $("tr.img_"+target_id + " .btn-remove").html('<a href="javascript:remove_img('+target_id+')">Remove</a>');
                }
                reader.readAsDataURL(FILE[target_id]);
            });

        });
    </script>
@endsection