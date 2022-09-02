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
            // Set variables
            var results = JSON.parse(response);
            var keys = results.length > 0 ? Object.keys(results[0]) : undefined;
            var isObject = results.length > 0 ? typeof Object.values(results)[0] === "object" ? true : false : false;

            // Add table header
            if(keys !== undefined && isObject === true) {
                var thead = '';
                thead += '<tr>';
                for(var i=0; i<keys.length; i++) {
                    thead += '<th>' + keys[i] + '</th>';
                }
                thead += '</tr>';
                $("#table-dataset thead").html(thead);
                $("#table-dataset tbody tr:first-child td").attr("colspan",keys.length);
            }

            // Add table body
            if(results.length > 0) {
                var tbody = '';
                for(var i=0; i<results.length; i++) {
                    tbody += '<tr>';
                    if(isObject) {
                        for(var j=0; j<Object.keys(results[i]).length; j++) {
                            tbody += '<td>' + results[i][Object.keys(results[i])[j]] + '</td>';
                        }
                    }
                    else {
                        tbody += '<td>' + Object.values(results)[i] + '</td>';
                    }
                    tbody += '</tr>';
                }
                $("#table-dataset tbody").html(tbody);
            }

            // Show total
            $("#total").text("Menampilkan " + Spandiv.NumberFormat(results.length.toString()) + " data.").removeClass("d-none");
        },
        error: function() {
            console.log("File not found");
        }
    });
</script>

@endsection