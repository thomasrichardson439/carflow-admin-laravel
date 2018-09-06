@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>
  <div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Bootstrap Data Table</h4>
        <table id="usersTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Email </th>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>Zip code</th>
                <th>Phone</th>
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
            { data: 'street', name: 'street' },
            { data: 'city', name: 'city' },
            { data: 'state', name: 'state' },
            { data: 'zip_code', name: 'zip_code' },
            { data: 'phone', name: 'phone' },
            { data: 'status', name: 'status' },
            { data: 'id',
              name: 'id',
              "render": function(data, type, row, meta) {
                  if (row.status == 'pending') {
                      return '<a href="/admin/users/'+ data + '">' +  'Approve' + '</a>';
                  } else {
                      return '';
                  }
               } }
        ],
    });
});
</script>
@endpush
