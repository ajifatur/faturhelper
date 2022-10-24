@extends('faturhelper::layouts/admin/main')

@section('title', 'Log Autentikasi')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Log Autentikasi</h1>
</div>
<div class="row">
    <div class="col-12">
		<div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="80">Waktu</th>
                                <th width="120">Username</th>
                                <th width="80">IP Address</th>
                                <th>Error</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    Spandiv.DataTable("#datatable", {
        serverSide: true,
        orderAll: true,
		pageLength: 50,
        fixedHeader: true,
        url: Spandiv.URL("{{ route('admin.log.authentication') }}"),
        columns: [
            {data: 'datetime', name: 'datetime'},
            {data: 'username', name: 'username'},
            {data: 'ip', name: 'ip'},
            {data: 'errors', name: 'errors'}
        ],
        order: [0, 'desc']
    });
</script>

@endsection