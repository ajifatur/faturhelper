@extends('faturhelper::layouts/admin/main')

@section('title', 'Detail Package')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Package</h1>
    <a href="{{ route('admin.system.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali ke Lingkungan Sistem</a>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <div class="card h-100">
            <div class="card-header"><h5 class="card-title mb-0">Detail</h5></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Nama:</div>
                        <div>{{ $package['name'] }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Author:</div>
                        <div>{{ $package['authors'][0]['name'] }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Lisensi:</div>
                        <div>{{ implode(', ', $package['license']) }}</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
	<div class="col-12">
		<div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Releases</h5></div>
            <div class="card-body">
                <ul class="timeline">
                    @foreach($releases as $release)
                    <li class="timeline-item">
                        <strong>{{ $release['name'] }}</strong>
                        <span class="float-end text-muted text-sm">{{ \Ajifatur\Helpers\DateTimeExt::elapsed(date('Y-m-d H:i:s', strtotime($release['created_at']))) }}</span>
                        <p>{!! nl2br($release['body']) !!}</p>
                    </li>
                    @endforeach
                </ul>
            </div>
		</div>
	</div>
</div>

@endsection