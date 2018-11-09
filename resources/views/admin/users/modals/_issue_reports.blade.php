@php

    /** @var App\Models\User $user */

@endphp

<div class="modal admin-modal" id="malfunctions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Malfunctions</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                {!! grid([
                    'tableHtmlOptions' => [
                        'class' => 'table admin-table table-modal',
                    ],
                    'dataProvider' => new \Woo\GridView\DataProviders\EloquentDataProvider($user->malfunctions()->getQuery()),
                    'columns' => [
                        [
                            'class' => 'raw',
                            'title' => 'Date',
                            'value' => function(\App\Models\BookingIssueReport $report) {
                                return $report->created_at->format('d/m/Y h:iA');
                            }
                        ],
                    ]
                ]) !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal admin-modal" id="accidents">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Accidents</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                {!! grid([
                    'tableHtmlOptions' => [
                        'class' => 'table admin-table table-modal',
                    ],
                    'dataProvider' => new \Woo\GridView\DataProviders\EloquentDataProvider($user->accidents()->getQuery()),
                    'columns' => [
                        [
                            'class' => 'raw',
                            'title' => 'Date',
                            'value' => function(\App\Models\BookingIssueReport $report) {
                                return $report->created_at->format('d/m/Y h:iA');
                            }
                        ],
                    ]
                ]) !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>