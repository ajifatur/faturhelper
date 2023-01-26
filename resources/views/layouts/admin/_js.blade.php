
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('templates/adminkit/js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/ashl1/datatables-rowsgroup@fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<script src="https://ajifatur.github.io/assets/spandiv.min.js"></script>
<!-- <script src="{{ asset('spandiv/assets/spandiv.js') }}"></script> -->
<script>
	// Change theme
	$(document).on("change", "input[name=theme]", function(e) {
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