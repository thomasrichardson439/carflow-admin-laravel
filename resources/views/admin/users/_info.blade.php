<div class="row">
    <div class="col-12">
        <h3>Personal information</h3>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-card">
            <h4>Name</h4>
            <div @if(!empty($updateRequest->full_name)) data-toggle="tooltip" title="Old value: {{ $user->full_name }}" class="form-group highlighted" @else class="form-group" @endif >
                <label>Full name</label>
                <input type="text" name="full_name" value="{{ old('full_name', !empty($updateRequest->full_name) ? $updateRequest->full_name : $user->full_name) }}" class="form-control">
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-card">
            <h4>Contact</h4>
            <div @if(!empty($updateRequest->email)) data-toggle="tooltip" title="Old value: {{ $user->email }}" class="form-group highlighted" @else class="form-group" @endif >
                <label>Email</label>
                <input type="text" name="email" value="{{ old('email', !empty($updateRequest->email) ? $updateRequest->email : $user->email) }}" class="form-control">
            </div>
            <div @if(!empty($updateRequest->phone)) data-toggle="tooltip" title="Old value: {{ $user->phone }}" class="form-group highlighted" @else class="form-group" @endif >
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', !empty($updateRequest->phone) ? $updateRequest->phone : $user->phone) }}" class="form-control">
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-card">
            <h4>Address</h4>
            <div @if(!empty($updateRequest->address)) data-toggle="tooltip" title="Old value: {{ $user->address }}" class="form-group highlighted" @else class="form-group" @endif >
                <label>Address</label>
                <input type="text" name="address" value="{{ old('address', !empty($updateRequest->address) ? $updateRequest->address : $user->address) }}" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h3>Driving information</h3>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-card">
            <h4>Driving License</h4>

            <div class="form-group">
                <label>Front side</label>

                @if($user->drivingLicense)
                    <div class="image-card">
                        <div class="image">
                            <img src="{{$user->drivingLicense->front}}"
                                 data-high-res-src="{{$user->drivingLicense->front}}"
                                 class="img-thumbnail gallery-items" alt="">
                        </div>
                        <div class="text">
                            <a href="{{ $user->drivingLicense->front }}">{{ basename($user->drivingLicense->front) }}</a>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No photo uploaded</p>
                @endif
            </div>
            <hr>
            <div class="form-group">
                <label>Back side</label>

                @if($user->drivingLicense)
                    <div class="image-card">
                        <div class="image">
                            <img src="{{$user->drivingLicense->back}}"
                                 data-high-res-src="{{$user->drivingLicense->back}}"
                                 class="img-thumbnail gallery-items" alt="">
                        </div>
                        <div class="text">
                            <a href="{{ $user->drivingLicense->back }}">{{ basename($user->drivingLicense->back) }}</a>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No photo uploaded</p>
                @endif
            </div>
        </div>
        <div class="form-card">
            <h4>Policy</h4>

            <div class="form-group">
                <label>Policy number</label>
                <input type="text" class="form-control">
            </div>

            <button class="btn btn-primary" disabled>Send query</button>
        </div>
    </div>

    <div class="col-4">
        <div class="form-card">
            <h4>TLC License</h4>

            <div class="form-group">
                <label>Front side</label>

                @if($user->tlcLicense)
                    <div class="image-card">
                        <div class="image">
                            <img src="{{$user->tlcLicense->front}}"
                                 data-high-res-src="{{$user->tlcLicense->front}}"
                                 class="img-thumbnail gallery-items" alt="">
                        </div>
                        <div class="text">
                            <a href="{{ $user->tlcLicense->front }}">{{ basename($user->tlcLicense->front) }}</a>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No photo uploaded</p>
                @endif
            </div>
            <hr>
            <div class="form-group">
                <label>Back side</label>

                @if($user->tlcLicense)
                    <div class="image-card">
                        <div class="image">
                            <img src="{{$user->tlcLicense->back}}"
                                 data-high-res-src="{{$user->tlcLicense->back}}"
                                 class="img-thumbnail gallery-items" alt="">
                        </div>
                        <div class="text">
                            <a href="{{ $user->tlcLicense->back }}">{{ basename($user->tlcLicense->back) }}</a>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No photo uploaded</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-card">
            <h4>Ridesharing Apps</h4>
            <ul class="fa-ul apps-list edit-off">
                @foreach ($user->ridesharing_apps_list as $app)
                    <li><i class="fa fa-check"></i> {{ $app }}</li>
                @endforeach
            </ul>

            <ul class="fa-ul apps-list edit-on">
                @foreach (old('ridesharing_app', $user->ridesharing_apps_list) as $app)
                    <li>
                        <label class="d-flex align-items-center">
                            <input class="apple-switch mR-10"
                                   type="checkbox" name="ridesharing_apps[{{ $app }}]"
                                   value="{{ $app }}"
                                   checked
                            >
                            {{ $app }}
                        </label>
                    </li>
                @endforeach
                <li>
                    <input type="text" class="form-control" placeholder="Specify other apps" name="ridesharing_app_additional">
                    <p class="muted small">Separate multiple by comma</p>
                </li>
            </ul>
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