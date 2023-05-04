@extends('faturhelper::layouts/admin/main')

@section('title', 'Statistik Visitor')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Statistik Visitor</h1>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-device-type">Sedang memuat...</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-device-family">Sedang memuat...</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div id="highcharts-browser">Sedang memuat...</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
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