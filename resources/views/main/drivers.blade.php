@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="header header-image-1 pt-3">
        <div class="container">
            <div class="row">

                <div class="col-md-6 order-2 order-md-1">
                    <h1>Earn money renting without car ownership headaches</h1>
                    <p class="mt-4">
                        NYC is a hard place to own a car and that makes cashing in on the rideshare gig opportunity tough. But Car Flo is changing that.
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
                                    <input type="radio" id="opt_car1" name="account_type">
                                    <label for="opt_car1">Car owner account</label>
                                </p>
                                <p class="mt-1">
                                    <input type="radio" id="opt_driver1" name="account_type" checked>
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


    <div class="subheader">
        <div class="container">

            <div class="row subheader-section">
                <div class="col-md-9">
                    <p>With our fleet of affordable rental vehicles positioned around the city and our proprietary app, you can earn money driving for Uber of Lyft any time that fits your schedule.</p>
                    <p>No hassles. No killer expenses. Ever.</p>
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
                        <h1>Here's how easy it is</h1>
                        <ol class="mt-2">
                            <li>Complete our simple <a href="https://goo.gl/forms/kZBYHB96tcVJrfRk2">registration form</a>. (You’ll need your driver’s license and TLC license.)</li>
                            <li>We’ll get back with your approval in usually less than 24 hours.</li>
                            <li>Download our app and start reserving your favorite car and scheduling your hours.</li>
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
                        <h1>No costs to you</h1>
                        <p class="mt-2">When you work through Car Flo, your costs go way down. You don’t have to worry about nagging expenses like parking, maintenance, and other routine costs.</p>
                    </div>
                    <!--div class="row">
                      <div class="col-12 col-md-8 offset-md-0 offset-0">
                        <div class="buttons mt-5">
                          <a class="btn btn-primary btn-lg btn-block" href="https://goo.gl/forms/kZBYHB96tcVJrfRk2" role="button" target="_blank">Sign up</a>
                        </div>
                      </div>
                    </div-->
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
                        <h1>We’ll meet your crazy schedule</h1>
                        <p class="mt-2">Whether you have a rock-solid schedule that seldom changes or you’re juggling a dozen different responsibilities, we make scheduling time and earning money easy.</p>
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



    <div class="action">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h3 class="text-center">But you can’t start to enjoy all of these benefits until you sign up.</h3>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2 offset-0">
                            <div class="buttons my-4">
                                <a class="btn btn-primary btn-lg btn-block" href="https://goo.gl/forms/kZBYHB96tcVJrfRk2" role="button" target="_blank">Sign up today</a>
                                <p class="help-text text-center mt-4">
                                    Don’t let this opportunity slip by.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="about">
        <div class="container">
            <div class="row">

                <div class="col-md-3 offset-md-1 col-8 offset-2">
                    <div class="about_images mx-auto">
                        <img class="my-3 img-fluid" src="{{asset('img/win.svg')}}" alt="Uber logo">
                    </div>
                </div>

                <div class="col-md-6 offset-md-2 offset-0">
                    <div class="about_text">
                        <h1>Here’s all it takes</h1>
                        <p class="mt-2">To work with Car Flo you need to be signed up with one or more of the rideshare companies – like Uber or Lyft – have had your driver’s license for at least three years and your NYC TLC license for one year.</p>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <hr>



    <div class="success-stories">
        <div class="container my-5">
            <div class="col-md-8 offset-md-2">

                <h5 class="my-5 text-center text-muted">Be inspired</h5>

                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">


                    <div class="carousel-inner">

                        <div class="carousel-item active px-5">
                            <h3 class="text-center mb-4">Lisa</h3>
                            <p class="px-0 px-md-5">
                                Lisa is a single mother who doesn’t own a car and doesn’t see herself buying one. With her daughter’s school events, holidays, and after-school programs, her schedule changes every week. She loves the simplicity of the Car Flo app and the scheduling flexibility it affords her. The income she earns each month is more than she could earn with any part-time job.
                            </p>
                        </div>

                        <div class="carousel-item px-5">
                            <h3 class="text-center mb-4">Frank</h3>
                            <p class="px-0 px-md-5">
                                Frank had been making ends meet by working two different part-time jobs. He started working as a full-time Uber and Lyft driver via Car Flo and how he’s working fewer hours, making more money, and feels that he has finally taken control of his life.
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
                    <h3 class="text-center">What will your success story sound like? Start writing it now</h3>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2 offset-0">
                            <div class="buttons my-4">
                                <a class="btn btn-primary btn-lg btn-block" href="https://goo.gl/forms/kZBYHB96tcVJrfRk2" role="button" target="_blank">Sign up today</a>
                                <p class="help-text text-center mt-4">
                                    It's free and simple – fill out our registration form and we'll be in touch.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('add_custom_script')
    <script>
        $('document').ready(function () {
            $(".accept-owner").hide();
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
            sessionStorage.clear();
            $('#form1').submit(function (e) {
                e.preventDefault();
                var email = $("#email1").val();
                var password = $("#password1").val();
                $("#custom-validation-errors").hide();
                if(password.length < 8){
                    $("#custom-validation-errors").show();
                    $("#custom-validation-errors").html('Minimum password length is 8 characters.');
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
        });
    </script>
@endsection