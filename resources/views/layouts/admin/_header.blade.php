
<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
		<i class="hamburger align-self-center"></i>
	</a>
	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
			<li class="nav-item dropdown d-none">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="bell"></i>
						<span class="indicator">4</span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">
						4 New Notifications
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-danger" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Update completed</div>
									<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
									<div class="text-muted small mt-1">30m ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-warning" data-feather="bell"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Lorem ipsum</div>
									<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
									<div class="text-muted small mt-1">2h ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-primary" data-feather="home"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Login from 192.186.1.8</div>
									<div class="text-muted small mt-1">5h ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-success" data-feather="user-plus"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">New connection</div>
									<div class="text-muted small mt-1">Christina accepted your request.</div>
									<div class="text-muted small mt-1">14h ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li>
			<li class="nav-item nav-item-user dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
					@if(Auth::user()->avatar != '' && File::exists(public_path('assets/images/users/'.Auth::user()->avatar)))
						<img src="{{ asset('assets/images/users/'.Auth::user()->avatar) }}" class="avatar img-fluid rounded-circle me-1" alt="{{ Auth::user()->name }}" /> <span class="text-dark d-none d-sm-inline-block">{{ Auth::user()->name }}</span>
					@else
						<div class="d-flex align-items-center">
							<div class="avatar avatar-letter rounded-circle me-2 text-center bg-dark">
								<h2 class="text-white">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</h2>
							</div>
							<span class="text-dark d-none d-sm-inline-block">{{ Auth::user()->name }}</span>
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