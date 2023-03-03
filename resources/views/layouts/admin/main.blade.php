<!DOCTYPE html>
<html lang="en">
<head>
    @include('faturhelper::layouts/admin/_head')
    @yield('css')

    <title>@yield('title') :: {{ config('app.name') }} {{ setting('tagline') != '' ? ' - '.setting('tagline') : '' }}</title>
</head>
<body data-theme="{{ setting('theme') }}" data-size="{{ setting('size') }}">
	<div class="wrapper">
        @include('faturhelper::layouts/admin/_sidebar')
        
		<div class="main">
            @include('faturhelper::layouts/admin/_header')

			<main class="content">
				<div class="container-fluid p-0">
                    @yield('content')
				</div>
			</main>

            @include('faturhelper::layouts/admin/_footer')

		</div>
	</div>

    @if(Auth::user()->role_id == role('super-admin'))
        @include('faturhelper::layouts/admin/_offcanvas')
    @endif
    
    @include('faturhelper::layouts/admin/_js')
    @yield('js')

</body>
</html>