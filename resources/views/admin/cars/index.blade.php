@extends('layouts.admin')

@section('content')
    <div class="container-fluid container-admin-list">
        <h1 class="title">Cars</h1>
        <h4 class="subtitle">Manage cars, see usage and get notified on any issues</h4>

        {!! grid([
            'dataProvider' => $dataProvider,
            'rowsPerPage' => 20,
            'tableHtmlOptions' => [
                'class' => 'table admin-table',
            ],
            'columns' => [
                'id',
                [
                    'class' => 'raw',
                    'title' => 'Car maker',
                    'value' => function (\App\Models\Car $model) {
                        return $model->manufacturer->name;
                    }
                ],
                [
                    'title' => 'Car model',
                    'value' => 'model',
                ],
                [
                    'title' => 'Year of production',
                    'value' => 'year',
                ],
                // [
                    // 'title' => 'Car owner',
                    // 'value' => 'car_owner',
                // ],
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