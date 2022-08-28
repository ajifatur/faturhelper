@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Pengguna: '.$user->name)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Pengguna: {{ $user->name }}</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.user.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ $user->name }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-10 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="birthdate" class="form-control form-control-sm {{ $errors->has('birthdate') ? 'border-danger' : '' }}" value="{{ $user->attribute ? date('d/m/Y', strtotime($user->attribute->birthdate)) : '' }}" autocomplete="off">
                                <span class="input-group-text"><i class="bi-calendar2"></i></span>
                            </div>
                            @if($errors->has('birthdate'))
                            <div class="small text-danger">{{ $errors->first('birthdate') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-10 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            @foreach(gender() as $gender)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender-{{ $gender['key'] }}" value="{{ $gender['key'] }}" {{ $user->attribute && $user->attribute->gender == $gender['key'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender-{{ $gender['key'] }}">
                                    {{ $gender['name'] }}
                                </label>
                            </div>
                            @endforeach
                            @if($errors->has('gender'))
                            <div class="small text-danger">{{ $errors->first('gender') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-10 col-form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group">
                                <select name="country_code" class="form-select form-select-sm {{ $errors->has('country_code') ? 'border-danger' : '' }}" id="select2" style="width: 40%"></select>
                                <input type="text" name="phone_number" class="form-control form-control-sm {{ $errors->has('phone_number') ? 'border-danger' : '' }}" value="{{ $user->attribute ? $user->attribute->phone_number : '' }}">
                            </div>
                            @if($errors->has('phone_number'))
                            <div class="small text-danger">{{ $errors->first('phone_number') }}</div>
                            @elseif($errors->has('country_code'))
                            <div class="small text-danger">{{ $errors->first('country_code') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-10 col-form-label">Role <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="role" class="form-select form-select-sm {{ $errors->has('role') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                            <div class="small text-danger">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="email" name="email" class="form-control form-control-sm {{ $errors->has('email') ? 'border-danger' : '' }}" value="{{ $user->email }}" autofocus>
                            @if($errors->has('email'))
                            <div class="small text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="username" class="form-control form-control-sm {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ $user->username }}">
                            @if($errors->has('username'))
                            <div class="small text-danger">{{ $errors->first('username') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Password <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control form-control-sm {{ $errors->has('password') ? 'border-danger' : '' }}">
                                <button type="button" class="btn btn-sm {{ $errors->has('password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                            </div>
                            @if($errors->has('password'))
                            <div class="small text-danger">{{ $errors->first('password') }}</div>
                            @endif
                            <div class="small text-muted">Kosongi saja jika tidak ingin mengganti password</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            @foreach(status() as $status)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-{{ $status['key'] }}" value="{{ $status['key'] }}" {{ $user->status == $status['key'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-{{ $status['key'] }}">
                                    {{ $status['name'] }}
                                </label>
                            </div>
                            @endforeach
                            @if($errors->has('status'))
                            <div class="small text-danger">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
    // Get Country Codes
    Spandiv.Select2ServerSide("#select2", {
        url: "{{ route('api.country-code') }}",
        value: "{{ $user->attribute ? $user->attribute->country_code : '' }}",
        valueProp: "code",
        nameProp: "name",
        bracketProp: "dial_code"
    });
    
    // Datepicker
    Spandiv.DatePicker("input[name=birthdate]");
</script>

@endsection