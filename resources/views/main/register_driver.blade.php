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
                            <form id="form-register">
                                <div class="buttons my-4">
                                    <p class="help-text mt-4">
                                        PERSONAL INFORMATION
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Full name
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="full_name" id="full_name" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Phone number
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="phone" id="phone" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Address
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="address" id="address" required autocomplete="off">
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
                                                <img src="{{asset('images/no-face.png')}}" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(1)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file1" name="file1"/>
                                    </label>
                                    <p class="mt-1 mb-0">
                                        Back side
                                    </p>
                                    <table class="result-tbl result_tbl_form2" style="width: 100%;">
                                        <tr class="img_1">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(1)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file2" name="file2"/>
                                    </label>
                                    <hr>

                                    <p class="mt-1 mb-0 mt-4">
                                        TLC LICENSE
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Front side
                                    </p>
                                    <table class="result-tbl result_tbl_form3" style="width: 100%;">
                                        <tr class="img_1">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(1)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file3" name="file3"/>
                                    </label>
                                    <p class="mt-1 mb-0">
                                        Back side
                                    </p>
                                    <table class="result-tbl result_tbl_form4" style="width: 100%;">
                                        <tr class="img_1">
                                            <td style="width: 30px;">
                                                <img src="{{asset('images/no-face.png')}}" style="margin: 5px;margin-left: 0px;width: 20px;">
                                            </td>
                                            <td>IMG_72828.jpg</td>
                                            <td class="text-right"><a href="javascript:remove_img(1)">Remove</a></td>
                                        </tr>
                                    </table>
                                    <label class="fileContainer btn">
                                        SELECT IMAGES
                                        <input type="file" accept="image/*" id="file4" name="file4"/>
                                    </label>
                                    <hr>

                                    <p class="help-text mt-4">
                                        RIDESHARING APPS
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <span style="font-weight: 300;">Are you approved to work for any ridesharing apps?</span>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <input type="radio" id="opt_no_approve" name="approve">
                                        <label for="opt_no_approve" style="font-weight: 300;margin: 0px;">No, I'm not approved</label>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <input type="radio" id="opt_approve" name="approve" checked>
                                        <label for="opt_approve">Yes, I'm approved</label>
                                    </p>
                                    <div class="approve-apps">
                                        <ul class="unstyled centered">
                                            <li>
                                                <input class="styled-checkbox" id="chk_uber" type="checkbox" value="value2" checked>
                                                <label for="chk_uber">Uber</label>
                                            </li>
                                            <li>
                                                <input class="styled-checkbox" id="chk_lyft" type="checkbox" value="value2" checked>
                                                <label for="chk_lyft">Lyft</label>
                                            </li>
                                            <li>
                                                <input class="styled-checkbox" id="chk_via" type="checkbox" value="value2" checked>
                                                <label for="chk_via">Via</label>
                                            </li>
                                            <li>
                                                <input class="styled-checkbox" id="chk_juno" type="checkbox" value="value2" checked>
                                                <label for="chk_juno">Juno</label>
                                            </li>
                                            <li>
                                                <input class="styled-checkbox" id="chk_gett" type="checkbox" value="value2" checked>
                                                <label for="chk_gett">Gett</label>
                                            </li>
                                            <li>
                                                <input class="styled-checkbox" id="chk_other" type="checkbox" value="value2" checked>
                                                <label for="chk_other">Other</label>
                                            </li>

                                        </ul>
                                    </div>

                                    <p class="mt-1 mb-0">
                                        Specify Other
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="specify" id="specify" autocomplete="off">
                                    </p>

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

@endsection

@section('add_custom_script')
    <script>
        var FILE1;
        function remove_img(image_id) {
            return false;
        }
        function noPreview() {
            $('#image-preview-div').css("display", "none");
            $('#preview-img').attr('src', 'noimage');
            $('upload-button').attr('disabled', '');
        }

        function selectImage(e) {
            $('#file').css("color", "green");
            $('#image-preview-div').css("display", "block");
            $('#preview-img').attr('src', e.target.result);
            $('#preview-img').css('max-width', '50px');
        }
        $(document).ready(function (e) {

            var maxsize = 500 * 1024; // 500 KB
            $('#max-size').html((maxsize/1024).toFixed(2));
//            $('#upload-image-form').on('submit', function(e) {
//
//                e.preventDefault();
//
//                $('#message').empty();
//                $('#loading').show();
//
//                $.ajax({
//                    url: "upload-image.php",
//                    type: "POST",
//                    data: new FormData(this),
//                    contentType: false,
//                    cache: false,
//                    processData: false,
//                    success: function(data)
//                    {
//                        $('#loading').hide();
//                        $('#message').html(data);
//                    }
//                });
//
//            });

            $('#file').change(function() {

                $('#message').empty();
                var file = this.files[0];
                var match = ["image/jpeg", "image/png", "image/jpg"];

                if ( !( (file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]) ) )
                {
                    noPreview();
                    $('#message').html('<div class="alert alert-warning" role="alert">Unvalid image format. Allowed formats: JPG, JPEG, PNG.</div>');
                    return false;
                }
                if ( file.size > maxsize )
                {
                    noPreview();
                    $('#message').html('<div class=\"alert alert-danger\" role=\"alert\">The size of image you are attempting to upload is ' + (file.size/1024).toFixed(2) + ' KB, maximum size allowed is ' + (maxsize/1024).toFixed(2) + ' KB</div>');
                    return false;
                }

//                $('#upload-button').removeAttr("disabled");

                var reader = new FileReader();
                reader.onload = selectImage;
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>
@endsection