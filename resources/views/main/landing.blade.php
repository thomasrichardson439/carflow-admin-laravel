@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="header pt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-2 order-md-1">
                    <h1>Join the Next Generation of Rideshare Driving</h1>
                    <p class="mt-4">
                        Are you suffering from too many costs and too few ways to make rideshare money? Car Flo solves these problems.
                    </p>
                    {{--<div class="row">--}}
                        {{--<div class="col-12 col-md-8 offset-md-0 offset-0">--}}
                            {{--<div class="buttons mt-2">--}}
                                {{--<a class="btn btn-primary btn-lg btn-block" href="#" role="button" target="_blank">Join Car Flo today</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
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
                                    <input type="radio" id="opt_car1" name="account_type" value="car">
                                    <label for="opt_car1">Car owner account</label>
                                </p>
                                <p class="mt-1">
                                    <input type="radio" id="opt_driver1" name="account_type" checked  value="driver">
                                    <label for="opt_driver1">Driver account</label>
                                </p>
                                <p class="mt-1 mb-0">
                                    Email
                                </p>
                                <p>
                                    <input type="email" class="form-control" name="email1" id="email1" placeholder="" required autocomplete="off">
                                </p>
                                <p class="mt-1 mb-0">
                                    Password
                                </p>
                                <p>
                                    <input type="password" class="form-control" name="password1" id="password1" placeholder="" required autocomplete="off">
                                </p>

                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" href="#" id="btn_form1">Create account</button>
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
                <div class="col-md-3">
                    <h4><a href="{{url('/drivers')}}">Drivers</a></h4>
                </div>
                <div class="col-md-9">
                    <p>For TLC drivers who don’t own their own cars, we offer affordable hourly rental rates – never rent for hours or days you won’t be driving. Plus, we handle virtually all of your additional costs!</p>
                </div>
            </div>

            <hr>

            <div class="row subheader-section mt-5">
                <div class="col-md-3">
                    <h4><a href="{{url('/owners')}}">Owners</a></h4>
                </div>
                <div class="col-md-9">
                    <p>Car owners can make even more. Rent your car whenever you don’t need it. Sitting idle, it’s just costing you money. Flip that situation and turn it into a profit-making machine.</p>
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
                        <h1>No car. No problem.</h1>
                        <p class="mt-2">As a Car Flo driver, you have exclusive access to our fleet of clean, well-maintained vehicles. Use our app to reserve your preferred car for the exact hours and days you’ll be driving. What’s more, when you arrive at one
                            of our convenient parking areas, you use our app to unlock your Car Flo vehicle.</p>
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
                        <h1>Cash in on your car</h1>
                        <p class="mt-2">Sitting idle, your car is doing two things: collecting dust and depreciating. With Car Flo’s innovative peer-to-peer rental program, you can rent your car to responsible Car Flo rideshare drivers and turn that money pit
                            into a money pile.</p>
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

    <hr>

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
                        <h1>Sound good?</h1>
                        <p class="mt-2">The driver requirements are simple: You’ve held your driver’s license for at least three years and your TLC license for at least a year. Have those documents ready and you can apply online immediately.</p>
                        <p class="mt-2">To get your car into our rental program, we need your name, phone number, email, car model, car year, car color, car insurance company, and car availability. You’ll set your rental rate and simply name renters on your
                            insurance.</p>
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
                        <h1>24-7 driver support</h1>
                        <p class="mt-2">As a new member of the Car Flo family, you’re going to love our mobile app. Use it to lock and unlock Car Flo cars, reserve cars, manage your hours, check your history, report accidents, contact our 24-hour customer
                            support, and much more.</p>
                        <p class="mt-2">Our dedication to your success and wellbeing extends far beyond the hours you drive. You’ll soon discover that Car Flo is here to support you whether you’re a student driving part time for much-needed spending money or
                            the head of household driving full time to create a better life for your family.</p>
                    </div>
                </div>

                <div class="col-md-3 offset-md-2 col-8 offset-2 order-1 order-md-2">
                    <div class="about_images mx-auto">
                        <img class="my-3 img-fluid" src="{{asset('img/support.svg')}}" alt="Uber logo">
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
                        <img class="img-fluid" src="{{asset('img/high-five.svg')}}" alt="Uber logo">
                    </div>
                </div>

                <div class="col-md-6 offset-md-2 offset-0">
                    <div class="about_text">
                        <h1>How do we do it?</h1>
                        <p class="mt-2">Car Flo uses cutting-edge technology and a commitment to the men and women who make rideshare work to maximize your earnings.</p>
                        <p class="mt-2">And, we show our drivers the respect they deserve by paying for gas, tolls, and Car Flo vehicle maintenance.</p>
                        <p class="mt-2"><strong>Still have questions?</strong></p>
                        <p class="mt-2">Head over to our <a href="{{url('/faq')}}">FAQ page</a> to dig into even more details about what we’re doing at Car Flo and how you can work with us.</p>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <hr>
    <div class="success-stories">
        <div class="container my-5">
            <div class="col-md-8 offset-md-2">

                <h5 class="my-5 text-center text-muted">Success stories</h5>
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">
                        <div class="carousel-item active px-5">
                            <h3 class="text-center mb-4">Mario</h3>
                            <p class="px-0 px-md-5">
                                Mario owns his car and is a long-time rideshare driver. He joined Car Flo so he could put his vehicle in the Car Flo fleet when he isn’t driving. He’s making a lot more money now and says that his car is paying off far better than the
                                stocks and mutual funds he has in his IRA. In fact, he says its smarter to use a rideshare service himself and leave his car in the Car Flo fleet considering the costs and headaches of trying to park anywhere in NYC.
                            </p>
                        </div>

                        <div class="carousel-item px-5">
                            <h3 class="text-center mb-4">Lisa</h3>
                            <p class="px-0 px-md-5">
                                Lisa is a single mother who doesn’t own a car and doesn’t see herself buying one. With her daughter’s school events, holidays, and after-school programs, her schedule changes every week. She loves the simplicity of the Car Flo app and
                                the scheduling flexibility it affords her. The income she earns each month is far beyond anything available to her with any other part-time work. If something comes up at school she can reschedule her shift on a moment’s notice. No
                                other part-time work has ever given her that kind of freedom.
                            </p>
                        </div>

                        <div class="carousel-item px-5">
                            <h3 class="text-center mb-4">Saad and Ahmed</h3>
                            <p class="px-0 px-md-5">
                                Saad and Ahmed are brothers who went in together to buy a car so they could drive rideshare. The problem was that only one of them could be driving and earning at a time. Since they joined Car Flo, if they need to overlap their
                                schedules, one brother simply uses a Car Flo vehicle. This has made life much better for Saad and Ahmed. They can enjoy family time together and when they go abroad and visit relatives, they put their car in the Car Flo fleet so
                                they’re even earning money when they’re out of town.
                            </p>
                        </div>

                    </div>
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
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
                                    <input type="radio" id="opt_car2" name="account_type2" value="car">
                                    <label for="opt_car2">Car owner account</label>
                                </p>
                                <p class="mt-1 mb-0">
                                    <input type="radio" id="opt_driver2" name="account_type2" checked value="driver">
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

                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" href="#" id="btn_form2">Create account</button>
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
        $('document').ready(function () {
            sessionStorage.clear();
            $('#form1').submit(function (e) {
                e.preventDefault();
                var email = $("#email1").val();
                var password = $("#password1").val();
                $("#custom-validation-errors").hide();
                if(password.length < 6){
                    $("#custom-validation-errors").show();
                    $("#custom-validation-errors").html('Minimum password length is 6 characters.');
                    return false;
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
            $('#form2').submit(function (e) {
                e.preventDefault();
                var email = $("#email2").val();
                var password = $("#password2").val();
                $("#custom-validation-errors1").hide();
                if(password.length < 6){
                    $("#custom-validation-errors1").show();
                    $("#custom-validation-errors1").html('Minimum password length is 6 characters.');
                    return false;
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