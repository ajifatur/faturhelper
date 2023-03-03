@extends('faturhelper::layouts/admin/main')

@section('title', 'Pengaturan Gambar')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pengaturan Gambar</h1>
</div>
<div class="row">
    @if(Session::get('message'))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-message">{{ Session::get('message') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4>Icon</h4>
                <p>Klik gambar di bawah ini untuk mengganti icon:</p>
                <div class="d-flex justify-content-center text-center">
                    @if(setting('icon') != '' && File::exists(public_path('assets/images/icons/'.setting('icon'))))
                        <div class="btn-avatar text-center" data-type="icon">
                            <div class="avatar-overlay rounded-0"><i class="bi-camera"></i></div>
                            <img src="{{ asset('assets/images/icons/'.setting('icon')) }}" height="150" width="150" alt="Icon">
                        </div>
                    @else
                        <div class="btn-avatar rounded-circle me-2 text-center bg-dark" data-type="icon">
                            <div class="avatar-overlay"><i class="bi-camera"></i></div>
                            <h2 class="text-white" style="line-height: 150px; font-size: 75px;">{{ strtoupper(substr(setting('name'),0,1)) }}</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4>Logo</h4>
                    @if(setting('logo') != '' && File::exists(public_path('assets/images/logos/'.setting('logo'))))
                    <button class="btn btn-sm btn-danger btn-delete-logo">Hapus Logo</button>
                    @endif
                </div>
                <p>Klik gambar di bawah ini untuk mengganti logo:</p>
                <div class="d-flex justify-content-center text-center">
                    @if(setting('logo') != '' && File::exists(public_path('assets/images/logos/'.setting('logo'))))
                        <div class="btn-avatar text-center" style="width: auto!important;" data-type="logo" data-bs-toggle="tooltip" title="Klik untuk mengganti logo">
                            <img src="{{ asset('assets/images/logos/'.setting('logo')) }}" height="150" alt="Logo" style="max-width: 100%;">
                        </div>
                    @else
                        <div class="btn-avatar text-center bg-dark" data-type="logo" style="width: auto!important;" data-bs-toggle="tooltip" title="Klik untuk mengganti logo">
                            <h2 class="text-white" style="line-height: 150px; font-size: 75px;">{{ setting('name') }}</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-icon fade" id="modal-image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unggah / Pilih Gambar</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="tab-user-avatar" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-icon-tab" data-bs-toggle="tab" data-bs-target="#upload-icon" type="button" role="tab" aria-controls="upload-icon" aria-selected="true">Unggah</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="choose-icon-tab" data-bs-toggle="tab" data-bs-target="#choose-icon" type="button" role="tab" aria-controls="choose-icon" aria-selected="false">Pilih</button>
                    </li>
                </ul>
                <div class="tab-content my-3">
                    <div class="tab-pane fade show active" id="upload-icon" role="tabpanel" aria-labelledby="upload-icon-tab">
                        <p class="text-center">Usahakan rasio 1:1 dengan format PNG.</p>
                        <div class="dropzone">
                            <div class="dropzone-description">
                                <i class="dropzone-icon bi-upload"></i>
                                <p>Pilih file gambar atau geser ke sini.</p>
                            </div>
                            <input type="file" name="file" class="dropzone-input image-input" accept="image/png">
                        </div>
                        <div class="text-center mt-3 d-none">
                            <img height="192">
                            <br>
                            <button class="btn btn-sm btn-primary btn-submit-image mt-3">Submit</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="choose-icon" role="tabpanel" aria-labelledby="choose-icon-tab"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-logo fade" id="modal-image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unggah / Pilih Gambar</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="tab-user-avatar" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-logo-tab" data-bs-toggle="tab" data-bs-target="#upload-logo" type="button" role="tab" aria-controls="upload-logo" aria-selected="true">Unggah</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="choose-logo-tab" data-bs-toggle="tab" data-bs-target="#choose-logo" type="button" role="tab" aria-controls="choose-logo" aria-selected="false">Pilih</button>
                    </li>
                </ul>
                <div class="tab-content my-3">
                    <div class="tab-pane fade show active" id="upload-logo" role="tabpanel" aria-labelledby="upload-logo-tab">
                        <p class="text-center">Usahakan format PNG.</p>
                        <div class="dropzone">
                            <div class="dropzone-description">
                                <i class="dropzone-icon bi-upload"></i>
                                <p>Pilih file gambar atau geser ke sini.</p>
                            </div>
                            <input type="file" name="file" class="dropzone-input image-input" accept="image/png">
                        </div>
                        <div class="text-center mt-3 d-none">
                            <img height="192">
                            <br>
                            <button class="btn btn-sm btn-primary btn-submit-image mt-3">Submit</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="choose-logo" role="tabpanel" aria-labelledby="choose-logo-tab"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<form class="form-upload-icon" method="post" action="{{ route('admin.setting.image.update') }}">
    @csrf
    <input type="hidden" name="image">
    <input type="hidden" name="type" value="icon">
</form>

<form class="form-choose-icon" method="post" action="{{ route('admin.setting.image.update') }}">
    @csrf
    <input type="hidden" name="image">
    <input type="hidden" name="type" value="icon">
    <input type="hidden" name="choose" value="1">
</form>

<form class="form-upload-logo" method="post" action="{{ route('admin.setting.image.update') }}">
    @csrf
    <input type="hidden" name="image">
    <input type="hidden" name="type" value="logo">
</form>

<form class="form-choose-logo" method="post" action="{{ route('admin.setting.image.update') }}">
    @csrf
    <input type="hidden" name="image">
    <input type="hidden" name="type" value="logo">
    <input type="hidden" name="choose" value="1">
