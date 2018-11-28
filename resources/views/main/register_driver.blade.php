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
                            <h5 class="text-center">Add details to finish your Driver registration</h5>
                            <p class="text-center"><a href="{{url('/register-car')}}" style="color: red;">Want to create Car Owner account?</a></p>
                        </div>
                        <div class="col-12 col-md-8 offset-md-2 offset-0 form-border form-pd">
                            <form id="form-register" action="{{ url('/user/store/driver') }}" method="post" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" name="full_name" id="full_name" value="{{ old('full_name') }}" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Phone number
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Address
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}" required autocomplete="off">
                                    </p>
                                    <hr>

                                    {{--driver license--}}
                                    <p class="help-text mt-4">
                                        DRIVING LICENSE
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Front side
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
                                        <input type="file" accept="image/*" id="file1" class="file" name="driving_license_front"/>
                                    </label>
                                    <p class="mt-1 mb-0">
                                        Back side
                                    </p>
                                    <table class="result-tbl result_tbl_form2" style="width: 100%;">
                                        <tr class="img_1">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" onerror="this.src='{{asset('images/no-face.png')}}'" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(2)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file2" name="driving_license_back" class="file"/>
                                    </label>
                                    <hr>

                                    <p class="mt-1 mb-0 mt-4">
                                        TLC LICENSE
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Front side
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
                                        <input type="file" accept="image/*" id="file3" name="tlc_license_front" class="file"/>
                                    </label>
                                    <p class="mt-1 mb-0">
                                        Back side
                                    </p>
                                    <table class="result-tbl result_tbl_form4" style="width: 100%;">
                                        <tr class="img_4">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" onerror="this.src='{{asset('images/no-face.png')}}'" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(4)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file4" name="tlc_license_back" class="file"/>
                                    </label>
                                    <hr>

                                    <p class="help-text mt-4">
                                        RIDESHARING APPS
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <span style="font-weight: 300;">Are you approved to work for any ridesharing apps?</span>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <input type="radio" id="opt_no_approve" name="approve" value="0">
                                        <label for="opt_no_approve" style="font-weight: 300;margin: 0px;">No, I'm not approved</label>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <input type="radio" id="opt_approve" name="approve" checked value="1">
                                        <label for="opt_approve">Yes, I'm approved</label>
                                    </p>
                                    <div class="approve-apps">
                                        <ul class="unstyled centered">
                                            @foreach (old('ridesharing_app', $defaultApps) as $app)
                                            <li>
                                                <input class="styled-checkbox" id="chk_{{$app}}" name="ridesharing_apps[{{ $app }}]" type="checkbox" value="{{ $app }}" checked>
                                                <label for="chk_{{$app}}">{{$app}}</label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <p class="mt-1 mb-0">
                                        Specify Other
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="ridesharing_app_additional" id="specify" autocomplete="off">
                                    </p>


                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" href="#" id="btn_form2">Submit information</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('add_custom_script')
    <script>
        var FILE = [null,null,null,null,null];
        function remove_img(image_id) {
            $(".result_tbl_form" + image_id).css("display", "none");
            FILE[image_id] = null;
            console.log(FILE);
            var $el = $('#file'+image_id);
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();

            return false;
        }

        function selectImage(id) {
            $('#file1').css("color", "green");
            $('#image-preview-div').css("display", "block");
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(FILE1);

            $('#preview-img').css('max-width', '50px');
            console.log("id : ", id);
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
            var maxsize = 500 * 1024; // 500 KB
            $('#max-size').html((maxsize/1024).toFixed(2));
            $("input[name='approve']").click(function () {
                var selected_option = $( "input[name='approve']:checked" ).val();
                if(selected_option == 0){
                    $(".approve-apps input[type='checkbox']").each(function () {
                        $(this).attr("checked", false);
                    });
                }else{
                    $(".approve-apps input[type='checkbox']").each(function () {
                        $(this).attr("checked", true);
                    });
                }
            });
            $('form#form-register').on('submit', function(e) {
//                e.preventDefault();
                return true;
//                $('#indicator').show();
//                $.post(
//                    "http://54.183.254.243/api/register/create",
//                    {
//
//                    },
//                    function (response) {
//
//                    },"json"
//                );

            });

            $('.file').change(function() {
                $('#custom-validation-errors').hide();
                var target_id = $(this).attr('id').replace("file","");
                var file = this.files[0];
                FILE[target_id] = file;
                $('#custom-validation-errors').html('<b>Unvalid image format. Allowed formats: JPG, JPEG, PNG.</b>');
                if ( !( (file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]) ) )
                {
                    $('#custom-validation-errors').show();
                    $('#custom-validation-errors').html('<b>Unvalid image format. Allowed formats: JPG, JPEG, PNG.</b>');
                    return false;
                }
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
                    $("tr.img_"+target_id + " .img-name").html(FILE[target_id].name);
                    $("tr.img_"+target_id + " .btn-remove").html('<a href="javascript:remove_img('+target_id+')">Remove</a>');
                }
                reader.readAsDataURL(FILE[target_id]);
            });

        });
    </script>
@endsection