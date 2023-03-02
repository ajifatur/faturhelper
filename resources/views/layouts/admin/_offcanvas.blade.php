<div class="settings-toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvas">
	<div class="settings-gear">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear rotate-animation" viewBox="0 0 16 16">
			<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
			<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
		</svg>
	</div>
</div>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
	<div class="offcanvas-header settings-title">
		<h4 class="offcanvas-title">Tools dan Aplikasi</h4>
		<button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div class="d-grid gap-2 mb-3">
			<div class="btn-group">
				<a href="https://spandiv.xyz" class="btn btn-outline-primary btn-sm" target="_blank"><i class="bi-globe2 me-1"></i> Spandiv</a>
				<a href="https://github.com/ajifatur/faturhelper" class="btn btn-outline-primary btn-sm" target="_blank"><i class="bi-github me-1"></i> FaturHelper</a>
				<a href="https://github.com/ajifatur/assets" class="btn btn-outline-primary btn-sm" target="_blank"><i class="bi-github me-1"></i> Assets</a>
			</div>
		</div>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Tema</small>
			@php $themes = ['default', 'colored', 'red', 'blue', 'green', 'cyan', 'purple', 'pink', 'gray', 'light']; @endphp
			<div class="row">
				@foreach($themes as $theme)
				<div class="col-6">
					<div class="form-check form-switch mb-1">
						<input type="radio" class="form-check-input" name="theme" value="{{ $theme }}" id="theme-{{ $theme }}" {{ setting('theme') == $theme ? 'checked' : '' }}>
						<label class="form-check-label" for="theme-{{ $theme }}">{{ ucfirst($theme) }}</label>
		            </div>
				</div>
				@endforeach
			</div>
		</div>
		<hr>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Master</small>
			<div class="row">
				<div class="col-6"><a href="{{ route('admin.role.index') }}">Role</a></div>
				<div class="col-6"><a href="{{ route('admin.menu.index') }}">Menu</a></div>
				<div class="col-6"><a href="{{ route('admin.user.index') }}">Pengguna</a></div>
				<div class="col-6"><a href="{{ route('admin.meta.index') }}">Meta</a></div>
				<div class="col-6"><a href="{{ route('admin.permission.index') }}">Hak Akses</a></div>
				<div class="col-6"><a href="{{ route('admin.schedule.index') }}">Agenda</a></div>
				<div class="col-6"><a href="{{ route('admin.period.index') }}">Periode</a></div>
			</div>
		</div>
		<hr>
		<div class="mb-3">
			<div class="row">
				<div class="col-6">
					<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Sistem</small>
					<ul class="list-unstyled p-0 mb-0">
						<li><a href="{{ route('admin.setting.index') }}">Pengaturan</a></li>
						<li><a href="{{ route('admin.setting.icon') }}">Pengaturan Icon</a></li>
						<li><a href="{{ route('admin.system.index') }}">Lingkungan Sistem</a></li>
						<li><a href="{{ route('admin.database.index') }}">Database</a></li>
						<li><a href="{{ route('admin.route.index') }}">Route</a></li>
						<li><a href="{{ route('admin.summary') }}">Rangkuman</a></li>
					</ul>
				</div>
				<div class="col-6">
					<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Tools</small>
					<ul class="list-unstyled p-0 mb-0">
						<li><a href="{{ route('admin.artisan.index') }}">Artisan</a></li>
					</ul>
				</div>
			</div>
		</div>
		<hr>
		<div class="mb-3">
			<small class="d-block text-uppercase font-weight-bold text-muted mb-2">Log</small>
			<div class="row">
				<div class="col-6"><a href="{{ route('admin.log.activity') }}">Aktivitas</a></div>
				<div class="col-6"><a href="{{ route('admin.log.authentication') }}">Autentikasi</a></div>
				<div class="col-6"><a href="{{ route('admin.log.activity.url') }}">Aktivitas (URL)</a></div>
				<div class="col-6"><a href="{{ route('admin.visitor.index') }}">Visitor</a></div>
				<div class="col-6"><a href="{{ route('admin.log.index') }}" target="_blank">Semua Log</a></div>
			</div>
		</div>
	</div>
</div>