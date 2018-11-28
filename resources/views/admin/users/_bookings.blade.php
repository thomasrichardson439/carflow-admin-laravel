@php

$columns = [
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'Car',
        'value' => function(\App\Models\Booking $model) {

            return '
                <a href="' . url('/admin/cars/' . $model->car->id) . '" target="_blank">
                    <img src="' . $model->car->image_s3_url . '" class="img-thumbnail mR-10" style="max-width: 40px;">' .
                    $model->car->manufacturer->name . ' ' . $model->car->model .
                '</a>';
        }
    ],
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'Car Plate',
        'value' => function(\App\Models\Booking $model) {
            return $model->car->plate;
        }
    ],
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'Booking Type',
        'value' => function(\App\Models\Booking $model) {
            return $model->is_recurring ? 'Recurring' : 'One-time';
        }
    ],
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'Car Type',
        'value' => function(\App\Models\Booking $model) {
            return $model->car->category->name;
        }
    ],
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'Date',
        'value' => function(\App\Models\Booking $model) {

            if ($model->is_recurring) {
                return 'Every ' . $model->booking_starting_at->format('l');
            }

            return $model->booking_starting_at->format('d F Y');
        }
    ],
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'Start Time',
        'value' => function(\App\Models\Booking $model) {
            return $model->booking_starting_at->format('h:i A');
        }
    ],
    [
        'class' => \Woo\GridView\Columns\RawColumn::class,
        'title' => 'End Time',
        'value' => function(\App\Models\Booking $model) {
            return $model->booking_starting_at->format('h:i A');
        }
    ],
    [
        'class' => \Woo\GridView\Columns\ActionsColumn::class,
        'value' => '{edit} {delete}',
        'contentHtmlOptions' => [
            'class' => 'actionsColumn',
        ],
        'actionsUrls' => function($model) {
            return [
                'edit' => url('admin/users/' . $model->id . '#edit'),
                'delete' => url('admin/users/' . $model->id . '/delete'),
            ];
        }
    ]
];

@endphp

<div class="row">
    <div class="col-12">
        <h3>Recurring bookings</h3>
    </div>
</div>

{!! grid([
    'dataProvider' => $recurringBookingsProvider,
    'rowsPerPage' => 0,
    'tableHtmlOptions' => [
        'class' => 'table admin-table',
    ],
    'columns' => $columns,
])->render() !!}


<div class="row">
    <div class="col-12">
        <h3>One-time bookings</h3>
    </div>
</div>

{!! grid([
    'dataProvider' => $oneTimeBookingsProvider,
    'rowsPerPage' => 0,
    'tableHtmlOptions' => [
        'class' => 'table admin-table',
    ],
    'columns' => $columns,
])->render() !!}