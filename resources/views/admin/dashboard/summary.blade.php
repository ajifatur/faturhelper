@extends('faturhelper::layouts/admin/main')

@section('title', 'Insight')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Insight</h1>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Kunjungan</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($visitors['overall']) }}</h1>
                <div class="mb-0">
                    <span class="badge {{ $visitors['today'] > 0 ? 'badge-success-light' : 'badge-danger-light' }}"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format($visitors['today']) }} </span>
                    <span class="text-muted">kunjungan hari ini</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Pengguna</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="bi bi-person-plus"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($users['overall']) }}</h1>
                <div class="mb-0">
                    <span class="badge {{ $users['today'] > 0 ? 'badge-success-light' : 'badge-danger-light' }}"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format($users['today']) }} </span>
                    <span class="text-muted">pengguna baru</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Pengaturan</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="bi bi-wrench"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($settings['overall']) }}</h1>
                <div class="mb-0">
                    <span class="badge {{ $settings['empty'] > 0 ? 'badge-danger-light' : 'badge-success-light' }}"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format($settings['empty']) }} </span>
                    <span class="text-muted">belum diisi</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 d-none">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Pengaturan</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="bi bi-wrench"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($settings['overall']) }}</h1>
                <div class="mb-0">
                    <span class="badge {{ $settings['empty'] > 0 ? 'badge-danger-light' : 'badge-success-light' }}"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format($settings['empty']) }} </span>
                    <span class="text-muted">belum diisi</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-user-role">Sedang memuat...</div>
            </div>
        </div>
    </div>
	<div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-user-status">Sedang memuat...</div>
            </div>
        </div>
    </div>
	<div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-user-gender">Sedang memuat...</div>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-device-type">Sedang memuat...</div>
            </div>
        </div>
    </div>
	<div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-device-family">Sedang memuat...</div>
            </div>
        </div>
    </div>
	<div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-browser">Sedang memuat...</div>
            </div>
        </div>
    </div>
	<div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-platform">Sedang memuat...</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
    // Chart user role
    $.ajax({
        type: "get",
        url: "{{ route('api.user.role', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-user-role", {
                title: 'Pengguna Berdasarkan Role',
                titleAlign: 'left',
                seriesName: 'Pengguna',
                data: response.data
            });
        }
    });

    // Chart user status
    $.ajax({
        type: "get",
        url: "{{ route('api.user.status', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-user-status", {
                title: 'Pengguna Berdasarkan Status',
                titleAlign: 'left',
                seriesName: 'Pengguna',
                data: response.data
            });
        }
    });

    // Chart user gender
    $.ajax({
        type: "get",
        url: "{{ route('api.user.gender', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-user-gender", {
                title: 'Pengguna Berdasarkan Jenis Kelamin',
                titleAlign: 'left',
                seriesName: 'Pengguna',
                data: response.data
            });
        }
});

    // Chart visitor device type
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.device.type', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-device-type", {
                title: 'Device Type Usage',
                titleAlign: 'left',
                seriesName: 'Devices',
                data: response.data
            });
        }
    });

    // Chart visitor device family
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.device.family', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-device-family", {
                title: 'Device Family Usage',
                titleAlign: 'left',
                seriesName: 'Brands',
                data: response.data
            });
        }
    });

    // Chart visitor browser
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.browser', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-browser", {
                title: 'Browser Usage',
                titleAlign: 'left',
                seriesName: 'Brands',
                data: response.data
            });
        }
    });

    // Chart visitor platform
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.platform', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            Spandiv.HighchartsPie("highcharts-platform", {
                title: 'Platform Usage',
                titleAlign: 'left',
                seriesName: 'Brands',
                data: response.data
            });
        }
    });
</script>

@endsection