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
<script src="https://ajifatur.github.io/assets/dist/2.0.0/spandiv.min.js"></script>
<!-- <script src="{{ asset('spandiv/assets/dist/2.0.0/spandiv.js') }}"></script> -->
<script>
	// Load size
	$(window).on("load", function() {
		var size = $("body").data("size");
		setSize(size);
	});

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

	// Change size
	$(document).on("change", ".offcanvas input[name=size]", function(e) {
		e.preventDefault();
        if(typeof Pace !== "undefined") Pace.restart();
		var size = $(this).val();
		setSize(size);
		$.ajax({
			type: "post",
			url: "{{ route('admin.setting.update') }}",
			data: {_token: "{{ csrf_token() }}", isAjax: true, code: "size", content: size},
			success: function(response) {
				if(response === "Success!")
					$("body").attr("data-size",size);
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

	// Set size
	function setSize(size) {
		if(size == "small") {
			$(".form-control").removeClass("form-control-lg").addClass("form-control-sm");
			$(".form-select").removeClass("form-select-lg").addClass("form-select-sm");
			$(".input-group").removeClass("input-group-lg").addClass("input-group-sm");
			$(".btn").removeClass("btn-lg").addClass("btn-sm");
			$("body").css("font-size", ".875rem");
			$(".select2-container").css("font-size", ".875rem");
			$(".select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__rendered").css("height", "28px");
			$(".select2-container--default .select2-selection--single .select2-selection__rendered, select2-selection__clear, select2-selection__arrow").css("height", "26px");
		}
		else if(size == "medium") {
			$(".form-control").removeClass("form-control-sm form-control-lg");
			$(".form-select").removeClass("form-select-sm form-select-lg");
			$(".input-group").removeClass("input-group-sm input-group-lg");
			$(".btn").removeClass("btn-sm btn-lg");
			$("body").css("font-size", ".925rem");
			$(".select2-container").css("font-size", ".925rem");
			$(".select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__rendered").css("height", "32.59px");
			$(".select2-container--default .select2-selection--single .select2-selection__rendered, select2-selection__clear, select2-selection__arrow").css("height", "30.59px");
		}
		else if(size == "large") {
			$(".form-control").removeClass("form-control-sm").addClass("form-control-lg");
			$(".form-select").removeClass("form-select-sm").addClass("form-select-lg");
			$(".input-group").removeClass("input-group-sm").addClass("input-group-lg");
			$(".btn").removeClass("btn-sm").addClass("btn-lg");
			$("body").css("font-size", "1rem");
			$(".select2-container").css("font-size", "1rem");
			$(".select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__rendered").css("height", "37px");
			$(".select2-container--default .select2-selection--single .select2-selection__rendered, select2-selection__clear, select2-selection__arrow").css("height", "34px");
		}
	}
</script>