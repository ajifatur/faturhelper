@extends('faturhelper::layouts/admin/main')

@section('title', 'Database')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Database</h1>
</div>
<div class="row">
    <div class="col-12">
		<div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th rowspan="2" width="30">#</th>
                                <th rowspan="2">Table</th>
                                <th colspan="6">Field</th>
                                <th rowspan="2" width="100">Last Update</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Null</th>
                                <th>Key</th>
                                <th>Default</th>
                                <th>Extra</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tables as $num=>$table)
                                @foreach($table->columns as $key=>$column)
                                <tr>
                                    @if($key == 0)
                                        <td rowspan="{{ count($table->columns) }}" align="right">{{ ($num + 1) }}</td>
                                        <td rowspan="{{ count($table->columns) }}">{{ $table->name }}</td>
                                    @endif
                                    @foreach($column as $column_attr)
                                        <td>{{ $column_attr }}</td>
                                    @endforeach
                                    @if($key == 0)
                                        <td rowspan="{{ count($table->columns) }}">
                                            @if($table->latest_data)
                                                {{ date('d/m/Y', strtotime($table->latest_data->updated_at)) }}
                                                <br>
                                                <small class="text-muted">{{ date('H:i', strtotime($table->latest_data->updated_at)) }} WIB</small>
                                            @elseif($table->latest_data === null)
                                                <span class="text-danger">Empty data.</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')

<style>
    .table tr th {text-align: center; vertical-align: middle;}
</style>

@endsection