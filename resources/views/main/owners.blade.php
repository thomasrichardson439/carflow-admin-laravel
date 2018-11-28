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
                    {{--<div class="row">--}}
                        {{--<div class="col-12 col-md-8 offset-md-0 offset-0">--}}
                            {{--<div class="buttons mt-2">--}}
                                {{--<a class="btn btn-primary btn-lg btn-block" href="https://goo.gl/forms/kZBYHB96tcVJrfRk2" role="button" target="_blank">Sign up today</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class="col-md-6 order-2">
                    <div class="row">
                        <div class="register-form col-12 col-md-8 offset-md-2 offset-0">
                            <div class="buttons my-4">
                                <p class="help-text text-center mt-4">
                                    What type of account do you want to create?
                                </p>
                                <p class="mt-1 mb-0">
                                    <input type="radio" id="opt_car1" name="account_type" checked>
                                    <label for="opt_car1">Car owner account</label>
                                </p>
                                <p class="mt-1">
                                    <input type="radio" id="opt_driver1" name="account_type">
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

                                <a class="btn btn-primary btn-lg btn-block mt-4" href="#" role="button" target="_blank">Create account</a>
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
                    <h3 class="text-center">How will you use the extra income?</h3>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2 offset-0">
                            <div class="buttons my-4">
                                <a class="btn btn-primary btn-lg btn-block" href="https://goo.gl/forms/kZBYHB96tcVJrfRk2" role="button" target="_blank">Sign up</a>
                                <p class="help-text text-center mt-4">
                                    Sign up now and start enjoying the benefits.
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
@endsection

@section('add_custom_script')
    <script>

    </script>
@endsection