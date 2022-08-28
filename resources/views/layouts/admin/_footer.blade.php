
<footer class="footer">
	<div class="container-fluid">
		<div class="d-sm-flex {{ setting('show_brand') == 1 ? 'justify-content-between' : 'justify-content-center' }} text-center">
			<div class="text-muted">
				<a class="text-muted" href="/" target="_blank"><strong>{{ config('app.name') }}</strong></a> &copy; {{ date('Y') }}
			</div>
			@if(setting('show_brand') == 1)
			<div class="text-muted">
				Powered by <a href="https://spandiv.xyz" target="_blank">Spandiv Digital</a>
			</div>
			@endif
		</div>
	</div>
</footer>