@extends('faturhelper::layouts/admin/main')

@section('title', 'Pengaturan Periode')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pengaturan Periode</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form method="post" action="{{ route('admin.period.set') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Gunakan Periode<span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visibility" id="visibility-1" value="1" {{ setting('period_visibility') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="visibility-1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visibility" id="visibility-0" value="0" {{ setting('period_visibility') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="visibility-0">Tidak</label>
                            </div>
                            @if($errors->has('visibility'))
                            <div class="small text-danger">{{ $errors->first('visibility') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama Lain Periode <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ setting('period_alias') }}" {{ setting('period_visibility') != '1' ? 'disabled' : '' }}>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Periode Aktif <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="period" class="form-select form-select-sm {{ $errors->has('period') ? 'border-danger' : '' }}" {{ setting('period_visibility') != '1' ? 'disabled' : '' }}>
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $period->status == 1 ? 'selected' : '' }}>{{ $period->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('period'))
                            <div class="small text-danger">{{ $errors->first('period') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.period.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
    $(document).on("click", "input[name=visibility]", function(e) {
        var value = $("input[name=visibility]:checked").val();
        if(value == 1) {
            $("input[name=name]").removeAttr("disabled");
            $("select[name=period]").removeAttr("disabled");
        }
        else {
            $("input[name=name]").attr("disabled","disabled");
            $("select[name=period]").attr("disabled","disabled");
        }
    });
</script>

@endsection