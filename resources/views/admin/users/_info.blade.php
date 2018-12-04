<div class="row">
    <div class="col-4">
        <div class="form-card">
            <h4>Policy</h4>

            <div class="form-group">
                <label>Policy number</label>
                <input type="text" class="form-control" name="policy_number" value="{{ old('policy_number', $user->policy_number) }}">
            </div>

            <a class="btn btn-primary" href="{{ url('admin/users/' . $user->id . '/policy') }}">Send mail</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h3>Statistics</h3>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-card">
            <h4>Booking details</h4>

            <div class="info">
                <p class="title">Total numbers of cars booked</p>
                <p class="content"><a href="#" data-toggle="modal" data-target="#booked-cars">{{ $user->bookings()->count() }}</a></p>
            </div>

            <div class="info">
                <p class="title">Currently booked car</p>
                <p class="content">
                    @if ($user->lastBooking)
                        <a href="{{ url('admin/cars/' . $user->lastBooking->car->id) }}">
                            {{ $user->lastBooking->car->manufacturer->name }}
                            {{ $user->lastBooking->car->model }}
                        </a>
                        @else
                        &mdash;
                    @endif
                </p>
            </div>

            <div class="info">
                <p class="title">Average booking time</p>
                <p class="content">
                    {{ round($averageBookingTime, 2) }} hours
                </p>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-card">
            <h4>Events</h4>

            <div class="info">
                <p class="title">Receipts</p>
                <p class="content">{{ $user->receipts()->count() }} receipts <a href="#" data-toggle="modal" data-target="#receipts">Show</a></p>
            </div>

            <div class="info">
                <p class="title">Number of car malfunctions</p>
                <p class="content">{{ $user->accidents()->count() }} malfunctions <a href="#" data-toggle="modal" data-target="#malfunctions">Show</a></p>
            </div>

            <div class="info">
                <p class="title">Number of accidents</p>
                <p class="content">{{ $user->accidents()->count() }} accidents <a href="#" data-toggle="modal" data-target="#accidents">Show</a></p>
            </div>

            <div class="info">
                <p class="title">Number of booking cancellations</p>
                <p class="content">{{ $user->canceledBookings()->count() }}</p>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-card">
            <h4>Ride photos</h4>

            <div class="info">
                <p class="title">Start ride photos</p>
                <p class="content"><a href="#" data-toggle="modal" data-target="#start-ride-photos">Open photos</a></p>
            </div>

            <div class="info">
                <p class="title">End ride photos</p>
                <p class="content"><a href="#" data-toggle="modal" data-target="#end-ride-photos">Open photos</a></p>
            </div>
        </div>
    </div>
</div>