
<footer class="footer">
	<div class="container-fluid">
		<div class="d-sm-flex {{ setting('brand_visibility') == 1 ? 'justify-content-between' : 'justify-content-center' }} text-center">
			<div class="text-muted">
				<a class="text-muted" href="/" target="_blank"><strong>{{ config('app.name') }}</strong></a> &copy; {{ date('Y') }}
			</div>
			@if(setting('brand_visibility') == 1)
			<div class="text-muted">
				Powered by <a href="{{ setting('brand_url') }}" target="_blank">{{ setting('brand_name') }}</a>
			</div>
			@endif
		</div>
	</div>
</footer>