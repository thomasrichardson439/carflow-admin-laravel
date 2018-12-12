@extends('layouts.admin1')

@push("styles")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .form-group {
        margin-bottom: 0rem;
    }
    .image-card img{
        height: 70px;
        width: 100px;
        object-fit: cover;
        border-radius: 3px;
        border: 1px solid #ddd;
    }
    .car-descr p{
        margin-bottom: 0px;
        line-height: 1.4;
    }
</style>
@endpush

@section('content')

    <form action="{{ url('/admin/users/'.$user->id.'/booking/availableForBooking') }}" method="get" enctype="multipart/form-data">
        {{csrf_field()}}

    </form>
    <div class="container-fluid container-admin-form">
        <div class="row">
            <div class="col-6 offset-3">
                <h1 class="title">Create Booking</h1>

                @include('admin._alerts')

                <div class="row">
                    <div class="col-12">
                        <h3><a href="javascript:window.history.back();" style="color: #f14444;">Back to filters</a></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @foreach ($cars as $car)
                        <div class="form-card car" data="{{$car['car']['id']}}" style="cursor: pointer;">
                            <div class="form-group">
                                <div class="image-card" style="position: relative;">
                                    <div class="image">
                                        <img src="{{$car['car']['image_s3_url']}}"
                                             class="img-fluid gallery-items" alt="">
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="col-12 car-descr">
                                            <h6>{{$car['car']['category']['name']}} {{$car['car']['model']}}</h6>
                                            <p>Pickup: {{$car['car']['full_pickup_location']}}</p>
                                            <p>Dropoff: {{$car['car']['full_return_location']}}</p>
                                        </div>
                                    </div>
                                    @if($car['car']['allowed_recurring'])
                                    <div style="position: absolute; right: 0px;top: 0px;">
                                        <img src="{{asset('images/recurring.png')}}" alt="" style="width: 30px;height: 30px;border: none;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".car").click(function () {
            var car_id = $(this).attr("data");
            var sPageURL = window.location.search.substring(1);
            document.location.href = "/admin/users/{{$user->id}}/booking/view/"+car_id+"?"+sPageURL;
        });
    });
</script>
@endpush