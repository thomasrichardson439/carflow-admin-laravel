@extends('layouts.admin')

@section('content')
    <div class="container-fluid container-admin-list">
        <h1 class="title">Receipts</h1>
        <h4 class="subtitle">Review and manually add receipts</h4>

        {!! grid([
            'dataProvider' => $dataProvider,
            'rowsPerPage' => 20,
            'tableHtmlOptions' => [
                'class' => 'table admin-table',
            ],
            'columns' => [
                'id',
                [
                    'title' => 'Receipt kind',
                    'value' => 'title',
                ],
                [
                    'class' => 'raw',
                    'title' => 'Amount',
                    'value' => function(\App\Models\BookingReceipt $receipt) {
                        return '$' . number_format($receipt->price);
                    },
                ],
                'location',
                [
                    'class' => 'raw',
                    'title' => 'Date',
                    'value' => function (\App\Models\BookingReceipt $receipt) {
                        return $receipt->created_at->format('d M Y');
                    },
                ],
                [
                    'class' => 'raw',
                    'title' => 'Time',
                    'value' => function (\App\Models\BookingReceipt $receipt) {
                        return $receipt->created_at->format('h:iA');
                    },
                ],
                [
                    'class' => 'actions',
                    'value' => '{show} {edit} {delete}',
                    'contentHtmlOptions' => [
                        'class' => 'actionsColumn',
                    ],
                    'actionsUrls' => function($model) {
                        return [
                            'show' => url('admin/cars/' . $model->id),
                            'edit' => url('admin/cars/' . $model->id . '#edit'),
                            'delete' => url('admin/cars/' . $model->id . '/delete'),
                        ];
                    }
                ]
            ]
        ])->render() !!}
    </div>
@endsection