<div class="settings-toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvas">
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
</div>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
	<div class="offcanvas-header settings-title">
		<h4 class="offcanvas-title">Tools dan Aplikasi</h4>
		<button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Master</small>
			<ul class="list-unstyled p-0">
				<li><a href="{{ route('admin.menu.index') }}">Menu</a></li>
				<li><a href="{{ route('admin.role.index') }}">Role</a></li>
				<li><a href="{{ route('admin.permission.index') }}">Hak Akses</a></li>
				<li><a href="{{ route('admin.meta.index') }}">Meta</a></li>
			</ul>
		</div>
		<hr>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Sistem</small>
			<ul class="list-unstyled p-0">
				<li><a href="{{ route('admin.system.index') }}">Lingkungan Sistem</a></li>
				<li><a href="{{ route('admin.database.index') }}">Database</a></li>
				<li><a href="{{ route('admin.log.index') }}" target="_blank">Log</a></li>
			</ul>
		</div>
		<hr>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Tools</small>
			<ul class="list-unstyled p-0">
				<li><a href="{{ route('admin.artisan.index') }}">Artisan</a></li>
			</ul>
		</div>
		<hr>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Dataset Kecil</small>
			<ul class="list-unstyled p-0">
				@foreach(datasets('small') as $key=>$dataset)
				<li><a href="{{ route('admin.dataset.index', ['json' => $key]) }}">{{ $dataset }}</a></li>
				@endforeach
			</ul>
		</div>
		<hr>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Dataset Besar</small>
			<ul class="list-unstyled p-0">
				@foreach(datasets('large') as $key=>$dataset)
				<li><a href="{{ route('admin.dataset.index', ['json' => $key]) }}">{{ $dataset }}</a></li>
				@endforeach
			</ul>
		</div>
		<div class="d-grid gap-2 mb-3">
			<a href="https://github.com/ajifatur/faturhelper" class="btn btn-outline-primary btn-lg" target="_blank"><i class="bi-github me-1"></i> Kunjungi Kami</a>
		</div>
	</div>
</div>