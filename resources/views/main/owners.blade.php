@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="header header-image-5 pt-3">
        <div class="container">
            <div class="row">

                <div class="col-md-6 order-2 order-md-1">
                    <h1>Turn your idle car into a money-making machine</h1>
                    <p class="mt-4">
                        Your idle, parked car is costing you money. Flip the situation: Rent your car to rideshare drivers and create a major flow of passive income. <br><br>Signup today while demand for rentals is high.
                    </p>
                </div>
                <div class="col-md-6 order-2">
                    <div class="row">
                        <div class="register-form col-12 col-md-8 offset-md-2 offset-0">
                            <form id="form1">
                            <div class="buttons my-4">
                                <p class="help-text text-center mt-4">
                                    What type of account do you want to create?
                                </p>
                                <div class="alert alert-danger mb-3 main-font" id="custom-validation-errors"></div>
                                <p class="mt-1 mb-0">
                                    <input type="radio" id="opt_car1" name="account_type" value="car" checked>
                                    <label for="opt_car1">Car owner account</label>
                                </p>
                                <p class="mt-1">
                                    <input type="radio" id="opt_driver1" name="account_type" value="driver">
                                    <label for="opt_driver1">Driver account</label>
                                </p>
                                <p class="mt-1 mb-0">
                                    Email
                                </p>
                                <p>
                                    <input type="text" class="form-control" name="email1" id="email1" placeholder="" required autocomplete="off">
                                </p>
                                <p class="mt-1 mb-0">
                                    Password
                                </p>
                                <p>
                                    <input type="password" class="form-control" name="password1" id="password1" placeholder="" required autocomplete="off">
                                </p>
                                <ul class="unstyled terms-area1">
                                    <li>
                                        <input class="styled-checkbox" id="chk_terms1" type="checkbox" >
                                        <label for="chk_terms1">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms">Terms & Conditions</a></label>
                                    </li>
                                    <li class="accept-driver">
                                        <input class="styled-checkbox" id="chk_terms_driver1" type="checkbox" >
                                        <label for="chk_terms_driver1">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms_driver">Drivers Contract</a></label>
                                    </li>
                                    <li class="accept-owner">
                                        <input class="styled-checkbox" id="chk_terms_owner1" type="checkbox" >
                                        <label for="chk_terms_owner1">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms_owner">Owners Contract</a></label>
                                    </li>
                                </ul>
                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" id="btn_form1">Create account</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="about_text">
                        <h1>It couldn’t be easier:</h1>
                        <ol class="mt-2">
                            <li>Complete our simple <a href="https://goo.gl/forms/kZBYHB96tcVJrfRk2">signup form</a>.</li>
                            <li>Decide which days and hours you want to make your car available for renting.</li>
                            <li>Set your own pickup and drop-off locations.</li>
                            <li>Get paid for every hour your car is being used and <strong>get it back when you want it.</strong></li>
                        </ol>
                    </div>

                </div>

                <div class="col-md-3 offset-md-2 col-8 offset-2 order-1 order-md-2">
                    <div class="about_images mx-auto">
                        <img class="img-fluid" src="{{asset('img/support.svg')}}" alt="Uber logo">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <hr>


    <div class="about">
        <div class="container">
            <div class="row">

                <div class="col-md-3 offset-md-1 col-8 offset-2">
                    <div class="about_images mx-auto">
                        <img class="img-fluid" src="{{asset('img/car-2.svg')}}" alt="Uber logo">
                    </div>
                </div>

                <div class="col-md-6 offset-md-2 offset-0">
                    <div class="about_text">
                        <h1>The assurance you need</h1>
                        <p class="mt-2">Car Flo checks the credentials of every Car Flo driver and requires drivers to have requires drivers to submit their licenses and checks their driving record's before approving them to drive your car behind the wheel and have held a TLC license for at least one year.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <hr>

    <div class="about">
        <div class="container">
            <div class="row">



                <div class="col-md-6 order-2 order-md-1">
                    <div class="about_text">
                        <h1>Ready, set, go!</h1>
                        <p class="mt-2">The sooner you get your car in our system, the sooner you’ll start enjoying the profits from this incredible source of passive income. <a href="https://goo.gl/forms/kZBYHB96tcVJrfRk2">Sign up today.</a></p>
                    </div>

                </div>

                <div class="col-md-3 offset-md-2 col-8 offset-2 order-1 order-md-2">
                    <div class="about_images mx-auto">
                        <img class="img-fluid" src="{{asset('img/three-ways.svg')}}" alt="Uber logo">
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div class="success-stories">
        <div class="container my-5">
            <div class="col-md-8 offset-md-2">

                <h5 class="my-5 text-center text-muted">How renting benefits drivers like you</h5>

                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">


                    <div class="carousel-inner">

                        <div class="carousel-item active px-5">
                            <h3 class="text-center mb-4">Mario</h3>
                            <p class="px-0 px-md-5">
                                Mario joined Car Flo so he could put his vehicle in the Car Flo fleet when he isn’t driving. He’s making a lot more money now and says that his car is paying off far better than the stocks and mutual funds he has in his IRA.
                            </p>
                        </div>

                        <div class="carousel-item px-5">
                            <h3 class="text-center mb-4">Saad and Ahmed</h3>
                            <p class="px-0 px-md-5">
                                Brothers Saad and Ahmed share a car, but even then, there are days and times when neither brother is able to drive rideshare. The extra money they make renting their car pays for the car and allows them to enjoy time off to travel.
                            </p>
                        </div>

                    </div>
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    </ol>



                </div>
            </div>
        </div>
    </div>


    <div class="action">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h5 class="text-center">Want to start earning today?</h5>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2 offset-0">
                            <form id="form2">
                                <div class="buttons my-4">
                                    <p class="help-text text-center mt-4">
                                        What type of account do you want to create?
                                    </p>
                                    <div class="alert alert-danger mb-3 main-font" id="custom-validation-errors1"></div>
                                    <p class="mt-1 mb-0">
                                        <input type="radio" id="opt_car2" name="account_type2" value="car" checked>
                                        <label for="opt_car2">Car owner account</label>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        <input type="radio" id="opt_driver2" name="account_type2" value="driver">
                                        <label for="opt_driver2">Driver account</label>
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Email
                                    </p>
                                    <p>
                                        <input type="email" class="form-control" name="email2" id="email2" placeholder="" required autocomplete="off">
                                    </p>
                                    <p class="mt-1 mb-0">
                                        Password
                                    </p>
                                    <p>
                                        <input type="password" class="form-control" name="password2" id="password2" placeholder="" required autocomplete="off">
                                    </p>
                                    <ul class="unstyled terms-area2">
                                        <li>
                                            <input class="styled-checkbox" id="chk_terms2" type="checkbox" >
                                            <label for="chk_terms2">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms">Terms & Conditions</a></label>
                                        </li>
                                        <li class="accept-driver2">
                                            <input class="styled-checkbox" id="chk_terms_driver2" type="checkbox" >
                                            <label for="chk_terms_driver2">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms_driver">Drivers Contract</a></label>
                                        </li>
                                        <li class="accept-owner2">
                                            <input class="styled-checkbox" id="chk_terms_owner2" type="checkbox" >
                                            <label for="chk_terms_owner2">Accept <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_terms_owner">Owners Contract</a></label>
                                        </li>
                                    </ul>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" href="#" id="btn_form2">Create account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="about_text">
                        <h1>More information</h1>
                        <p>You set the rental rate for your vehicle. Car Flo charges just 20% to facilitate the rental. Owners are responsible for proper maintenance insurance.</p>
                    </div>

                </div>

                <div class="col-md-3 offset-md-2 col-8 offset-2 order-1 order-md-2">
                    <div class="about_images mx-auto">
                        <img class="img-fluid" src="{{asset('img/support.svg')}}" alt="Uber logo">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_terms" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <iframe class="doc" src="https://docs.google.com/gview?url=http://54.183.254.243/docs/Car_Flow_Terms_Of_Use.docx&embedded=true"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_terms_driver" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <iframe class="doc" src="https://docs.google.com/gview?url=http://54.183.254.243/docs/Car_Flo_Contract.docx&embedded=true"></iframe>
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
                    <iframe class="doc" src="https://docs.google.com/gview?url=http://54.183.254.243/docs/Car_Flo_Owner_Contract.docx&embedded=true"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_custom_script')
    <script>
        $('document').ready(function () {
            $(".accept-driver").hide();
            $(".accept-owner2").hide();
            $("input[name='account_type']").click(function () {
                var sel_user_type = $("input[name='account_type']:checked").val();
                if(sel_user_type == "driver"){
                    // show driver license
                    $(".accept-driver").show();
                    $(".accept-owner").hide();
                }else{
                    $(".accept-driver").hide();
                    $(".accept-owner").show();
                }
            });
            $("input[name='account_type2']").click(function () {
                var sel_user_type = $("input[name='account_type2']:checked").val();
                if(sel_user_type == "driver"){
                    // show driver license
                    $(".accept-driver2").show();
                    $(".accept-owner2").hide();
                }else{
                    $(".accept-driver2").hide();
                    $(".accept-owner2").show();
                }
            });
            sessionStorage.clear();
            $('#form1').submit(function (e) {
                e.preventDefault();
                var email = $("#email1").val();
                var password = $("#password1").val();
                $("#custom-validation-errors").hide();
                if(password.length < 8){
                    $("#custom-validation-errors").show();
                    $("#custom-validation-errors").html('Password must have a minimum password length is 8 characters');
                    return false;
                }
                var sel_user_type = $("input[name='account_type']:checked").val();
                console.log(sel_user_type);
                if(sel_user_type == "driver"){
                    if(!$("#chk_terms1").is(':checked') || !$("#chk_terms_driver1").is(':checked')){
                        $("#custom-validation-errors").show();
                        $("#custom-validation-errors").html('You should agree on Terms and Policy.');
                        return false;
                    }
                }else if(sel_user_type == "car"){
                    if(!$("#chk_terms1").is(':checked') || !$("#chk_terms_owner1").is(':checked')){
                        $("#custom-validation-errors").show();
                        $("#custom-validation-errors").html('You should agree on Terms and Policy.');
                        return false;
                    }
                }
                alert(345);
                $.post(
                    "{{route('validate-email')}}",
                    {
                        _token: "{{csrf_token()}}",
                        email: email
                    },
                    function (response) {
                        if(response.status == "ok"){
                            var sel_user_type = $("input[name='account_type']:checked").val();
                            sessionStorage.setItem("email", email);
                            sessionStorage.setItem("password", password);
                            if(sel_user_type == "driver"){
                                document.location.href = "{{route('register_driver')}}";
                            }else if(sel_user_type == "car"){
                                document.location.href = "{{route('register_car')}}";
                            }
                        }else{
                            $("#custom-validation-errors").show();
                            $("#custom-validation-errors").html(response.message);
                        }
                    },"json"
                );
                return false;
            });
            $('#form2').submit(function (e) {
                e.preventDefault();
                var email = $("#email2").val();
                var password = $("#password2").val();
                $("#custom-validation-errors1").hide();
                if(password.length < 8){
                    $("#custom-validation-errors1").show();
                    $("#custom-validation-errors1").html('Password must have a minimum password length is 8 characters.');
                    return false;
                }

                var sel_user_type = $("input[name='account_type2']:checked").val();
                if(sel_user_type == "driver"){
                    if(!$("#chk_terms2").is(':checked') || !$("#chk_terms_driver2").is(':checked')){
                        $("#custom-validation-errors1").show();
                        $("#custom-validation-errors1").html('You should agree on Terms and Policy.');
                        return false;
                    }
                }else if(sel_user_type == "car"){
                    if(!$("#chk_terms2").is(':checked') || !$("#chk_terms_owner2").is(':checked')){
                        $("#custom-validation-errors1").show();
                        $("#custom-validation-errors1").html('You should agree on Terms and Policy.');
                        return false;
                    }
                }

                $.post(
                    "{{route('validate-email')}}",
                    {
                        _token: "{{csrf_token()}}",
                        email: email
                    },
                    function (response) {
                        if(response.status == "ok"){
                            var sel_user_type = $("input[name='account_type2']:checked" ).val();
                            sessionStorage.setItem("email", email);
                            sessionStorage.setItem("password", password);
                            if(sel_user_type == "driver"){
                                document.location.href = "{{route('register_driver')}}";
                            }else if(sel_user_type == "car"){
                                document.location.href = "{{route('register_car')}}";
                            }
                        }else{
                            $("#custom-validation-errors1").show();
                            $("#custom-validation-errors1").html(response.message);
                        }
                    },"json"
                );

                return false;
            });
        });
    </script>
@endsection