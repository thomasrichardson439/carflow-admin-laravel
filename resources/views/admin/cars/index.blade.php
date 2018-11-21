@extends('layouts.admin')

@section('content')
    <div class="container-fluid container-admin-list">
        <div class="row">
            <div class="col-6">
                <h1 class="title">Cars</h1>
                <h4 class="subtitle">Manage cars, see usage and get notified on any issues</h4>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a href="{{ url('/admin/cars/create') }}" class="btn btn-danger">
                    <i class="fa fa-plus"></i> Add new car
                </a>
            </div>
        </div>

        @include('admin._alerts')

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
                [
                    'title' => 'Car owner',
                    'value' => 'owner',
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
                            'delete' => url('admin/cars/' . $model->id),
                        ];
                    }
                ]
            ]
        ])->render() !!}
    </div>
@endsection