@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="header header-image-4 pt-3">
        <div class="container">
            <div class="row">

                <div class="col-md-6 order-2 order-md-1">

                    <h1 class="mt-5 pt-5">How Car Flo Works</h1>

                    <p class="mt-4">Rent an affordable top-quality vehicle for only the hours you plan to drive rideshare. With Car Flo you never worry about insurance, parking, or vehicle maintenance. And, our system is designed for ultimate driver convenience.</p>

                </div>

            </div>

        </div>
    </div>


    <div class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-10 offset-1">

                    <div class="step">
                        <h4>1. Sign up with a rideshare service</h4>
                        <p>
                            Get approved as an Uber/Lyft driver.</span>
                        </p>
                    </div>

                    <div class="step">
                        <h4>2. Get the app</h4>
                        <p>
                            Download the Car Flo app on iTunes or Google Play.</span>
                        </p>
                    </div>

                    <div class="step">
                        <h4>3. Register with Car Flo</h4>
                        <p>Use the app or our <a href="{{url('/main')}}">sign up</a> to register. Have these required documents ready to photograph and upload:</p>
                        <ul>
                            <li>TLC License</li>
                            <li>DMV License</li>
                            <li>Social Secutity card <span style="color: red;"> &nbsp;(If you are an owner planning to rent your vehicle)</span></li>
                            <li>Proof of address (ex: utility bill, bank statement)</li>
                            <li>Debit/Credit Card</li>
                        </ul>
                        <p>We’ll get back with your approval in about four hours.</p>
                        <p class="text-muted small">Important: Keep the documents you receive from Car Flo with you while you are driving Car Flo vehicles.</p>
                    </div>

                    <div class="step">
                        <h4>4. Reserve your car</h4>
                        <p>
                            Using the app, reserve cars for just the hours you want to drive rideshare. Choose cars in the zones most convenient for you.
                        </p>
                    </div>

                    <div class="step">
                        <h4>5. Pickup your car</h4>
                        <p>Use the Car Flo app to quickly communicate any problems to Car Flo. We won’t leave you hanging.</p>
                    </div>

                    <div class="step">
                        <h4>6. Return your car</h4>
                        <p>When your time is up, return the car to the designated drop off location, put the keys back in the console and lock the car.</p>
                        <p class="text-muted small">
                            Important: Don't forget to return the car clean and with a full tank of gas for the next driver.
                        </p>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="action">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h1 class="text-center">Want to start earning today?</h1>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2 offset-0">
                            <div class="buttons my-4">
                                <a class="btn btn-primary btn-lg btn-block" href="{{url('/main')}}" role="button">Go with “The Flo”</a>
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

    </script>
@endsection