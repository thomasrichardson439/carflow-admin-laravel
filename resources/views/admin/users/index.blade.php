@extends('layouts.admin')

@section('content')
    <div class="container-fluid container-admin-list">
        <h1 class="title">Users</h1>
        <h4 class="subtitle">Edit and manually add users</h4>

        {!! grid([
            'dataProvider' => $dataProvider,
            'rowsPerPage' => 20,
            'tableHtmlOptions' => [
                'class' => 'table admin-table',
            ],
            'columns' => [
                'id',
                [
                    'class' => \Woo\GridView\Columns\RawColumn::class,
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
                    'class' => \Woo\GridView\Columns\RawColumn::class,
                    'title' => 'Documents',
                    'value' => function(\App\Models\User $model) {

                        $html = '';

                        if ($model->drivingLicense) {
                            $html .= '<a href="' . url('users/' . $model->id) . '">DL</a> ';
                        }

                        if ($model->tlcLicense) {
                            $html .= '<a href="' . url('users/' . $model->id) . '">TLC</a> ';
                        }

                        return $html;
                    }
                ],
                'ridesharing_apps',
                [
                    'class' => \Woo\GridView\Columns\ActionsColumn::class,
                    'value' => '{show} {edit} {delete}',
                    'contentHtmlOptions' => [
                        'class' => 'actionsColumn',
                    ],
                    'actionsUrls' => function($model) {
                        return [
                            'show' => url('admin/users/' . $model->id),
                            'edit' => url('admin/users/' . $model->id . '#edit'),
                            'delete' => url('admin/users/' . $model->id . '/delete'),
                        ];
                    }
                ]
            ]
        ])->render() !!}
    </div>
@endsection