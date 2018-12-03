@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="header header-image-1 pt-3">
        <div class="container">
            <div class="row">



                <div class="col-md-6 order-2 order-md-1">

                    <h1 class="mt-5 pt-5">About Us</h1>

                    <p class="mt-4">
                        Car Flo co-founders Kyle Freedman and Carl Nowicki apply their backgrounds in business and education to create a new approach to rideshare driving that puts control, flexibility and profits back into the hands of those who power the industry – the drivers and car owners.
                </div>

            </div>

        </div>
    </div>


    <div class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-10 offset-1">

                    <div class="step">
                        <p>As long-time New Yorkers, Kyle and Carl understand the daily hassles and huge expense of owning a car in New York City. It prevents nonowner drivers from earning money in the rideshare industry and it eats into the earnings of owner-drivers.</p>
                        <p>An expert in the sharing economy and app development, Kyle realized he could use the power of the peer-to-peer economy to remedy these problems. And as a professional experienced in helping people to realize their dreams, Carl knew he could help design a system that empowers drivers.</p>
                        <p>The result is Car Flo, where rideshare drivers can easily rent quality cars for as many or as few hours as they need and where car owners can rent their vehicles to qualified rideshare drivers whenever their cars would otherwise sit idle.
                            In the end, we believe that the Car Flo system will lessen demand for for-hire vehicles in the city and decrease the congestion that plagues us all.</p>
                        <p>Everyone wins with Car Flo.</p>
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
                                <a class="btn btn-primary btn-lg btn-block" href="{{url('/main')}}" role="button">Go with “Car Flo”</a>
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