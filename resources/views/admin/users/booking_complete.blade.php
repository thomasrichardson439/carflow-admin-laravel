@extends('layouts.admin1')

@push("styles")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@endpush

@section('content')

    <div class="container-fluid container-admin-form">
        <div class="row">
            <div class="col-6 offset-3">
                @include('admin._alerts')
                <div class="row form-card">
                    <div class="col-12">
                        <h1 class="title">Booking created!</h1>
                        <div class="form-group" style="margin: 60px 0;">
                            <div class="image">
                                <img src="{{ asset('images/welcom_t.png') }}" class="gallery-items" alt="" style="max-width: 300px;margin-top: 20px;margin-left: auto;margin-right: auto;display: block;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 offset-2">
                                @php
                                    $timestampStart = strtotime($booking['booking_starting_at']['formatted']);
                                    $timestampEnd = strtotime($booking['booking_ending_at']['formatted']);
                                    $timestampEnd += 60;
                                @endphp
                                <p>You have successfully created a booking on {{date('j M Y',$timestampStart)}} on {{date('l',$timestampStart)}} from {{date('h:i A',$timestampStart)}} to {{date('h:i A',$timestampEnd)}} on {{ $booking['car']['manufacturer']['name'] }} {{$booking['car']['model']}}.</p>
                            </div>
                            <div class="col-12 text-center" style="margin-top: 30px">
                                <a href="{{url('admin/users/'.$user->id.'?booking=1')}}" class=" btn-block" style="color: #f14444;padding: 4px;border: 1px solid #ddd;border-radius: 3px;text-decoration: none;font-size: 20px;">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh5U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
    });

</script>
@endpush