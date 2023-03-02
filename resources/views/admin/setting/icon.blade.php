@extends('faturhelper::layouts/admin/main')

@section('title', 'Pengaturan Icon')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pengaturan Icon</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <p>Klik gambar di bawah ini untuk mengganti icon:</p>
                <div class="d-flex justify-content-center text-center">
                    @if(setting('icon') != '' && File::exists(public_path('assets/images/icons/'.setting('icon'))))
                        <div class="btn-avatar rounded-circle me-2 text-center">
                            <div class="avatar-overlay"><i class="bi-camera"></i></div>
                            <img src="{{ asset('assets/images/icons/'.setting('icon')) }}" class="rounded-circle" height="150" width="150" alt="Icon">
                        </div>
                    @else
                        <div class="btn-avatar rounded-circle me-2 text-center bg-dark">
                            <div class="avatar-overlay"><i class="bi-camera"></i></div>
                            <h2 class="text-white" style="line-height: 150px; font-size: 75px;">{{ strtoupper(substr(setting('name'),0,1)) }}</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-image" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unggah / Pilih Icon</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="tab-user-avatar" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-image-tab" data-bs-toggle="tab" data-bs-target="#upload-image" type="button" role="tab" aria-controls="upload-image" aria-selected="true">Unggah</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="choose-image-tab" data-bs-toggle="tab" data-bs-target="#choose-image" type="button" role="tab" aria-controls="choose-image" aria-selected="false">Pilih</button>
                    </li>
                </ul>
                <div class="tab-content my-3">
                    <div class="tab-pane fade show active" id="upload-image" role="tabpanel" aria-labelledby="upload-image-tab">
                        <p class="text-center">Ukuran 192 x 192 pixel.</p>
                        <div class="dropzone">
                            <div class="dropzone-description">
                                <i class="dropzone-icon bi-upload"></i>
                                <p>Pilih file gambar atau geser ke sini.</p>
                            </div>
                            <input type="file" name="file" class="dropzone-input croppie-input" accept="image/*">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="choose-image" role="tabpanel" aria-labelledby="choose-image-tab">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-croppie" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sesuaikan Foto</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Ukuran 192 x 192 pixel.</p>
                <div class="table-responsive">
                    <div id="croppie"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary btn-croppie">Potong</button>
                <button class="btn btn-sm btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<form class="form-upload-image" method="post" action="{{ route('admin.setting.icon.update') }}">
    @csrf
    <input type="hidden" name="image">
</form>

<form class="form-choose-image" method="post" action="{{ route('admin.setting.icon.update') }}">
    @csrf
    <input type="hidden" name="image">
    <input type="hidden" name="choose" value="1">
</form>

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
    // Init Croppie
    var croppie = Spandiv.Croppie("#croppie", {
        width: 192,
        height: 192,
        type: 'circle'
    });

    // Button Avatar
    $(document).on("click", ".btn-avatar", function() {
        Spandiv.Tab("#tab-user-avatar [data-bs-target='#upload-image']").show();
        Spandiv.Modal("#modal-image").show();
    });

    // Change Croppie Input
    $(document).on("change", ".croppie-input", function() {
        Spandiv.CroppieBindFromURL(croppie, this);
        Spandiv.Modal("#modal-image").hide();
        Spandiv.Modal("#modal-croppie").show();
    });

    // Button Croppie
    $(document).on("click", ".btn-croppie", function(e) {
        e.preventDefault();
        Spandiv.CroppieSubmit(croppie, ".form-upload-image");
    });

    // Button Choose Image
    $(document).on("click", ".btn-choose-image", function(e) {
        e.preventDefault();
        var image = $(this).data("image");
        $(".form-choose-image").find("input[name=image]").val(image);
        Spandiv.Confirm("Anda yakin ingin mengganti dengan foto ini?", ".form-choose-image");
    });

    // Event Listener on Choose Image Tab
    document.querySelector("[data-bs-toggle='tab'][data-bs-target='#choose-image']").addEventListener("shown.bs.tab", function(e) {
        if($("#choose-image").find(".row").length === 0) {
            $.ajax({
                type: "get",
                url: "{{ route('admin.setting.icon') }}",
                success: function(response) {
                    var html = '';
                    if(response.length > 0) {
                        html += '<div class="row">';
                        for(var i=0; i<response.length; i++) {
                            html += '<div class="col-auto text-center">';
                            html += '<img src="{{ asset("assets/images/icons") }}/' + response[i] + '" class="img-thumbnail rounded-circle mb-2 btn-choose-image" data-image="' + response[i] + '" data-bs-toggle="tooltip" title="Pilih Foto" width="150" style="cursor: pointer;">';
                            html += '</div>';
                        }
                        html += '</div>';
                    }
                    else {
                        html += '<div class="alert alert-danger"><div class="alert-message">Tidak ada foto.</div></div>';
                    }
                    $("#choose-image").html(html);
                    Spandiv.Tooltip();
                }
            });
        }
    });
</script>

@endsection

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">

@endsection