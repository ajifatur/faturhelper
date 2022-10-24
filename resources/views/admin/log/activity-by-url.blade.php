@extends('faturhelper::layouts/admin/main')

@section('title', 'Log Aktivitas Berdasarkan URL')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Log Aktivitas Berdasarkan URL</h1>
</div>
<div class="row">
    <div class="col-12">
		<div class="card">
            <div class="card-header d-sm-flex justify-content-end align-items-center">
                <div class="mb-sm-0 mb-2">
                    <select name="user" class="form-select form-select-sm" disabled>
                        <option>Memuat...</option>
                    </select>
                </div>
                <div class="ms-sm-2 ms-0">
                    <select name="month" class="form-select form-select-sm">
                        @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ \Ajifatur\Helpers\DateTimeExt::month($m) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="ms-sm-2 ms-0">
                    <select name="year" class="form-select form-select-sm">
                        @for($y=date('Y'); $y>=2022; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th>URL</th>
                                <th width="70">Method</th>
                                <th width="80">Jumlah</th>
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
        url: Spandiv.URL("{{ route('admin.log.activity.url') }}", {user: "{{ $user }}", month: "{{ $month }}", year: "{{ $year }}"}),
        columns: [
            {data: 'url', name: 'url'},
            {data: 'method', name: 'method'},
            {data: 'count', name: 'count'},
        ],
        order: [2, 'desc']
    });

    // Get users
    $.ajax({
        type: "get",
        url: Spandiv.URL("{{ route('admin.log.activity.user') }}", {month: "{{ $month }}", year: "{{ $year }}"}),
        success: function(response) {
            var html = '';
            html += '<option value="0">Semua Pengguna</option>';
            html += '<option value="-1">Guest</option>';
            for(var i=0; i<response.length; i++) {
                html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
            }
            $("select[name=user]").html(html).removeAttr("disabled");
            $("select[name=user]").val("{{ $user }}");
        }
    });

    // Change User, Month, Year
    $(document).on("change", "select[name=user], select[name=month], select[name=year]", function() {
        var user = $("select[name=user]").val();
        var month = $("select[name=month]").val();
        var year = $("select[name=year]").val();
        window.location.href = Spandiv.URL("{{ route('admin.log.activity.url') }}", {user: user, month: month, year: year});
    });

    // Button Read More
    $(document).on("click", ".btn-read-more", function(e) {
        e.preventDefault();
        $(this).parents(".url-text").find(".more-text").removeClass("d-none");
        $(this).addClass("d-none");
    });

    // Button Read Less
    $(document).on("click", ".btn-read-less", function(e) {
        e.preventDefault();
        $(this).parents(".url-text").find(".more-text").addClass("d-none");
        $(this).parents(".url-text").find(".btn-read-more").removeClass("d-none");
    });
</script>

@endsection