</form>

<form class="form-delete-logo" method="post" action="{{ route('admin.setting.image.delete') }}">
    @csrf
    <input type="hidden" name="type" value="logo">
</form>

@endsection

@section('js')

<script>
    // Button Avatar
    $(document).on("click", ".btn-avatar", function() {
        var type = $(this).data("type");
        Spandiv.Tab("#tab-user-avatar [data-bs-target='#upload-" + type + "']").show();
        Spandiv.Modal(".modal-" + type).show();
    });

    // Change Image Input (Icon)
    $(document).on("change", ".modal-icon .image-input", function(event) {
        if(this.files && this.files[0]) {
            var filenameSplit = this.value.split('.');
            if(filenameSplit[filenameSplit.length-1] != 'png') {
                Spandiv.Alert("Ekstensi harus PNG!");
                this.value = null;
            }
            else {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".form-upload-icon input[name=image]").val(e.target.result);
                    $("#upload-icon img").attr("src", e.target.result);
                    $("#upload-icon img").parent("div.text-center").removeClass("d-none");
                }
                reader.readAsDataURL(this.files[0]);
                this.value = null;
            }
        }
    });

    // Button Submit Image (Icon)
    $(document).on("click", ".modal-icon .btn-submit-image", function(e) {
        e.preventDefault();
        Spandiv.Confirm("Anda yakin ingin mengganti dengan gambar ini?", ".form-upload-icon");
    });

    // Change Image Input (Logo)
    $(document).on("change", ".modal-logo .image-input", function(event) {
        if(this.files && this.files[0]) {
            var filenameSplit = this.value.split('.');
            if(filenameSplit[filenameSplit.length-1] != 'png') {
                Spandiv.Alert("Ekstensi harus PNG!");
                this.value = null;
            }
            else {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".form-upload-logo input[name=image]").val(e.target.result);
                    $("#upload-logo img").attr("src", e.target.result);
                    $("#upload-logo img").parent("div.text-center").removeClass("d-none");
                }
                reader.readAsDataURL(this.files[0]);
                this.value = null;
            }
        }
    });

    // Button Submit Image (Logo)
    $(document).on("click", ".modal-logo .btn-submit-image", function(e) {
        e.preventDefault();
        Spandiv.Confirm("Anda yakin ingin mengganti dengan gambar ini?", ".form-upload-logo");
    });

    // Event Listener on Choose Image Tab (Icon)
    document.querySelector("[data-bs-toggle='tab'][data-bs-target='#choose-icon']").addEventListener("shown.bs.tab", function(e) {
        if($("#choose-icon").find(".row").length === 0) {
            $.ajax({
                type: "get",
                url: "{{ route('admin.setting.icon') }}",
                success: function(response) {
                    var html = '';
                    if(response.length > 0) {
                        html += '<div class="row">';
                        for(var i=0; i<response.length; i++) {
                            html += '<div class="col-auto text-center">';
                            html += '<img src="{{ asset("assets/images/icons") }}/' + response[i] + '" class="img-thumbnail rounded-circle mb-2 btn-choose-icon" data-image="' + response[i] + '" data-bs-toggle="tooltip" title="Pilih Gambar" width="150" style="cursor: pointer;">';
                            html += '</div>';
                        }
                        html += '</div>';
                    }
                    else {
                        html += '<div class="alert alert-danger"><div class="alert-message">Tidak ada gambar.</div></div>';
                    }
                    $("#choose-icon").html(html);
                    Spandiv.Tooltip();
                }
            });
        }
    });

    // Button Choose Image (Icon)
    $(document).on("click", ".btn-choose-icon", function(e) {
        e.preventDefault();
        var image = $(this).data("image");
        $(".form-choose-icon").find("input[name=image]").val(image);
        Spandiv.Confirm("Anda yakin ingin mengganti dengan gambar ini?", ".form-choose-icon");
    });

    // Event Listener on Choose Image Tab (Logo)
    document.querySelector("[data-bs-toggle='tab'][data-bs-target='#choose-logo']").addEventListener("shown.bs.tab", function(e) {
        if($("#choose-logo").find(".row").length === 0) {
            $.ajax({
                type: "get",
                url: "{{ route('admin.setting.logo') }}",
                success: function(response) {
                    var html = '';
                    if(response.length > 0) {
                        html += '<div class="row">';
                        for(var i=0; i<response.length; i++) {
                            html += '<div class="col-auto text-center">';
                            html += '<img src="{{ asset("assets/images/logos") }}/' + response[i] + '" class="img-thumbnail rounded-circle mb-2 btn-choose-logo" data-image="' + response[i] + '" data-bs-toggle="tooltip" title="Pilih Gambar" width="150" style="cursor: pointer;">';
                            html += '</div>';
                        }
                        html += '</div>';
                    }
                    else {
                        html += '<div class="alert alert-danger"><div class="alert-message">Tidak ada gambar.</div></div>';
                    }
                    $("#choose-logo").html(html);
                    Spandiv.Tooltip();
                }
            });
        }
    });

    // Button Choose Image (Logo)
    $(document).on("click", ".btn-choose-logo", function(e) {
        e.preventDefault();
        var image = $(this).data("image");
        $(".form-choose-logo").find("input[name=image]").val(image);
        Spandiv.Confirm("Anda yakin ingin mengganti dengan gambar ini?", ".form-choose-logo");
    });

    // Button Delete (Logo)
    $(document).on("click", ".btn-delete-logo", function(e) {
        e.preventDefault();
        Spandiv.Confirm("Anda yakin ingin menghapus gambar ini?", ".form-delete-logo");
    });
</script>

@endsection