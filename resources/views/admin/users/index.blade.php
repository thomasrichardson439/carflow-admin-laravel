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
                <th>Full Name</th>
                <th>Email </th>
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
            { data: 'full_name', name: 'full_name' },
            { data: 'email', name: 'email' },
            { data: 'ridesharing_apps', name: 'ridesharing_apps' },
            { data: 'documents_uploaded', name: 'documents_uploaded' },
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
    });
});
</script>
@endpush
