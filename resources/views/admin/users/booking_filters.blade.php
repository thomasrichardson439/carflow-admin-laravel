@extends('layouts.admin1')

@push("styles")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="{{asset('plugin/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.3.4/css/bootstrap-slider.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/custom_elements.css')}}">
@endpush

@section('content')

    <form action="{{ url('/admin/users/'.$user->id.'/booking/availableForBooking') }}" method="get" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1 class="title">Create Booking</h1>

                    @include('admin._alerts')

                    <div class="row">
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h4>Start</h4>
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
                                    <h4>End</h4>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control" id="end_date" name="available_to"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h4>Vehicle Options</h4>
                                </div>
                                <div class="form-group">
                                    <ul class="unstyled centered">
                                        @foreach ($vehicles as $vehicle)
                                            <li>
                                                <input class="styled-checkbox" id="chk_{{$vehicle->id}}" name="categories[]" type="checkbox" value="{{ $vehicle->id }}" checked>
                                                <label for="chk_{{$vehicle->id}}">{{$vehicle->name}}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="form-card">
                                <div class="form-group">
                                    <input type="hidden" name="allowed_recurring" value="1">
                                    <label class="d-flex align-items-center">
                                        <input class="apple-switch mR-10"
                                               type="checkbox" id="allowed_recurring"
                                               value="1"
                                               checked
                                        >
                                        Only cars available for recurring booking
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h4>Location</h4>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input id="lat" name="pickup_location_lat" type="hidden" value="0">
                                    <input id="lot" name="pickup_location_lon" type="hidden" value="0">
                                    <input id="autocomplete" onFocus="geolocate()" value="" type="text" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Range (miles)</label>
                                </div>
                                <div class="form-group" style="margin-left:15px;margin-right: 15px;">
                                    <input id="range" type="text" class="slider" style="width: 100%;" name="allowed_range_miles" autocomplete="off"
                                           data-provide="slider"
                                           data-slider-ticks="[1, 2, 3, 4, 5, 6]"
                                           data-slider-ticks-labels='["1/2", "1", "2", "5", "10", "10+"]'
                                           data-slider-min="1"
                                           data-slider-max="6"
                                           data-slider-step="1"
                                           data-slider-value="4"
                                           data-slider-tooltip="hide" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            {{--<a href="{{ url('/admin/users') }}" class="btn btn-gray">Cancel</a>--}}
                            <button type="submit" class="btn btn-block btn-danger">Show available car</button>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.3.4/bootstrap-slider.js" type="text/javascript"></script>
<script src="{{asset('plugin/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
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
        var mySlider = $("input.slider").slider();
        $("#allowed_recurring").change(function () {
            if($("#allowed_recurring").is(':checked')){
                $("input[name='allowed_recurring']").val("1");
            }else{
                $("input[name='allowed_recurring']").val("0");
            }
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('params.googleMapsKey') }}&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    var autocomplete;
    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')));
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
//            $("#address").val("");
        $("#lot").val("");
        $("#lat").val("");
        var place = autocomplete.getPlace();
        var location  = place.geometry.location;
//            $("#address").val(place.name);
        $("#lat").val(location.lat());
        $("#lot").val(location.lng());
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
@endpush