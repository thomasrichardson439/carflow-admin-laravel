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
            return $model->booking_ending_at->format('h:i A');
        }
    ],
    [
        'class' => \Woo\GridView\Columns\ActionsColumn::class,
        'value' => '{show} {cancel}',
        'additionalActions'=>['cancel' => function($model) {
                return '
                    <a class="deleteButton" href="' . url('admin/users/'.$model->user_id.'/booking/delete/' . $model->id ) . '"
                            onclick="if(!confirm(\'Are you sure want to cancel this item?\')) return false;"
                        >Cancel</a>
                ';
            }],
        'contentHtmlOptions' => [
            'class' => 'actionsColumn',
        ],
        'actionsUrls' => function($model) {
            return [
                'show' => url('admin/users/'.$model->user_id.'/booking/edit/' . $model->id)
            ];
        }
    ]
];

@endphp

<div class="row">
    <div class="col-12 d-flex justify-content-start align-items-center">
        <a href="{{ url('/admin/users/'.$user->id.'/booking/create') }}" class="btn btn-danger">
            <i class="fa fa-plus"></i> Create Booking
        </a>
    </div>
</div>
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