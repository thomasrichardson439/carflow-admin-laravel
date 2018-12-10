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

    <form action="{{ url('/admin/users/'.$user->id.'/booking/preview/'.$car['id']) }}" method="get">
        {{csrf_field()}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1 class="title">Create Booking</h1>

                    @include('admin._alerts')

                    <div class="row">
                        <div class="col-12">
                            <h3><a href="javascript:window.history.back();" style="color: #f14444;">Back to available cars</a></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-card">
                                <div class="form-group">
                                    <div class="image">
                                        <img src="{{$car['image_s3_url']}}"
                                             class="img-fluid gallery-items" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <h5>CAR</h5>
                            </div>
                            <div class="form-card">
                                <h3>{{$car['model']}}, {{$car['color']}}, {{$car['year']}}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <h5>VEHICLE TYPE</h5>
                            </div>
                            <div class="form-card">
                                <h3>{{$car['category']['name']}}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <h5>PICKUP</h5>
                            </div>
                            <div class="form-group">
                                <div id="us3" style="width: 100%; height: 400px;"></div>
                                <input type="text" class="form-control" id="us3-address" />
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="us3-lat" readonly />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="us3-lon" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>SCHEDULE</h5>
                                </div>
                                <div class="form-group" style="display: flex;">
                                    <div style="flex: 1;margin-top: 20px;">
                                        <input class="apple-switch mR-10"
                                               type="checkbox" name="allowed_recurring"
                                               value="1"
                                               checked
                                        >
                                    </div>
                                    <div style="flex: 8;">
                                        <label>Create recurring booking</label>
                                        <p>Book this car automatically on every Tuesday, from 10:00AM to 10:00PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>START</h5>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control" id="start_date" name="available_from"  autocomplete="off">
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
                                    <input type="text" class="form-control" id="end_date" name="available_to"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-block btn-danger">Create booking</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh5U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="{{asset('plugin/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('params.googleMapsKey') }}&libraries=places" async defer></script>
{{--<script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?key={{ config('params.googleMapsKey') }}&libraries=geometry,places'></script>--}}
{{--<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('params.googleMapsKey') }}&libraries=places" type="text/javascript"></script>--}}
<script src="{{asset('plugin/locationPicker/locationpicker.jquery.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#start_date').datetimepicker({
            format: "dddd, DD MMM gggg hh:mm A",
            minDate: "{{ date('l, j M Y h:i A', time()) }}"
        });
        $('#end_date').datetimepicker({
            format: "dddd, DD MMM gggg hh:mm A",
            useCurrent: false
        });
        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
        });

        $('#us3').locationpicker({
            location: {
                latitude: 46.15242437752303,
                longitude: 2.7470703125
            },
            radius: 300,
            inputBinding: {
                latitudeInput: $('#us3-lat'),
                longitudeInput: $('#us3-lon'),
                radiusInput: $('#us3-radius'),
                locationNameInput: $('#us3-address')
            },
            enableAutocomplete: true,
            onchanged: function (currentLocation, radius, isMarkerDropped) {
                var addressComponents = $(this).locationpicker('map').location.addressComponents;
                updateControls(addressComponents);
            },
            oninitialized: function(component) {
                var addressComponents = $(component).locationpicker('map').location.addressComponents;
                updateControls(addressComponents);
            }
        });
    });
    function updateControls(addressComponents) {
        console.log(addressComponents);
        $('#us3-street1').val(addressComponents.addressLine1);
//        $('#us5-city').val(addressComponents.city);
//        $('#us5-state').val(addressComponents.stateOrProvince);
//        $('#us5-zip').val(addressComponents.postalCode);
//        $('#us5-country').val(addressComponents.country);
    }
</script>

<script>

</script>
@endpush