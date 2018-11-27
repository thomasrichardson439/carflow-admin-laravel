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
                                        <input type="text" class="form-control" name="address" id="address" required autocomplete="off">
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
                                        <select class="form-control" name="car_category" id="car_category" required>
                                            <option value=""></option>
                                            <option value="1">Sedan</option>
                                            <option value="2">ttt</option>
                                        </select>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Car marker
                                    </p>
                                    <p>
                                        <select class="form-control" name="car_mark" id="car_mark" required>
                                            <option value=""></option>
                                            <option value="1">ford</option>
                                            <option value="2">Benz</option>
                                        </select>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Car model
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="car_model" id="car_model" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Your of production
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="production" id="production" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Number of seats
                                    </p>
                                    <p>
                                        <input type="number" class="form-control" name="seat_number" id="seat_number" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Color
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="color" id="color" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Plate
                                    </p>
                                    <p>
                                        <input type="text" class="form-control" name="plate" id="plate" required autocomplete="off">
                                    </p>

                                    <p class="mt-1 mb-0 mt-4">
                                        Photo of the car
                                    </p>
                                    <div id="image-preview-div" style="display: none">
                                        <label for="exampleInputFile">Selected image:</label>
                                        <br>
                                        <img id="preview-img" src="noimage">
                                    </div>
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

                                    <p class="mt-1 mb-0 mt-4">
                                        Upload TLC/Diamon sticker
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
                                        <input type="file" accept="image/*" id="file2"/>
                                    </label>

                                    <p class="mt-1 mb-0 mt-4">
                                        Upload FH-1 Insurance
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
                                        <input type="file" accept="image/*" id="file3"/>
                                    </label>

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