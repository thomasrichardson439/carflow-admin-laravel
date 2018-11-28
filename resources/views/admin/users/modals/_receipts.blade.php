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
                {!! grid([
                    'rowsPerPage' => 0,
                    'tableHtmlOptions' => [
                        'class' => 'table admin-table table-modal',
                    ],
                    'dataProvider' => new \Woo\GridView\DataProviders\EloquentDataProvider($user->receipts()->getQuery()),
                    'columns' => [
                        [
                            'class' => 'raw',
                            'title' => 'Photo',
                            'value' => function(\App\Models\BookingReceipt $receipt) {
                                return '<div class="square-image" style="background-image: url(' . $receipt->photo_s3_link . ')"></div>';
                            },
                        ],
                        [
                            'class' => 'attribute',
                            'title' => 'Type',
                            'value' => 'title'
                        ],
                        [
                            'class' => 'raw',
                            'title' => 'Date',
                            'value' => function(\App\Models\BookingReceipt $receipt) {
                                return $receipt->created_at->format('d/m/Y h:iA');
                            }
                        ],
                        [
                            'class' => 'raw',
                            'title' => 'Price',
                            'value' => function(\App\Models\BookingReceipt $receipt) {
                                return number_format($receipt->price) . '$';
                            }
                        ],
                        [
                            'class' => 'actions',
                            'value' => '{show}',
                            'actionsUrls' => function($model) {
                                return [
                                    'show' => url('admin/receipts/' . $model->id),
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