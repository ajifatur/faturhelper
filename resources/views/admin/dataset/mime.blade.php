@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Dataset: '.Request::query('json').'.json')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Dataset: {{ Request::query('json') }}.json</h1>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-body">
                <p class="d-none" id="total"></p>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered mb-0" id="table-dataset">
                        <thead class="bg-light"></thead>
                        <tbody>
                            <tr>
                                <td align="center"><span class="text-primary fst-italic">Memuat...</span></td>
                            </tr>
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
    // Fetch Data
    $.ajax({
        type: "get",
        url: "https://raw.githubusercontent.com/ajifatur/faturhelper/master/json/" + "{{ Request::query('json') }}" + ".json",
        success: function(response) {
            var results = JSON.parse(response);
            var keys = Object.keys(results);
            var values = Object.values(results);

            // Add table header
            var th = ['key', 'name'];
            var thead = '';
            thead += '<tr>';
            for(var i=0; i<th.length; i++) {
                thead += '<th>' + th[i] + '</th>';
            }
            thead += '</tr>';
            $("#table-dataset thead").html(thead);
            $("#table-dataset tbody tr:first-child td").attr("colspan",th.length);

            // Add table body
            var tbody = '';
            for(var i=0; i<keys.length; i++) {
                tbody += '<tr>';
                tbody += '<td>' + keys[i] + '</td>';
                tbody += '<td>' + values[i] + '</td>';
                tbody += '</tr>';
            }
            $("#table-dataset tbody").html(tbody);

            // Show total
            $("#total").text("Menampilkan " + Spandiv.NumberFormat(keys.length.toString()) + " data.").removeClass("d-none");
        },
        error: function() {
            console.log("File not found");
        }
    });
</script>

@endsection