@extends('faturhelper::layouts/admin/main')

@section('title', 'Dashboard')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Dashboard</h1>
</div>
@if(Session::get('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <div class="alert-message">{{ Session::get('message') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="alert alert-primary" role="alert">
    <div class="alert-message">
        <h4 class="alert-heading">Selamat Datang!</h4>
        <p class="mb-0">Selamat datang kembali <strong>{{ Auth::user()->name }}</strong> di {{ setting('name') }}.</p>
    </div>
</div>

@endsection