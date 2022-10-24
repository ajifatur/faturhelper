@extends('faturhelper::layouts/admin/main')

@section('title', 'Route')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Route</h1>
</div>
<div class="row">
    <div class="col-12">
		<div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="20"></th>
                                <th>URL</th>
                                <th width="70">Method</th>
                                <th>Action</th>
                                <th width="70">Parameter</th>
                                <th width="100">Middleware</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($routes as $route)
                                @if($route != null)
                                    <tr>
                                        <td align="right">{{ $i }}</td>
                                        <td>
                                            <span style="word-break: break-all;">{{ $route['url'] }}</span>
                                            <br>
                                            <code>{{ $route['name'] }}</code>
                                        </td>
                                        <td>{{ $route['method'] }}</td>
                                        <td><span style="word-break: break-all;">{{ $route['actionName'] }}</span></td>
                                        <td>
                                            @foreach($route['parameterName'] as $key=>$parameter)
                                                {{ $parameter }}
                                                @if($key < count($route['parameterName']) - 1)
                                                    <hr class="my-1">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($route['middleware'] as $key=>$middleware)
                                                {{ $middleware }}
                                                @if($key < count($route['middleware']) - 1)
                                                    <hr class="my-1">
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endif
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
    Spandiv.DataTable("#datatable", {
        orderAll: true,
        pageLength: -1,
        fixedHeader: true
    });
</script>

@endsection

@section('css')

<style>
    .table tr td {vertical-align: top!important;}
</style>

@endsection