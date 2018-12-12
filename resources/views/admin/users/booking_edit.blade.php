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

    <form action="{{ url('/admin/users/'.$user->id.'/booking/complete/'.$car['id']) }}" method="post">
        {{csrf_field()}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1 class="title">Create Booking</h1>
                    <div class="alert alert-danger mb-3 main-font" id="custom-validation-errors"></div>
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
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>CAR</h5>
                                </div>
                                <div class="form-group">
                                    <h3>{{$car['model']}}, {{$car['color']}}, {{$car['year']}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>VEHICLE TYPE</h5>
                                </div>
                                <div class="form-group">
                                    <h3>{{$car['category']['name']}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>PICKUP</h5>
                                </div>
                                <div class="form-group">
                                    {{--<input id="pickup_location_lat" name="pickup_location_lat" type="hidden" value="{{$car['pickup_location_lat']}}">--}}
                                    {{--<input id="pickup_location_lon" name="pickup_location_lon" type="hidden" value="{{$car['pickup_location_lon']}}">--}}
                                    {{--<input id="full_pickup_location" name="full_pickup_location" onFocus="geolocate_pickup()" type="text" class="form-control" value="{{$car['full_pickup_location']}}" readonly />--}}
                                    <label>{{$car['full_pickup_location']}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-card">
                                <div class="form-group">
                                    <h5>RETURN</h5>
                                </div>
                                <div class="form-group">
                                    {{--<input id="return_location_lat" name="return_location_lat" type="hidden" value="{{$car['return_location_lat']}}">--}}
                                    {{--<input id="return_location_lon" name="return_location_lon" type="hidden" value="{{$car['return_location_lon']}}">--}}
                                    {{--<input id="full_return_location" name="full_return_location" onFocus="geolocate_return()" type="text" class="form-control" value="{{$car['full_return_location']}}" readonly/>--}}
                                    <label>{{$car['full_return_location']}}</label>
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
                                        <input type="hidden" name="is_recurring" value="{{ $car['allowed_recurring'] ? "1" : "0" }}">
                                        <input class="apple-switch mR-10"
                                               type="checkbox" id="is_recurring"
                                               value="1"
                                               {{ $car['allowed_recurring'] ? "checked" : "" }}
                                        >
                                    </div>
                                    <div style="flex: 8;">
                                        <label>Create recurring booking</label>
                                        <p>Book this car automatically on every Tuesday, from 10:00AM to 10:00PM</p>
                                        {{--<p>Book this car automatically on every selected date</p>--}}
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
                                    <input type="hidden" name="calendar_date_from" value="">
                                    <input type="text" class="form-control" id="start_date"  autocomplete_pickup="off">
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    <select id="start_time" class="form-control" disabled></select>
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
                                    <input type="hidden" name="calendar_date_to" value="">
                                    <input type="text" class="form-control" id="end_date"  autocomplete_pickup="off" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    <select id="end_time" class="form-control" disabled></select>
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
{{--<script src="{{asset('plugin/locationPicker/locationpicker.jquery.js')}}"></script>--}}
<script type="text/javascript">
    var Calendar = JSON.parse('{!! $calendar !!}');
    var enableStartDate = [];
    var selectedStartDate = "";
    var selectedStartTime = "";
    var selectedEndDate = "";
    var selectedEndTime = "";
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
        for(var i = 0; i < Calendar.length; i ++){
            console.log(Calendar[i]);
        }
        for(var j in Calendar){
            if(Calendar[j].length > 0){
                enableStartDate.push(j)
            }
        }
        console.log(enableStartDate.length)
        if(enableStartDate.length == 0){
            $("#custom-validation-errors").show();
            $("#custom-validation-errors").html("Please select start date");
            $('#start_date').attr("disabled", true);
            return false;
        }
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
            console.log(valid_hours)
            for(var j = 0;j < valid_hours.length; j++){
                valid_hours[j] = parseInt(valid_hours[j]) + 1;
            }
            console.log(valid_hours)
            for(var k in rows){
                if(jQuery.inArray(parseInt(k), valid_hours) !== -1 && parseInt(k) >= parseInt(selectedStartTime)){
                    html += "<option value='"+k+"' style='color:red;'>"+rows[k]+"</option>";
                }else{
                    html += "<option value='"+k+"' disabled>"+rows[k]+"</option>";
                }
            }
        }

        return html;
    }
    $(document).ready(function () {
        initCalendar();
        $("#custom-validation-errors").hide();
        $('#start_date').datetimepicker({
            format: "dddd, DD MMM gggg",
            useCurrent: false,
            enabledDates: enableStartDate,
            {{--minDate: "{{ date('l, j M Y h:i A', time()) }}"--}}
        });

        $("#start_date").on("dp.change", function (e) {
            var day = e.date.format('dddd');
            var d = e.date.format('DD');
            var m = e.date.format('MM');
            var y = e.date.format('gggg');
            selectedStartDate = y+"-"+m+"-"+d;
            $("#start_time").attr("disabled", false);
            $("#start_time").html(update_time("start"));
            selectedStartTime = Calendar[selectedStartDate][0];
            $('#end_date').attr("disabled", false);
            $('#end_date').datetimepicker({
                format: "dddd, DD MMM gggg",
                enabledDates: [selectedStartDate],
                useCurrent: false
            });
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
            var arrEndTime = generateTimeSlots("00");
            var endTime = arrEndTime[selectedEndTime];
            $("input[name='calendar_date_from']").val(selectedStartDate + " " + startTime);
            $("input[name='calendar_date_to']").val(selectedEndDate + " " + endTime);
            return true;
        });
    });

</script>

@endpush