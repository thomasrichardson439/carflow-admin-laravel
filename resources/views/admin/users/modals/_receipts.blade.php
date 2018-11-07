@php

/** @var App\Models\User $user */

@endphp

<div class="modal admin-modal" id="receipts">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Receipts</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table admin-table table-modal">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->receipts as $receipt)
                            <tr>
                                <td>
                                    <div class="square-image" style="background-image: url({{ $receipt->photo_s3_link }})"></div>
                                </td>
                                <td>
                                    {{ $receipt->title }}
                                </td>
                                <td>
                                    {{ $receipt->receipt_date->format('d/m/Y h:iA') }}
                                </td>
                                <td>
                                    {{ number_format($receipt->price) }}$
                                </td>
                                <td>
                                    {{ $receipt->location }}
                                </td>
                                <td>
                                    <a href="{{ url('/admin/receipts/' . $receipt->id) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No data to display</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>