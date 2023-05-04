@extends('faturhelper::layouts/admin/main')

@section('title', 'Statistik Pengguna')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Statistik Pengguna</h1>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-user-role">Sedang memuat...</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-user-status">Sedang memuat...</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-user-gender">Sedang memuat...</div>
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
</script>

@endsection