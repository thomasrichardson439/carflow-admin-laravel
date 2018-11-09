@php

/** @var App\Models\User $user */

@endphp

<div class="modal admin-modal" id="start-ride-photos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Start ride photos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                @forelse ($user->endedBookings as $index => $booking)
                    <div class="row">
                        <div class="col-12">
                            <h3 class="group" data-toggle="collapse" href="#group-{{ $index }}">
                                <i class="fa fa-caret-down"></i> {{ $booking->booking_starting_at->format('m/d/Y') }}
                            </h3>

                            <table class="table table-modal collapse" id="group-{{ $index }}">
                                <caption>Mileage</caption>
                                <colgroup>
                                    <col width="70">
                                    <col width="200">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="square-image" style="background-image: url({{ $booking->photo_start_mileage_s3_link }})"></div>
                                        </td>
                                        <td>Mileage</td>
                                        <td>{{ $booking->booking_starting_at->format('m/d/Y h:i A') }}</td>
                                        <td><a href="{{ $booking->photo_start_mileage_s3_link }}" target="_blank">View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-12">
                            <p>No data to display</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal admin-modal" id="end-ride-photos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Start ride photos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                @forelse ($user->endedBookings as $index => $booking)

                    @php
                        if ($booking->endedReport == null) continue;
                    @endphp

                    <div class="row">
                        <div class="col-12">
                            <h3 class="group" data-toggle="collapse" href="#group-{{ $index }}">
                                <i class="fa fa-caret-down"></i> {{ $booking->booking_starting_at->format('m/d/Y') }}
                            </h3>

                            <div id="group-{{ $index }}" class="collapse">
                                <table class="table table-modal">
                                    <caption>Car check</caption>
                                    <colgroup>
                                        <col width="70">
                                        <col width="200">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="square-image" style="background-image: url({{ $booking->endedReport->photo_front_s3_link }})"></div>
                                            </td>
                                            <td>Front</td>
                                            <td>{{ $booking->endedReport->created_at->format('m/d/Y h:i A') }}</td>
                                            <td><a href="{{ $booking->endedReport->photo_front_s3_link }}" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="square-image" style="background-image: url({{ $booking->endedReport->photo_back_s3_link }})"></div>
                                            </td>
                                            <td>Back</td>
                                            <td>{{ $booking->endedReport->created_at->format('m/d/Y h:i A') }}</td>
                                            <td><a href="{{ $booking->endedReport->photo_back_s3_link }}" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="square-image" style="background-image: url({{ $booking->endedReport->photo_left_s3_link }})"></div>
                                            </td>
                                            <td>Left</td>
                                            <td>{{ $booking->endedReport->created_at->format('m/d/Y h:i A') }}</td>
                                            <td><a href="{{ $booking->endedReport->photo_left_s3_link }}" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="square-image" style="background-image: url({{ $booking->endedReport->photo_right_s3_link }})"></div>
                                            </td>
                                            <td>Right</td>
                                            <td>{{ $booking->endedReport->created_at->format('m/d/Y h:i A') }}</td>
                                            <td><a href="{{ $booking->endedReport->photo_right_s3_link }}" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-modal">
                                    <caption>Gas tank</caption>
                                    <colgroup>
                                        <col width="70">
                                        <col width="200">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="square-image" style="background-image: url({{ $booking->endedReport->photo_gas_tank_s3_link }})"></div>
                                            </td>
                                            <td>Gas tank indicator</td>
                                            <td>{{ $booking->endedReport->created_at->format('m/d/Y h:i A') }}</td>
                                            <td><a href="{{ $booking->endedReport->photo_gas_tank_s3_link }}" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-modal">
                                    <caption>Mileage</caption>
                                    <colgroup>
                                        <col width="70">
                                        <col width="200">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="square-image" style="background-image: url({{ $booking->endedReport->photo_mileage_s3_link }})"></div>
                                            </td>
                                            <td>Mileage indicator</td>
                                            <td>{{ $booking->endedReport->created_at->format('m/d/Y h:i A') }}</td>
                                            <td><a href="{{ $booking->endedReport->photo_mileage_s3_link }}" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-12">
                            <p>No data to display</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>