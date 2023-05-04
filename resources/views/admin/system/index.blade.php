@extends('faturhelper::layouts/admin/main')

@section('title', 'Lingkungan Sistem')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Lingkungan Sistem</h1>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header"><h5 class="card-title mb-0">Sistem Aplikasi</h5></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Nama:</div>
                        <div>{{ config('app.name') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Lingkungan:</div>
                        <div>{{ ucfirst(config('app.env')) }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Debug:</div>
                        <div>{{ config('app.debug') == true ? 'Ya' : 'Tidak' }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>URL:</div>
                        <div><a href="{{ url()->to('/') }}" target="_blank">{{ url()->to('/') }}</a></div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Lokalisasi:</div>
                        <div>{{ config('app.locale') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Zona Waktu:</div>
                        <div>{{ config('app.timezone') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between fw-bold">
                        <div>Laravel:</div>
                        <div>{{ app()->version() }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between fw-bold">
                        <div>PHP:</div>
                        <div>{{ phpversion() }}</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header"><h5 class="card-title mb-0">Database</h5></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Koneksi:</div>
                        <div>{{ config('database.default') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Host:</div>
                        <div>{{ config('database.connections.'.config('database.default').'.host') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Port:</div>
                        <div>{{ config('database.connections.'.config('database.default').'.port') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Nama Database:</div>
                        <div>{{ config('database.connections.'.config('database.default').'.database') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Username:</div>
                        <div>{{ config('database.connections.'.config('database.default').'.username') }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Password:</div>
                        <div>{{ config('database.connections.'.config('database.default').'.password') }}</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
	<div class="col-12">
		<div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Data Package</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="30"><input type="checkbox" class="form-check-input checkbox-all"></th>
                                <th>Nama</th>
                                <th width="80">Versi</th>
                                <th width="100">Tipe</th>
                                <th width="40">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                            <tr data-url="{{ route('admin.system.package', ['repo' => $package['name']]) }}">
                                <td align="center"><input type="checkbox" class="form-check-input checkbox-one"></td>
                                <td>
                                    {{ $package['name'] }}
                                    <br>
                                    <small class="text-muted">{{ array_key_exists('description', $package) ? $package['description'] : '' }}</small>
                                    <br>
                                </td>
                                <td>{{ $package['version'] }}</td>
                                <td>{{ ucfirst($package['type']) }}</td>
                                <td align="center">
                                    <div class="btn-group">
                                        <a href="https://github.com/{{ $package['path'] }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Kunjungi Repository" target="_blank"><i class="bi-github"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
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
    Spandiv.DataTable("#datatable");

    // DataTable rows clicked
    $(document).on("click", "#datatable tbody tr td:not([align])", function(e) {
        e.preventDefault();
        var selection = getSelection().toString();
        if(selection == '') {
            var url = $(this).parents('tr').data("url");
            window.location.href = url;
        }
    });
</script>

@endsection

@section('css')

<style>
    #datatable tbody tr td:not([align]) {cursor: pointer;}
</style>

@endsection