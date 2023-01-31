
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('templates/adminkit/js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.3.0/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script src="https://ajifatur.github.io/assets/spandiv.min.js"></script>
<!-- <script src="{{ asset('spandiv/assets/spandiv.js') }}"></script> -->
<script>
	// Change theme
	$(document).on("change", ".offcanvas input[name=theme]", function(e) {
		e.preventDefault();
        if(typeof Pace !== "undefined") Pace.restart();
		var theme = $(this).val();
		$.ajax({
			type: "post",
			url: "{{ route('admin.setting.update') }}",
			data: {_token: "{{ csrf_token() }}", isAjax: true, code: "theme", content: theme},
			success: function(response) {
				if(response === "Success!")
					$("body").attr("data-theme",theme);
			}
		});
	});

	// Change period
	$(document).on("click", ".btn-period", function(e) {
		e.preventDefault();
		var id = $(this).data("id");
		$(".form-period").find("input[name=id]").val(id);
		$(".form-period").submit();
	});
</script>