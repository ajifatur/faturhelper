@extends('faturhelper::layouts/admin/main')

@section('title', 'Database')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Database</h1>
    <div class="btn-group">
        <a href="#" class="btn btn-sm btn-primary btn-toggle-field"><i class="bi-eye-slash me-1"></i> <span>Sembunyikan Field</span></a>
    </div>
</div>
<div class="row">
    <div class="col-12">
		<div class="card">
            <div class="card-header d-sm-flex justify-content-end align-items-center">
                <div></div>
                <div class="ms-sm-2 ms-0">
                    <select name="connection" class="form-select form-select-sm">
                        <option value="" disabled>--Pilih Database--</option>
                        @foreach($databases as $key=>$database)
                        <option value="{{ $key }}" {{ $key == $connection ? 'selected' : '' }}>{{ $database }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th rowspan="2" width="30">#</th>
                                <th rowspan="2">Table</th>
                                <th colspan="6" class="db-field">Field</th>
                                <th rowspan="2" width="50">Total</th>
                                <th rowspan="2" width="100">Last Update</th>
                            </tr>
                            <tr class="db-field">
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
                                <tr class="{{ !in_array($table->name, $default_tables) ? 'bg-warning' : '' }}">
                                    @if($key == 0)
                                        <td rowspan="{{ count($table->columns) }}" align="right">{{ ($num + 1) }}</td>
                                        <td rowspan="{{ count($table->columns) }}">{{ $table->name }}</td>
                                    @endif
                                    @foreach($column as $column_attr)
                                        <td class="db-field">{{ $column_attr }}</td>
                                    @endforeach
                                    @if($key == 0)
                                        <td rowspan="{{ count($table->columns) }}" align="right">{{ $table->total }}</td>
                                        <td rowspan="{{ count($table->columns) }}">
                                            @if($table->latest_data)
                                                @if($table->latest_data->updated_at != null)
                                                    {{ date('d/m/Y', strtotime($table->latest_data->updated_at)) }}
                                                    <br>
                                                    <small class="text-muted">{{ date('H:i', strtotime($table->latest_data->updated_at)) }} WIB</small>
                                                @else
                                                    <span class="text-danger">NULL</span>
                                                @endif
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

@section('js')

<script>
    $(document).on("click", ".btn-toggle-field", function(e) {
        e.preventDefault();
        if($(this).find(".bi-eye-slash").length === 1) {
            $(".table").find(".db-field").addClass("d-none");
            $(".table tr td").addClass("align-top");
            $(this).find("i").removeClass("bi-eye-slash").addClass("bi-eye");
            $(this).find("span").text("Tampilkan Field");
        }
        else {
            $(".table").find(".db-field").removeClass("d-none");
            $(".table tr td").removeClass("align-top");
            $(this).find("i").addClass("bi-eye-slash").removeClass("bi-eye");
            $(this).find("span").text("Sembunyikan Field");
        }
    });
    
    // Change the connection
    $(document).on("change", ".card-header select[name=connection]", function() {
		var connection = $(this).val();
		window.location.href = Spandiv.URL("{{ route('admin.database.index') }}", {connection: connection});
    });
</script>

@endsection

@section('css')

<style>
    .table tr th {text-align: center; vertical-align: middle;}
</style>

@endsection