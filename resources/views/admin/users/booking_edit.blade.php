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
    .image-card img.avatar{
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

    {{--<form action="{{ url('/admin/users/'.$user->id.'/booking/complete/'.$booking['car']['id']) }}" method="post">--}}
        {{--{{csrf_field()}}--}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-6 offset-3" style="background: white;padding-top: 20px;padding-bottom: 20px;">
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
                                    <label>{{$booking['car']['full_pickup_location']}}</label></br>
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
                                    <label>{{$booking['car']['full_return_location']}}</label></br>
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
                                    <input type="text" class="form-control" id="start_date" value="{{date('l, j M Y', $timestampStart)}}">
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    <select id="start_time" class="form-control"></select>
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
                                    <input type="text" class="form-control" id="end_date" value="{{date('l, j M Y', $timestampEnd)}}">
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    <select id="end_time" class="form-control"></select>
                                    {{--<p>{{date('h:i A', $timestampEnd)}}</p>--}}
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
            <div class="row">
                <div class="col-6 offset-3" style="background: white;margin-top: 30px;padding-top: 20px;">
                    <h1 class="title">Change car</h1>

                    <div class="row">
                        <div class="col-12">
                            <h3><a href="{{url('admin/users/'.$user->id.'/booking/create/')}}" style="color: #f14444;">Back to booking</a></h3>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            @foreach ($cars as $car)
                                <div class="form-card car" data="{{$car['car']['id']}}" style="cursor: pointer;">
                                    <div class="form-group">
                                        <div class="image-card" style="position: relative;">
                                            <div class="image">
                                                <img src="{{$car['car']['image_s3_url']}}"
                                                     class="img-fluid gallery-items avatar" alt="">
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

<script type="text/javascript">
    var Calendar = JSON.parse('{!! $calendar !!}');
    var enableStartDate = [];
    var selectedStartDate = "{{date('Y-m-d', $timestampStart)}}";
    var strStartTime = "{{date('H', $timestampStart)}}";
    var selectedStartTime = parseInt(strStartTime) - 1;
    var selectedEndDate = "{{date('Y-m-d', $timestampStart)}}";
    var strEndTime = "{{date('H', $timestampEnd)}}";
    var selectedEndTime = parseInt(strEndTime) - 1;
    function generateTimeSlots(minute) {

        let slots = {0: '12:' + minute + ' AM'}

        for (let i = 1; i <= 23; i++) {
            let _i = i;
            if (i === 12) {
                slots[12] = '12:' + minute + ' PM';
                continue;
            }

            if (_i > 12) {
                _i -= 12;
            }

            if (_i < 10) {
                _i = '0' + _i.toString();
            }
            slots[i] = _i + ':' + minute + ' ' + (i > 12 ? 'PM' : 'AM');
        }

        return slots;
    }
    function initCalendar() {

        for(var j in Calendar){
            if(Calendar[j].length > 0){
                enableStartDate.push(j)
            }
        }
        if(enableStartDate.length == 0){
            $("#custom-validation-errors").show();
            $("#custom-validation-errors").html("There is not available time");
            $('#start_date').attr("disabled", true);
            return false;
        }
        $("#start_time").html(update_time("start"));
        $("#end_time").html(update_time("end"));
    }
    function update_time(str){
        var html = "";
        var rows = generateTimeSlots("00");
        var valid_hours = Calendar[selectedStartDate];
        if(str == "start"){
            for(var k in rows){
                if(jQuery.inArray(parseInt(k), valid_hours) !== -1){
                    html += "<option value='"+k+"' style='color:red;'>"+rows[k]+"</option>";
                }else{
                    html += "<option value='"+k+"' disabled>"+rows[k]+"</option>";
                }
            }
        }else{
            var end_hours = [];
            for(var j = 0;j < valid_hours.length; j++){
                end_hours[j] = parseInt(valid_hours[j]) + 1;
            }
            for(var k in rows){
                if(jQuery.inArray(parseInt(k), end_hours) !== -1 && parseInt(k) > parseInt(selectedStartTime)){
                    html += "<option value='"+k+"' style='color:red;'>"+rows[k]+"</option>";
                }else{
                    html += "<option value='"+k+"' disabled>"+rows[k]+"</option>";
                }
            }
        }

        return html;
    }
    var endDatePicker = "";
    $(document).ready(function () {
        $(".car").click(function () {
            var car_id = $(this).attr("data");
            var sPageURL = window.location.search.substring(1);
            document.location.href = "/admin/users/{{$user->id}}/booking/view/"+car_id;
        });
        $("#custom-validation-errors").hide();
        initCalendar();
        $('#start_date').datetimepicker({
            format: "dddd, DD MMM gggg",
            useCurrent: false,
            enabledDates: enableStartDate,
            {{--minDate: "{{ date('l, j M Y h:i A', time()) }}"--}}
        });
        endDatePicker = $('#end_date').datetimepicker({
            format: "dddd, DD MMM gggg",
            useCurrent: false,
            enabledDates: [selectedEndDate],
        });

        $("#start_date").on("dp.change", function (e) {
            var day = e.date.format('dddd');
            var d = e.date.format('DD');
            var m = e.date.format('MM');
            var y = e.date.format('gggg');
            selectedStartDate = y+"-"+m+"-"+d;
            $("#start_time").html(update_time("start"));
            selectedStartTime = Calendar[selectedStartDate][0];
            if(endDatePicker != ""){
                $('#end_date').datetimepicker('destroy');
                endDatePicker = $('#end_date').datetimepicker({
                    format: "dddd, DD MMM gggg",
                    date: selectedStartDate,
                    enabledDates: [selectedStartDate],
                    useCurrent: false
                });
            }else{
                endDatePicker = $('#end_date').datetimepicker({
                    format: "dddd, DD MMM gggg",
                    enabledDates: [selectedStartDate],
                    useCurrent: false
                });
            }
        });
        $("#end_date").on("dp.change", function (e) {
            var day = e.date.format('dddd');
            var d = e.date.format('DD');
            var m = e.date.format('MM');
            var y = e.date.format('gggg');
            selectedEndDate = y+"-"+m+"-"+d;
            $('#end_time').attr("disabled", false);
            $("#end_time").html(update_time("end"));
        });
        $("#start_time").change(function () {
            selectedStartTime = $(this).val();
            $("#end_time").html(update_time("end"));
        });
        $("#is_recurring").change(function () {
            if($("#is_recurring").is(':checked')){
                $("input[name='is_recurring']").val("1");
            }else{
                $("input[name='is_recurring']").val("0");
            }
        });
        $("form").submit(function (e) {
            $("#custom-validation-errors").hide();
            selectedEndTime = $("#end_time").val();
            if(selectedStartDate == ""){
                $("#custom-validation-errors").show();
                $("#custom-validation-errors").html("Please select start date");
                e.preventDefault();
                return false;
            }else if(selectedStartTime == ""){
                $("#custom-validation-errors").show();
                $("#custom-validation-errors").html("Please select start time");
                e.preventDefault();
                return false;
            }else if(selectedEndDate == ""){
                $("#custom-validation-errors").show();
                $("#custom-validation-errors").html("Please select end date");
                e.preventDefault();
                return false;
            }else if(selectedEndTime == ""){
                $("#custom-validation-errors").show();
                $("#custom-validation-errors").html("Please select end time");
                e.preventDefault();
                return false;
            }
            var arrStartTime = generateTimeSlots("00");
            var startTime = arrStartTime[selectedStartTime];
            var arrEndTime = generateTimeSlots("59");
            var endTime = arrEndTime[parseInt(selectedEndTime)-1];
            console.log("startTime :: ", startTime)
            console.log("endTime :: ", endTime)
            $("input[name='calendar_date_from']").val(selectedStartDate + " " + startTime);
            $("input[name='calendar_date_to']").val(selectedEndDate + " " + endTime);
            return true;
        });
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