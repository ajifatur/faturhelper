@extends('faturhelper::layouts/admin/main')

@section('title', 'Tambah Menu Item di '.$menu_header->name)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tambah Menu Item</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.menu.item.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="header_id" value="{{ $menu_header->id }}">
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
                        <label class="col-lg-2 col-md-3 col-form-label">Route</label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="route" class="form-control form-control-sm {{ $errors->has('route') ? 'border-danger' : '' }}" value="{{ old('route') }}">
                            @if($errors->has('route'))
                            <div class="small text-danger">{{ $errors->first('route') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Route Parameter</label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="routeparams" class="form-control form-control-sm {{ $errors->has('routeparams') ? 'border-danger' : '' }}" value="{{ old('routeparams') }}">
                            @if($errors->has('routeparams'))
                            <div class="small text-danger">{{ $errors->first('routeparams') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Icon</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="h3"><i class="{{ old('icon') }}"></i></div>
                            <select name="icon" class="form-select form-select-sm {{ $errors->has('icon') ? 'border-danger' : '' }}" id="select2"></select>
                            @if($errors->has('icon'))
                            <div class="small text-danger">{{ $errors->first('icon') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kondisi Item akan Terlihat</label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="visible_conditions" class="form-control form-control-sm {{ $errors->has('visible_conditions') ? 'border-danger' : '' }}" rows="3">{{ old('visible_conditions') }}</textarea>
                            @if($errors->has('visible_conditions'))
                            <div class="small text-danger">{{ $errors->first('visible_conditions') }}</div>
                            @endif
                            <div class="small text-muted">Jika tidak diisi maka item akan selalu terlihat.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kondisi Item akan Aktif <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="active_conditions" class="form-control form-control-sm {{ $errors->has('active_conditions') ? 'border-danger' : '' }}" rows="3">{{ old('active_conditions') }}</textarea>
                            @if($errors->has('active_conditions'))
                            <div class="small text-danger">{{ $errors->first('active_conditions') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Parent <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="parent" class="form-select form-select-sm {{ $errors->has('parent') ? 'border-danger' : '' }}">
                                <option value="0">Tidak Ada</option>
                                @foreach($menu_parents as $menu_parent)
                                <option value="{{ $menu_parent->id }}" {{ old('parent') == $menu_parent->id ? 'selected' : '' }}>{{ $menu_parent->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('parent'))
                            <div class="small text-danger">{{ $errors->first('parent') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // Get Bootstrap Icons
    Spandiv.Select2ServerSide("#select2", {
        url: "{{ route('api.bootstrap-icons') }}",
        value: "{{ old('icon') }}",
        valueProp: "name",
        nameProp: "name"
    });

    // Change Bootstrap Icons
    $(document).on("change", "select[name=icon]", function() {
        var value = $(this).val();
        $(this).siblings(".h3").find("i").attr("class",value);
    });
</script>

@endsection