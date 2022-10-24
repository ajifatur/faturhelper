@extends('faturhelper::layouts/admin/main')

@section('title', 'Visitor')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Visitor</h1>
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
                                <th>Pengguna</th>
                                <th width="180">Device</th>
                                <th width="180">Browser</th>
                                <th width="180">Platform</th>
                                <th width="180">Lokasi</th>
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
        url: Spandiv.URL("{{ route('admin.visitor.index') }}"),
        columns: [
            {data: 'datetime', name: 'datetime'},
            {data: 'user', name: 'user'},
            {data: 'device', name: 'device'},
            {data: 'browser', name: 'browser'},
            {data: 'platform', name: 'platform'},
            {data: 'location', name: 'location'}
        ],
        order: [0, 'desc']
    });
</script>

@endsection

@section('css')

<style>
    #datatable tr td {vertical-align: top;}
</style>

@endsection