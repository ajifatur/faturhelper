@extends('faturhelper::layouts/admin/main')

@section('title', 'Pengaturan')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pengaturan</h1>
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
                <form method="post" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="card-title mb-3">Umum</h5>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Nama<span class="text-danger">*</span><br><code>setting('name')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[name]" class="form-control form-control-sm {{ $errors->has('setting.name') ? 'border-danger' : '' }}" value="{{ setting('name') }}">
                            @if($errors->has('setting.name'))
                            <div class="small text-danger">{{ $errors->first('setting.name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Tagline<br><code>setting('tagline')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[tagline]" class="form-control form-control-sm {{ $errors->has('setting.tagline') ? 'border-danger' : '' }}" value="{{ setting('tagline') }}">
                            @if($errors->has('setting.tagline'))
                            <div class="small text-danger">{{ $errors->first('setting.tagline') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Zona Waktu<span class="text-danger">*</span><br><code>setting('timezone')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
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
                    <h5 class="card-title mb-3">Alamat dan Kontak</h5>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Alamat Lengkap<br><code>setting('address')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="setting[address]" class="form-control form-control-sm {{ $errors->has('setting.address') ? 'border-danger' : '' }}" rows="3">{{ setting('address') }}</textarea>
                            @if($errors->has('setting.address'))
                            <div class="small text-danger">{{ $errors->first('setting.address') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Kota<br><code>setting('city')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[city]" class="form-control form-control-sm {{ $errors->has('setting.city') ? 'border-danger' : '' }}" value="{{ setting('city') }}">
                            @if($errors->has('setting.city'))
                            <div class="small text-danger">{{ $errors->first('setting.city') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Email<br><code>setting('email')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="email" name="setting[email]" class="form-control form-control-sm {{ $errors->has('setting.email') ? 'border-danger' : '' }}" value="{{ setting('email') }}">
                            @if($errors->has('setting.email'))
                            <div class="small text-danger">{{ $errors->first('setting.email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Nomor Telepon<br><code>setting('phone_number')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[phone_number]" class="form-control form-control-sm {{ $errors->has('setting.phone_number') ? 'border-danger' : '' }}" value="{{ setting('phone_number') }}">
                            @if($errors->has('setting.phone_number'))
                            <div class="small text-danger">{{ $errors->first('setting.phone_number') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Nomor WhatsApp<br><code>setting('whatsapp')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[whatsapp]" class="form-control form-control-sm {{ $errors->has('setting.whatsapp') ? 'border-danger' : '' }}" value="{{ setting('whatsapp') }}">
                            @if($errors->has('setting.whatsapp'))
                            <div class="small text-danger">{{ $errors->first('setting.whatsapp') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3">Username Media Sosial</h5>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Instagram<br><code>setting('instagram')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[instagram]" class="form-control form-control-sm {{ $errors->has('setting.instagram') ? 'border-danger' : '' }}" value="{{ setting('instagram') }}">
                            @if($errors->has('setting.instagram'))
                            <div class="small text-danger">{{ $errors->first('setting.instagram') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            YouTube<br><code>setting('youtube')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[youtube]" class="form-control form-control-sm {{ $errors->has('setting.youtube') ? 'border-danger' : '' }}" value="{{ setting('youtube') }}">
                            @if($errors->has('setting.youtube'))
                            <div class="small text-danger">{{ $errors->first('setting.youtube') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Facebook<br><code>setting('facebook')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[facebook]" class="form-control form-control-sm {{ $errors->has('setting.facebook') ? 'border-danger' : '' }}" value="{{ setting('facebook') }}">
                            @if($errors->has('setting.facebook'))
                            <div class="small text-danger">{{ $errors->first('setting.facebook') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Twitter<br><code>setting('twitter')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="setting[twitter]" class="form-control form-control-sm {{ $errors->has('setting.twitter') ? 'border-danger' : '' }}" value="{{ setting('twitter') }}">
                            @if($errors->has('setting.twitter'))
                            <div class="small text-danger">{{ $errors->first('setting.twitter') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title mb-3">Script Google</h5>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Google Maps<br><code>setting('google_maps')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="setting[google_maps]" class="form-control form-control-sm {{ $errors->has('setting.google_maps') ? 'border-danger' : '' }}" rows="5">{!! setting('google_maps') !!}</textarea>
                            @if($errors->has('setting.google_maps'))
                            <div class="small text-danger">{{ $errors->first('setting.google_maps') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">
                            Google Tag Manager<br><code>setting('google_tag_manager')</code>
                        </label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="setting[google_tag_manager]" class="form-control form-control-sm {{ $errors->has('setting.google_tag_manager') ? 'border-danger' : '' }}" rows="5">{!! setting('google_tag_manager') !!}</textarea>
                            @if($errors->has('setting.google_tag_manager'))
                            <div class="small text-danger">{{ $errors->first('setting.google_tag_manager') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tampilkan Brand <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[show_brand]" id="show_brand-1" value="1" {{ setting('show_brand') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_brand-1">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="setting[show_brand]" id="show_brand-0" value="0" {{ setting('show_brand') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_brand-0">Tidak</label>
                            </div>
                            @if($errors->has('setting.show_brand'))
                            <div class="small text-danger">{{ $errors->first('setting.show_brand') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
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