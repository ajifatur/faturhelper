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
		$.ajax({
			type: "post",
			url: "{{ route('admin.setting.update') }}",
			data: {_token: "{{ csrf_token() }}", isAjax: true, code: "size", content: size},
			success: function(response) {
				if(response === "Success!") {
					$("body").attr("data-size",size);
					if($.fn.DataTable.isDataTable("table")) {
						$("table").DataTable().columns.adjust().draw();
					}
				}
			}
		});
	});

	// Sidebar toggle
	$(document).on("click", ".sidebar-toggle", function(e) {
		e.preventDefault();
		setNavBrand();
	});
	$(window).on("resize", function() {
		setNavBrand();
	});

	// Change role
	$(document).on("click", ".btn-role", function(e) {
		e.preventDefault();
		var id = $(this).data("id");
		$(".form-role").find("input[name=id]").val(id);
		$(".form-role").submit();
	});

	// Change period
	$(document).on("click", ".btn-period", function(e) {
		e.preventDefault();
		var id = $(this).data("id");
		$(".form-period").find("input[name=id]").val(id);
		$(".form-period").submit();
	});

	// Set nav brand
	function setNavBrand() {
		if($(".sidebar").hasClass("collapsed") && $(window).width() > 991.98)
			$(".nav-brand").css("display","block");
		else if(!$(".sidebar").hasClass("collapsed") && $(window).width() <= 991.98)
			$(".nav-brand").css("display","block");
		else
			$(".nav-brand").css("display","none");
	}
</script>

@if((!session()->has('role') && Auth::user()->role_id == role('super-admin')) || (session()->has('role') && session('role') == role('super-admin')))
<script>
	// Load Notification
	$(window).on("load", function() {
		$.ajax({
			type: "get",
			url: "{{ route('api.notification', ['access_token' => Auth::user()->access_token]) }}",
			success: function(response) {
				if(response.length > 0) {
					$("#nav-notification").find("span.indicator").text(response.length).removeClass("d-none");
					$("#nav-notification").find(".dropdown-menu-header").text(response.length + " Notifikasi Baru");
					var html = '';
					for(var i=0; i<response.length; i++) {
						html += '<a href="' + response[i].route + '" class="list-group-item">';
						html += '<div class="row g-0 align-items-center">';
						html += '<div class="col-2">';
						html += '<i class="h4 ' + response[i].icon_name + ' ' + response[i].icon_color + '"></i>';
						html += '</div>';
						html += '<div class="col-10">';
						html += '<div class="text-dark">' + response[i].title + '</div>';
						html += '<div class="text-muted small mt-1">' + response[i].description + '</div>';
						html += '</div>';
						html += '</div>';
						html += '</a>';
					}
					$("#nav-notification").find(".list-group").removeClass("d-none").html(html);
				}
				else {
					$("#nav-notification").find(".dropdown-menu-header").text("Tidak ada notifikasi");
				}
			}
		})
	});
</script>
@endif