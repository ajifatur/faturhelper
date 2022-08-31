@extends('faturhelper::layouts/admin/main')

@section('title', 'Summary')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Summary</h1>
</div>

<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Kunjungan</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($visitors['overall']) }}</h1>
                <div class="mb-0">
                    <span class="badge {{ $visitors['today'] > 0 ? 'badge-success-light' : 'badge-danger-light' }}"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format($visitors['today']) }} </span>
                    <span class="text-muted">kunjungan hari ini</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Pengguna</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="bi bi-person-plus"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($users['overall']) }}</h1>
                <div class="mb-0">
                    <span class="badge {{ $users['today'] > 0 ? 'badge-success-light' : 'badge-danger-light' }}"> <i class="mdi mdi-arrow-bottom-right"></i> {{ number_format($users['today']) }} </span>
                    <span class="text-muted">pengguna baru</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 d-none">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Activity</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="activity"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">16.300</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 4.65% </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 d-none">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Revenue</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">$20.120</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 2.35% </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection