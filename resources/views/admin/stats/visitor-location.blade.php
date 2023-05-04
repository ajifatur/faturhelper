@extends('faturhelper::layouts/admin/main')

@section('title', 'Statistik Lokasi Visitor')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Statistik Lokasi Visitor</h1>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless" id="table-city">
                        <thead>
                            <tr>
                                <th>Kota</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="colspan" colspan="2"><em>Sedang Memuat...</em></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless" id="table-region">
                        <thead>
                            <tr>
                                <th>Regional</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="colspan" colspan="2"><em>Sedang Memuat...</em></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless" id="table-country">
                        <thead>
                            <tr>
                                <th>Negara</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="colspan" colspan="2"><em>Sedang Memuat...</em></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    // Load city
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.location.city', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            var html = '';
            for(i=0; i<response.data.length; i++) {
                html += '<tr>';
                html += (response.data[i].name == 'Tidak Diketahui') ? '<td class="text-danger">' + response.data[i].name + '</td>' : '<td>' + response.data[i].name + '</td>';
                html += (response.data[i].name == 'Tidak Diketahui') ? '<td class="text-danger">' + Spandiv.NumberFormat(response.data[i].y.toString()) + '</td>' : '<td>' + Spandiv.NumberFormat(response.data[i].y.toString()) + '</td>';
                html += '</tr>';
            }
            $("#table-city tbody").html(html);
        }
    });

    // Load region
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.location.region', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            var html = '';
            for(i=0; i<response.data.length; i++) {
                html += '<tr>';
                html += (response.data[i].name == 'Tidak Diketahui') ? '<td class="text-danger">' + response.data[i].name + '</td>' : '<td>' + response.data[i].name + '</td>';
                html += (response.data[i].name == 'Tidak Diketahui') ? '<td class="text-danger">' + Spandiv.NumberFormat(response.data[i].y.toString()) + '</td>' : '<td>' + Spandiv.NumberFormat(response.data[i].y.toString()) + '</td>';
                html += '</tr>';
            }
            $("#table-region tbody").html(html);
        }
    });
    
    // Load country
    $.ajax({
        type: "get",
        url: "{{ route('api.visitor.location.country', ['access_token' => Auth::user()->access_token]) }}",
        success: function(response) {
            var html = '';
            for(i=0; i<response.data.length; i++) {
                html += '<tr>';
                html += (response.data[i].name == 'Tidak Diketahui') ? '<td class="text-danger">' + response.data[i].name + '</td>' : '<td>' + response.data[i].name + '</td>';
                html += (response.data[i].name == 'Tidak Diketahui') ? '<td class="text-danger">' + Spandiv.NumberFormat(response.data[i].y.toString()) + '</td>' : '<td>' + Spandiv.NumberFormat(response.data[i].y.toString()) + '</td>';
                html += '</tr>';
            }
            $("#table-country tbody").html(html);
        }
    });
</script>

@endsection

@section('css')

<style type="text/css">
    .table tr th, .table tr td {padding: .25rem;}
    .table tr th:last-child, .table tr td:last-child {text-align: right;}
    .table tr td.colspan {text-align: center!important;}
</style>

@endsection