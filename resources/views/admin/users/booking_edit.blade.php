@extends('layouts.admin1')

@push("styles")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="{{asset('plugin/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/custom_elements.css')}}">
<style>
    .image-card img{
        height: 250px;
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ddd;
    }
</style>
@endpush

@section('content')

    {{--<form action="{{ url('/admin/users/'.$user->id.'/booking/complete/'.$booking['car']['id']) }}" method="post">--}}
        {{--{{csrf_field()}}--}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1 class="title">Edit Booking</h1>
                    <div class="alert alert-danger mb-3 main-font" id="custom-validation-errors"></div>
                    @include('admin._alerts')
                    <div class="row">
                        <div class="col-12">
                            <h3><a href="{{url('admin/users/'.$user->id.'?booking=1')}}" style="color: #f14444;">Back</a></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-card">
                                <div class="form-group">
                                    <div class="image">
                                        <img src="{{$booking['car']['image_s3_url']}}"
                                             class="img-fluid gallery-items" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>CAR</h5>
                                </div>
                                <div class="form-group">
                                    <h3>{{ $booking['car']['manufacturer']['name'] }} {{$booking['car']['model']}}, {{$booking['car']['color']}}, {{$booking['car']['year']}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>VEHICLE TYPE</h5>
                                </div>
                                <div class="form-group">
                                    <h3>{{$booking['car']['category']['name']}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>PICKUP</h5>
                                </div>
                                <div class="form-group">
                                    <label>{{$booking['car']['full_pickup_location']}}</label>
                                    <a href="#modalMap1" data-toggle="modal" style="color:#ff0000;">Open in Maps</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>RETURN</h5>
                                </div>
                                <div class="form-group">
                                    <label>{{$booking['car']['full_return_location']}}</label>
                                    <a href="#modalMap2" data-toggle="modal" style="color:#ff0000;">Open in Maps</a>
                                </div>
                            </div>
                        </div>
                        @php
                            $timestampStart = strtotime($booking['booking_starting_at']['formatted']);
                            $timestampEnd = strtotime($booking['booking_ending_at']['formatted']);
                            $timestampEnd += 60;
                        @endphp
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>START</h5>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    {{--<input type="hidden" name="calendar_date_from" value="">--}}
                                    {{--<input type="text" class="form-control" id="start_date" value="" readonly>--}}
                                    <p>{{date('l, j M Y', $timestampStart)}}</p>
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    {{--<select id="start_time" class="form-control" disabled></select>--}}
                                    <p>{{date('h:i A', $timestampStart)}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>END</h5>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    {{--<input type="hidden" name="calendar_date_to" value="">--}}
                                    {{--<input type="text" class="form-control" id="end_date"  autocomplete_pickup="off" disabled>--}}
                                    <p>{{date('l, j M Y', $timestampEnd)}}</p>
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    {{--<select id="end_time" class="form-control" disabled></select>--}}
                                    <p>{{date('h:i A', $timestampEnd)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-left">
                            <a href="{{url('admin/users/'.$user->id.'/booking/delete/' . $booking['id'])}}" style="color: red;">Cancel booking</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--</form>--}}
    <div id="modalMap1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div id="map1" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="modalMap2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div id="map2" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{{asset('plugin/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="{{asset('plugin/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
{{--<script src="{{asset('plugin/locationPicker/locationpicker.jquery.js')}}"></script>--}}
<script type="text/javascript">

    $(document).ready(function () {
        $("#custom-validation-errors").hide();

    });

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('params.googleMapsKey') }}&callback=initMap"></script>
<script>
    var lat1 = '{{$booking['car']['pickup_location_lat']}}';
    var lon1 = '{{$booking['car']['pickup_location_lon']}}';
    var lat2 = '{{$booking['car']['return_location_lat']}}';
    var lon2 = '{{$booking['car']['return_location_lon']}}';
    function initMap() {
        var myLatLng = {lat: parseFloat(lat1), lng: parseFloat(lon1)};
        var map = new google.maps.Map(document.getElementById('map1'), {
            zoom: 8,
            center: myLatLng
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
        var myLatLng2 = {lat: parseFloat(lat2), lng: parseFloat(lon2)};
        var map2 = new google.maps.Map(document.getElementById('map2'), {
            zoom: 8,
            center: myLatLng2
        });
        var marker2 = new google.maps.Marker({
            position: myLatLng2,
            map: map2,
            title: 'Hello World!'
        });
    }

</script>
@endpush