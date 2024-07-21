@extends('faturhelper::layouts/admin/main')

@section('title', 'Tambah Hak Akses')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tambah Hak Akses</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.permission.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ old('name') }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kode <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="code" class="form-select form-select-sm {{ $errors->has('code') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($routes as $route)
                                    @if($route != null)
                                    <option value="{{ $route['actionName'] }}" {{ old('code') == $route['actionName'] ? 'selected' : '' }}>{{ $route['actionName'] }} - {{ $route['method'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('code'))
                            <div class="small text-danger">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.permission.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection

@section('js')

<script>
    // Select2
    Spandiv.Select2("select[name=code]");
</script>

@endsection