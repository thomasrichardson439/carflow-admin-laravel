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
                            <div>
                                <img src="{{asset('images/welcome.png')}}" style="max-width: 100%;width: auto;margin-left: auto;margin-right: auto;display: block;">
                            </div>

                            <h5 class="text-center">Account Created!</h5>
                            <p class="text-center">We're reviewing your documents now. It usually takes less than 24 hours and we will notify you by email when it's ready!</p>
                            <p class="text-center"><a href="{{url('/main')}}" style="color: red;">Return to Homepage</a></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('add_custom_script')
    <script>

        $(document).ready(function (e) {
            $('body').css("background-color", "#f8f9fa");
        });
    </script>
@endsection