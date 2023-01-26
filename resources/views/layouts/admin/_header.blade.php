
<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
		<i class="hamburger align-self-center"></i>
	</a>
	<ul class="navbar-nav d-none d-lg-flex">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle text-dark" href="#" id="periodDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ setting('period_alias') }} </a>
			<div class="dropdown-menu" aria-labelledby="periodDropdown">
				<div class="dropdown-header">{{ setting('period_alias') }} Aktif</div>
				@foreach(period() as $period)
				<a class="dropdown-item d-flex justify-content-between btn-period" href="#" data-id="{{ $period->id }}">
					<span class="me-2">{{ $period->name }}</span>
					@if(session()->has('period') && session('period') == $period->id)
						<span><i class="bi bi-check-circle-fill"></i></span>
					@elseif(!session()->has('period') && $period->status == 1)
						<span><i class="bi bi-check-circle-fill"></i></span>
					@endif
				</a>
				@endforeach
			</div>
			<form class="form-period d-none" method="post" action="{{ route('admin.period.change') }}">
				@csrf
				<input type="hidden" name="id">
			</form>
		</li>
	</ul>
	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
			<li class="nav-item nav-item-user dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
					@if(Auth::user()->avatar != '' && File::exists(public_path('assets/images/users/'.Auth::user()->avatar)))
						<img src="{{ asset('assets/images/users/'.Auth::user()->avatar) }}" class="avatar img-fluid rounded-circle me-1" alt="{{ Auth::user()->name }}" /> <span class="text-dark d-none d-sm-inline-block">{{ explode(' ', trim(Auth::user()->name))[0] }}</span>
					@else
						<div class="d-flex align-items-center">
							<div class="avatar avatar-letter rounded-circle me-2 text-center bg-dark">
								<h2 class="text-white">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</h2>
							</div>
							<span class="text-dark d-none d-sm-inline-block">{{ explode(' ', trim(Auth::user()->name))[0] }}</span>
						</div>
					@endif
				</a>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="align-middle me-1" data-feather="user"></i> Profil</a>
					<a class="dropdown-item" href="{{ route('admin.settings.profile') }}"><i class="align-middle me-1" data-feather="settings"></i> Pengaturan</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item btn-logout" href="#"><i class="align-middle me-1" data-feather="power"></i> Keluar</a>
					<form id="form-logout" class="d-none" method="post" action="{{ route('admin.logout') }}">@csrf</form>
				</div>
			</li>
		</ul>
	</div>
</nav>