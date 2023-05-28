@extends('faturhelper::layouts/admin/main')

@section('title', 'Tambah Menu Item di '.($menu_header->name != '' ? $menu_header->name : '<Tanpa Header>'))

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
                            <select name="route" class="form-select form-select-sm {{ $errors->has('route') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($getMethodRoutes as $route)
                                <option value="{{ $route }}" {{ old('route') == $route ? 'selected' : '' }}>{{ $route }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('route'))
                            <div class="small text-danger">{{ $errors->first('route') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Route Parameter</label>
                        <div class="col-lg-10 col-md-9" id="route-params">
                            <div class="input-group input-group-sm mb-2" data-id="1">
                                <input type="text" name="params[]" class="form-control form-control-sm" placeholder="Parameter">
                                <input type="text" name="values[]" class="form-control form-control-sm" placeholder="Value">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-add-row" data-id="1"><i class="bi-plus"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-delete-row" data-id="1"><i class="bi-trash"></i></button>
                            </div>
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
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible_radio" id="visible-radio-1" value="1" {{ old('visible_conditions') == '' ? 'checked' : '' }}>
                                <label class="form-check-label" for="visible-radio-1">
                                    Selalu Terlihat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible_radio" id="visible-radio-2" value="2" {{ is_int(strpos(old('visible_conditions'), 'Auth::user()->role_id')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="visible-radio-2">
                                    Terlihat Berdasarkan Role
                                </label>
                            </div>
                            <div class="card border my-2 {{ is_int(strpos(old('visible_conditions'), 'Auth::user()->role_id')) ? '' : 'd-none' }}" id="card-role">
                                <div class="card-body p-2 ps-4">
                                    @foreach($roles as $role)
                                        @if($role->code == 'super-admin')
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="role" id="role-{{ $role->id }}" value="{{ $role->code }}" disabled checked>
                                                <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        @else
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="role" id="role-{{ $role->id }}" value="{{ $role->code }}" {{ is_int(strpos(old('visible_conditions'), 'Auth::user()->role_id')) && is_int(strpos(old('visible_conditions'), "role('".$role->code."')")) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible_radio" id="visible-radio-0" value="0">
                                <label class="form-check-label" for="visible-radio-0">
                                    Kustom
                                </label>
                            </div>
                            <textarea name="visible_conditions" class="form-control form-control-sm {{ $errors->has('visible_conditions') ? 'border-danger' : '' }} mt-2" rows="3" readonly>{{ old('visible_conditions') }}</textarea>
                            @if($errors->has('visible_conditions'))
                            <div class="small text-danger">{{ $errors->first('visible_conditions') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kondisi Item akan Aktif <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active_radio" id="active-radio-1" value="1" {{ is_int(strpos(old('active_conditions'), ' == ')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active-radio-1">
                                    Sama Dengan Route Tertentu
                                </label>
                            </div>
                            <div class="my-2 ms-4 {{ is_int(strpos(old('active_conditions'), ' == ')) ? '' : 'd-none' }}" id="card-route-1">
                                <?php
                                    $filter = str_replace("Request::url() == route('", "", old('active_conditions'));
                                    $filter = str_replace("')", "", $filter);
                                ?>
                                <select name="getMethodRoutes" class="form-select form-select-sm {{ $errors->has('getMethodRoutes') ? 'border-danger' : '' }}">
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($getMethodRoutes as $route)
                                    <option value="{{ $route }}" {{ $filter == $route ? 'selected' : '' }}>{{ $route }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active_radio" id="active-radio-2" value="2" {{ is_int(strpos(old('active_conditions'), 'is_int(strpos(Request::url()')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active-radio-2">
                                    Sama Dengan Route Index
                                </label>
                            </div>
                            <div class="my-2 ms-4 {{ is_int(strpos(old('active_conditions'), 'is_int(strpos(Request::url()')) ? '' : 'd-none' }}" id="card-route-2">
                                <?php
                                    $array = [];
                                    $explode = explode(" || ", old('active_conditions'));
                                    foreach($explode as $e) {
                                        $filter = str_replace("is_int(strpos(Request::url(), route('", "", $e);
                                        $filter = str_replace("')))", "", $filter);
                                        array_push($array, $filter);
                                    }
                                ?>
                                <select name="indexRoutes[]" class="form-select form-select-sm {{ $errors->has('indexRoutes') ? 'border-danger' : '' }}" multiple="multiple">
                                    <option value="" disabled>--Pilih--</option>
                                    @foreach($indexRoutes as $route)
                                    <option value="{{ $route }}" {{ in_array($route, $array) ? 'selected' : '' }}>{{ $route }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active_radio" id="active-radio-0" value="0">
                                <label class="form-check-label" for="active-radio-0">
                                    Kustom
                                </label>
                            </div>
                            <textarea name="active_conditions" class="form-control form-control-sm {{ $errors->has('active_conditions') ? 'border-danger' : '' }} mt-2" rows="3" readonly>{{ old('active_conditions') }}</textarea>
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
    // Select2
    Spandiv.Select2("select[name=route]");
    Spandiv.Select2("select[name=getMethodRoutes]");
    Spandiv.Select2("select[name='indexRoutes[]']");
    Spandiv.Select2ServerSide("#select2", {
        url: "{{ route('api.bootstrap-icons') }}",
        value: "",
        valueProp: "name",
        nameProp: "name"
    });

    // Change Bootstrap Icons
    $(document).on("change", "select[name=icon]", function() {
        var value = $(this).val();
        $(this).siblings(".h3").find("i").attr("class",value);
    });

    // Button Add Row
    $(document).on("click", "#route-params .btn-add-row", function(e) {
        e.preventDefault();
        var html = '';
        html += '<div class="input-group input-group-sm mb-2" data-id="1">';
        html += '<input type="text" name="params[]" class="form-control form-control-sm" placeholder="Parameter">';
        html += '<input type="text" name="values[]" class="form-control form-control-sm" placeholder="Value">';
        html += '<button type="button" class="btn btn-sm btn-outline-secondary btn-add-row" data-id="1"><i class="bi-plus"></i></button>';
        html += '<button type="button" class="btn btn-sm btn-outline-secondary btn-delete-row" data-id="1"><i class="bi-trash"></i></button>';
        html += '</div>';
        $("#route-params").append(html);
        generateRow();
    });

    // Button Delete Row
    $(document).on("click", "#route-params .btn-delete-row", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        if($("#route-params .input-group").length > 1)
            $("#route-params .input-group[data-id=" + id + "]").remove();
        else
            $("#route-params .input-group[data-id=" + id + "]").find("input").val(null);
        generateRow();
    });

    // Change Visible Radio
    $(document).on("click", "input[name=visible_radio]", function() {
        var value = $("input[name=visible_radio]:checked").val();
        if(value == 1) {
            $("#card-role").addClass("d-none");
            $("textarea[name=visible_conditions]").attr("readonly","readonly").val("");
        }
        else if(value == 2) {
            $("#card-role").removeClass("d-none");
            $("textarea[name=visible_conditions]").attr("readonly","readonly").val(generateRoles());
        }
        else if(value == 0) {
            $("#card-role").addClass("d-none");
            $("textarea[name=visible_conditions]").removeAttr("readonly");
        }
    });

    // Change Role Radio
    $(document).on("click", "input[name=role]", function() {
        $("textarea[name=visible_conditions]").val(generateRoles());
    });

    // Change Active Radio
    $(document).on("click", "input[name=active_radio]", function() {
        var value = $("input[name=active_radio]:checked").val();
        if(value == 1) {
            $("#card-route-1").removeClass("d-none");
            $("#card-route-2").addClass("d-none");
            Spandiv.Select2("select[name=getMethodRoutes]");
            $("textarea[name=active_conditions]").attr("readonly","readonly").val(generateRoutes1());
        }
        else if(value == 2) {
            $("#card-route-1").addClass("d-none");
            $("#card-route-2").removeClass("d-none");
            Spandiv.Select2("select[name='indexRoutes[]']");
            $("textarea[name=active_conditions]").attr("readonly","readonly").val(generateRoutes2());
        }
        else if(value == 0) {
            $("#card-route-1").addClass("d-none");
            $("#card-route-2").addClass("d-none");
            $("textarea[name=active_conditions]").removeAttr("readonly");
        }
    });

    // Change Get Method Routes
    $(document).on("change", "select[name=getMethodRoutes]", function() {
        $("textarea[name=active_conditions]").val(generateRoutes1());
    });

    // Change Index Routes
    $(document).on("change", "select[name='indexRoutes[]']", function() {
        $("textarea[name=active_conditions]").val(generateRoutes2());
    });
</script>
<script>
    function generateRow() {
        $("#route-params .input-group").each(function(key,elem) {
            $(elem).attr("data-id",(key+1));
            $(elem).find(".btn-add-row").attr("data-id",(key+1));
            $(elem).find(".btn-delete-row").attr("data-id",(key+1));
        });
    }

    function generateRoles() {
        var array = [];
        var roles = $("input[name=role]:checked");
        for(var i=0; i<roles.length; i++) {
            array.push("((!session()->has('role') && Auth::user()->role_id == role('" + $(roles[i]).val() + "')) || (session()->has('role') && session('role') == role('" + $(roles[i]).val() + "')))");
        }
        return array.join(" || ");
    }

    function generateRoutes1() {
        var route = $("select[name=getMethodRoutes]").val();
        return route != null ? "Request::url() == route('" + route + "')" : "";
    }

    function generateRoutes2() {
        var array = [];
        var routes = $("select[name='indexRoutes[]']").val();
        for(var i=0; i<routes.length; i++) {
            array.push("is_int(strpos(Request::url(), route('" + routes[i] + "')))")
        }
        return array.join(" || ");
    }
</script>

@endsection