@php

    /** @var App\Models\User $user */

@endphp

<div class="modal admin-modal" id="booked-cars">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Booked Cars</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                {!! grid([
                    'tableHtmlOptions' => [
                        'class' => 'table admin-table table-modal',
                    ],
                    'dataProvider' => new \Woo\GridView\DataProviders\EloquentDataProvider($user->bookings()->getQuery()),
                    'columns' => [
                        [
                            'class' => 'raw',
                            'title' => 'Car',
                            'value' => function(\App\Models\Booking $booking) {
                                return $booking->car->manufacturer->name . ' ' . $booking->car->model;
                            },
                        ],
                        [
                            'class' => 'raw',
                            'title' => 'Date',
                            'value' => function(\App\Models\Booking $booking) {
                                return $booking->created_at->format('d/m/Y h:iA');
                            }
                        ],
                        [
                            'class' => 'actions',
                            'value' => '{show}',
                            'actionsUrls' => function($model) {
                                return [
                                    'show' => url('admin/cars/' . $model->car->id),
                                ];
                            }
                        ]
                    ]
                ]) !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>