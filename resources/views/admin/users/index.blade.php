@extends('layouts.admin')

@section('content')
    <div class="container-fluid container-admin-list">

        <div class="row">
            <div class="col-6">
                <h1 class="title">Users</h1>
                <h4 class="subtitle">Edit and manually add users</h4>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a href="{{ url('/admin/users/create') }}" class="btn btn-danger">
                    <i class="fa fa-plus"></i> Add new user
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
                    'title' => 'Status',
                    'value' => function(\App\Models\User $model) {

                        if ($model->status == 'pending') {
                            return '<span class="admin-label label-warning">Pending</span>';

                        } elseif ($model->status == 'rejected') {
                            return '<span class="admin-label label-danger">Rejected</span>';
                        }

                        if ($model->profileUpdateRequest !== null) {

                            switch ($model->profileUpdateRequest->status) {
                                case 'pending':
                                    return '<span class="admin-label label-warning">Profile Pending</span>';

                                case 'rejected':
                                    return '<span class="admin-label label-warning">Profile Rejected</span>';
                            }
                        }

                        return '<span class="admin-label label-success">Approved</span>';
                    }
                ],
                'full_name',
                [
                    'value' => 'email',
                    'contentFormat' => 'email',
                    'contentHtmlOptions' => ['class' => 'small-font'],
                ],
                [
                    'value' => 'address',
                    'contentHtmlOptions' => ['class' => 'small-font'],
                ],
                [
                    'value' => 'phone',
                    'contentHtmlOptions' => ['class' => 'small-font'],
                ],
                [
                    'class' => 'raw',
                    'title' => 'Documents',
                    'value' => function(\App\Models\User $model) {

                        $html = '';

                        if ($model->drivingLicense) {
                            $html .= '<a href="' . url('admin/users/' . $model->id) . '">DL</a> ';
                        }

                        if ($model->tlcLicense) {
                            $html .= '<a href="' . url('admin/users/' . $model->id) . '">TLC</a> ';
                        }

                        return $html;
                    }
                ],
                'ridesharing_apps',
                [
                    'class' => 'actions',
                    'value' => '{show} {edit} {delete}',
                    'contentHtmlOptions' => [
                        'class' => 'actionsColumn',
                    ],
                    'actionsUrls' => function($model) {
                        return [
                            'show' => url('admin/users/' . $model->id),
                            'edit' => url('admin/users/' . $model->id . '#edit'),
                            'delete' => url('admin/users/' . $model->id),
                        ];
                    }
                ]
            ]
        ])->render() !!}
    </div>
@endsection