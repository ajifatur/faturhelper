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
            var colors = JSON.parse(response);
            colors = colors.colors;

            // Add table header
            var th = ['', 'name', 'hex', 'r', 'g', 'b', 'h', 's', 'l'];
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
            for(var i=0; i<colors.length; i++) {
                tbody += '<tr>';
                tbody += '<td align="center"><div style="height: 20px; width: 20px; border: 1px solid black; border-radius: 100%; background-color: #' + colors[i].hex +  ';"></div></td>';
                tbody += '<td>' + colors[i].name + '</td>';
                tbody += '<td>' + colors[i].hex + '</td>';
                tbody += '<td>' + colors[i].r + '</td>';
                tbody += '<td>' + colors[i].g + '</td>';
                tbody += '<td>' + colors[i].b + '</td>';
                tbody += '<td>' + colors[i].h + '</td>';
                tbody += '<td>' + colors[i].s + '</td>';
                tbody += '<td>' + colors[i].l + '</td>';
                tbody += '</tr>';
            }
            $("#table-dataset tbody").html(tbody);

            // Show total
            $("#total").text("Menampilkan " + Spandiv.NumberFormat(colors.length.toString()) + " data.").removeClass("d-none");
        },
        error: function() {
            console.log("File not found");
        }
    });
</script>

@endsection