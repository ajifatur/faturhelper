@extends('faturhelper::layouts/admin/main')

@section('title', 'Pengaturan')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pengaturan</h1>
</div>
<div class="row">
    <div class="col-md-4 col-xl-3 mb-3 mb-md-0">
        <div class="list-group">
            <a href="#pengaturan-umum" class="list-group-item list-group-item-action py-2 px-3">Umum</a>
            <a href="#pengaturan-alamat-dan-kontak" class="list-group-item list-group-item-action py-2 px-3">Alamat dan Kontak</a>
            <a href="#pengaturan-medsos" class="list-group-item list-group-item-action py-2 px-3">Username Media Sosial</a>
            <a href="#pengaturan-script-google" class="list-group-item list-group-item-action py-2 px-3">Script Google</a>
            <a href="#pengaturan-footer-copyright" class="list-group-item list-group-item-action py-2 px-3">Footer Copyright</a>
            <a href="#pengaturan-autentikasi" class="list-group-item list-group-item-action py-2 px-3">Autentikasi</a>
            <a href="#pengaturan-role" class="list-group-item list-group-item-action py-2 px-3">Role</a>
            <a href="#pengaturan-gender" class="list-group-item list-group-item-action py-2 px-3">Gender</a>
        </div>
    </div>
	<div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form method="post" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="card-title mb-3" id="pengaturan-umum">Umum</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Nama<span class="text-danger">*</span><br><code>setting('name')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[name]" class="form-control form-control-sm {{ $errors->has('setting.name') ? 'border-danger' : '' }}" value="{{ setting('name') }}">
                            @if($errors->has('setting.name'))
                            <div class="small text-danger">{{ $errors->first('setting.name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Tagline<br><code>setting('tagline')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[tagline]" class="form-control form-control-sm {{ $errors->has('setting.tagline') ? 'border-danger' : '' }}" value="{{ setting('tagline') }}">
                            @if($errors->has('setting.tagline'))
                            <div class="small text-danger">{{ $errors->first('setting.tagline') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Zona Waktu<span class="text-danger">*</span><br><code>setting('timezone')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <select name="setting[timezone]" class="form-select form-select-sm {{ $errors->has('setting.timezone') ? 'border-danger' : '' }}" id="timezone">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($timezones as $timezone)
                                <option value="{{ $timezone }}" {{ setting('timezone') == $timezone ? 'selected' : '' }}>{{ $timezone }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('setting.timezone'))
                            <div class="small text-danger">{{ $errors->first('setting.timezone') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-alamat-dan-kontak">Alamat dan Kontak</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Alamat Lengkap<br><code>setting('address')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="setting[address]" class="form-control form-control-sm {{ $errors->has('setting.address') ? 'border-danger' : '' }}" rows="3">{{ setting('address') }}</textarea>
                            @if($errors->has('setting.address'))
                            <div class="small text-danger">{{ $errors->first('setting.address') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Kota<br><code>setting('city')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[city]" class="form-control form-control-sm {{ $errors->has('setting.city') ? 'border-danger' : '' }}" value="{{ setting('city') }}">
                            @if($errors->has('setting.city'))
                            <div class="small text-danger">{{ $errors->first('setting.city') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Email<br><code>setting('email')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="email" name="setting[email]" class="form-control form-control-sm {{ $errors->has('setting.email') ? 'border-danger' : '' }}" value="{{ setting('email') }}">
                            @if($errors->has('setting.email'))
                            <div class="small text-danger">{{ $errors->first('setting.email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Nomor Telepon<br><code>setting('phone_number')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[phone_number]" class="form-control form-control-sm {{ $errors->has('setting.phone_number') ? 'border-danger' : '' }}" value="{{ setting('phone_number') }}">
                            @if($errors->has('setting.phone_number'))
                            <div class="small text-danger">{{ $errors->first('setting.phone_number') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Nomor WhatsApp<br><code>setting('whatsapp')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[whatsapp]" class="form-control form-control-sm {{ $errors->has('setting.whatsapp') ? 'border-danger' : '' }}" value="{{ setting('whatsapp') }}">
                            @if($errors->has('setting.whatsapp'))
                            <div class="small text-danger">{{ $errors->first('setting.whatsapp') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-medsos">Username Media Sosial</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Instagram<br><code>setting('instagram')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[instagram]" class="form-control form-control-sm {{ $errors->has('setting.instagram') ? 'border-danger' : '' }}" value="{{ setting('instagram') }}">
                            @if($errors->has('setting.instagram'))
                            <div class="small text-danger">{{ $errors->first('setting.instagram') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            YouTube<br><code>setting('youtube')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[youtube]" class="form-control form-control-sm {{ $errors->has('setting.youtube') ? 'border-danger' : '' }}" value="{{ setting('youtube') }}">
                            @if($errors->has('setting.youtube'))
                            <div class="small text-danger">{{ $errors->first('setting.youtube') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Facebook<br><code>setting('facebook')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[facebook]" class="form-control form-control-sm {{ $errors->has('setting.facebook') ? 'border-danger' : '' }}" value="{{ setting('facebook') }}">
                            @if($errors->has('setting.facebook'))
                            <div class="small text-danger">{{ $errors->first('setting.facebook') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Twitter<br><code>setting('twitter')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[twitter]" class="form-control form-control-sm {{ $errors->has('setting.twitter') ? 'border-danger' : '' }}" value="{{ setting('twitter') }}">
                            @if($errors->has('setting.twitter'))
                            <div class="small text-danger">{{ $errors->first('setting.twitter') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-script-google">Script Google</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Google Maps<br><code>setting('google_maps')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="setting[google_maps]" class="form-control form-control-sm {{ $errors->has('setting.google_maps') ? 'border-danger' : '' }}" rows="5">{!! setting('google_maps') !!}</textarea>
                            @if($errors->has('setting.google_maps'))
                            <div class="small text-danger">{{ $errors->first('setting.google_maps') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Google Tag Manager<br><code>setting('google_tag_manager')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="setting[google_tag_manager]" class="form-control form-control-sm {{ $errors->has('setting.google_tag_manager') ? 'border-danger' : '' }}" rows="5">{!! setting('google_tag_manager') !!}</textarea>
                            @if($errors->has('setting.google_tag_manager'))
                            <div class="small text-danger">{{ $errors->first('setting.google_tag_manager') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-footer-copyright">Footer Copyright</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Nama Brand<br><code>setting('brand_name')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[brand_name]" class="form-control form-control-sm {{ $errors->has('setting.brand_name') ? 'border-danger' : '' }}" value="{{ setting('brand_name') }}">
                            @if($errors->has('setting.brand_name'))
                            <div class="small text-danger">{{ $errors->first('setting.brand_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            URL Brand<br><code>setting('brand_url')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <input type="text" name="setting[brand_url]" class="form-control form-control-sm {{ $errors->has('setting.brand_url') ? 'border-danger' : '' }}" value="{{ setting('brand_url') }}">
                            @if($errors->has('setting.brand_url'))
                            <div class="small text-danger">{{ $errors->first('setting.brand_url') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Tampilkan Brand<span class="text-danger">*</span><br><code>setting('brand_visibility')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[brand_visibility]" id="brand_visibility-1" value="1" {{ setting('brand_visibility') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand_visibility-1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[brand_visibility]" id="brand_visibility-0" value="0" {{ setting('brand_visibility') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand_visibility-0">Tidak</label>
                            </div>
                            @if($errors->has('setting.brand_visibility'))
                            <div class="small text-danger">{{ $errors->first('setting.brand_visibility') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-autentikasi">Autentikasi</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Login via Email<span class="text-danger">*</span><br><code>setting('allow_login_by_email')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[allow_login_by_email]" id="allow_login_by_email-1" value="1" {{ setting('allow_login_by_email') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_login_by_email-1">Izinkan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[allow_login_by_email]" id="allow_login_by_email-0" value="0" {{ setting('allow_login_by_email') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_login_by_email-0">Tolak</label>
                            </div>
                            @if($errors->has('setting.allow_login_by_email'))
                            <div class="small text-danger">{{ $errors->first('setting.allow_login_by_email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Non-Admin Bisa Login<span class="text-danger">*</span><br><code>setting('non_admin_can_login')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[non_admin_can_login]" id="non_admin_can_login-1" value="1" {{ setting('non_admin_can_login') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="non_admin_can_login-1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[non_admin_can_login]" id="non_admin_can_login-0" value="0" {{ setting('non_admin_can_login') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="non_admin_can_login-0">Tidak</label>
                            </div>
                            @if($errors->has('setting.non_admin_can_login'))
                            <div class="small text-danger">{{ $errors->first('setting.non_admin_can_login') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Socialite<span class="text-danger">*</span><br><code>setting('socialite')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[socialite]" id="socialite-1" value="1" {{ setting('socialite') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="socialite-1">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[socialite]" id="socialite-0" value="0" {{ setting('socialite') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="socialite-0">Tidak Aktif</label>
                            </div>
                            @if($errors->has('setting.socialite'))
                            <div class="small text-danger">{{ $errors->first('setting.socialite') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Default Role Socialite<span class="text-danger">*</span><br><code>setting('socialite_default_role')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            @foreach($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[socialite_default_role]" id="socialite_default_role-{{ $role->id }}" value="{{ $role->code }}" {{ setting('socialite_default_role') == $role->code ? 'checked' : '' }}>
                                <label class="form-check-label" for="socialite_default_role-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                            @endforeach
                            @if($errors->has('setting.socialite_default_role'))
                            <div class="small text-danger">{{ $errors->first('setting.socialite_default_role') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Akun Tidak Terdaftar Bisa Login<span class="text-danger">*</span><br><code>setting('allow_unregistered_account')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[allow_unregistered_account]" id="allow_unregistered_account-1" value="1" {{ setting('allow_unregistered_account') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_unregistered_account-1">Izinkan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[allow_unregistered_account]" id="allow_unregistered_account-0" value="0" {{ setting('allow_unregistered_account') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_unregistered_account-0">Tolak</label>
                            </div>
                            @if($errors->has('setting.allow_unregistered_account'))
                            <div class="small text-danger">{{ $errors->first('setting.allow_unregistered_account') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-role">Role</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Multi-Role<span class="text-danger">*</span><br><code>setting('multiple_roles')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[multiple_roles]" id="multiple_roles-1" value="1" {{ setting('multiple_roles') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="multiple_roles-1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[multiple_roles]" id="multiple_roles-0" value="0" {{ setting('multiple_roles') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="multiple_roles-0">Tidak</label>
                            </div>
                            @if($errors->has('setting.multiple_roles'))
                            <div class="small text-danger">{{ $errors->first('setting.multiple_roles') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3" id="pengaturan-gender">Gender</h5>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-md-4 col-form-label">
                            Tampilkan Gender N<span class="text-danger">*</span><br><code>setting('n_gender_visibility')</code>
                        </label>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[n_gender_visibility]" id="n_gender_visibility-1" value="1" {{ setting('n_gender_visibility') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="n_gender_visibility-1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[n_gender_visibility]" id="n_gender_visibility-0" value="0" {{ setting('n_gender_visibility') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="n_gender_visibility-0">Tidak</label>
                            </div>
                            @if($errors->has('setting.n_gender_visibility'))
                            <div class="small text-danger">{{ $errors->first('setting.n_gender_visibility') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 col-md-4"></div>
                        <div class="col-lg-9 col-md-8">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
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
    Spandiv.Select2("#timezone");
</script>

@endsection