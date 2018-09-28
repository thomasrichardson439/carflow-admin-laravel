@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mB-20">Applicants for Car Flow Inc:</h4>
                    <table id="usersTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Email </th>
                            <th>Address </th>
                            <th>Phone</th>
                            <th>Ridesharing apps</th>
                            <th>Documents</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.users.usersData') !!}',
                columns: [
                    {"data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'email', name: 'email' },
                    { data: 'address', name: 'address' },
                    { data: 'phone', name: 'phone' },
                    { data: 'ridesharing_apps', name: 'ridesharing_apps' },
                    { data: 'documents_uploaded', name: 'documents_uploaded',
                        "render": function(data, type, row, meta) {
                            return row.documents_uploaded == 0 ? 'Not Uploaded' : 'Uploaded';
                        }
                    },
                    { data: 'status', name: 'status' },
                    { data: 'id',
                        name: 'id',
                        "render": function(data, type, row, meta) {
                            var title = 'Review';
                            if (row.status == 'approved') {
                                title = 'Unapprove';
                            }
                            return '<a href="/admin/users/'+ data + '">' +  title + '</a>';
                        } },
                ],
                "order": [[ 1, 'asc' ]]
            });
        });
    </script>
@endpush
