@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Agenda')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Agenda</h1>
</div>

<div class="row">
    <div class="col-md-9 mb-3 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="fw-bold mb-0">Tambah Agenda</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.schedule.update') }}" enctype="multipart/form-data" id="form-schedule">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-sm {{ $errors->has('title') ? 'border-danger' : '' }}" value="{{ old('title') }}">
                        @if($errors->has('title'))
                        <div class="small text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea rows="3" class="form-control form-control-sm {{ $errors->has('description') ? 'border-danger' : '' }}" name="description">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                        <div class="small text-danger">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Warna <span class="text-danger">*</span></label>
                        <input type="color" name="color" class="form-control form-control-sm {{ $errors->has('color') ? 'border-danger' : '' }}" value="{{ old('color') }}">
                        @if($errors->has('color'))
                        <div class="small text-danger">{{ $errors->first('color') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Waktu <span class="text-danger">*</span></label>
                        <input type="text" name="time" class="form-control form-control-sm {{ $errors->has('time') ? 'border-danger' : '' }}" value="{{ old('time') }}">
                        @if($errors->has('time'))
                        <div class="small text-danger">{{ $errors->first('time') }}</div>
                        @endif
                    </div>
                    <hr class="my-0">
                    <div class="mt-3">
                        <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-save"></i> Simpan</button>
                        <button class="btn btn-sm btn-danger" type="reset"><i class="bi bi-x-square"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.schedule.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Event Details Modal -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Judul</dt>
                        <dd id="title"></dd>
                        <dt class="text-muted">Deskripsi</dt>
                        <dd id="description"></dd>
                        <dt class="text-muted">Mulai</dt>
                        <dd id="start"></dd>
                        <dt class="text-muted">Selesai</dt>
                        <dd id="end"></dd>
                    </dl>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-primary btn-edit" data-id=""><i class="bi bi-pencil"></i> Edit</button>
                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id=""><i class="bi bi-trash"></i> Hapus</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>
<script>
    // Daterangepicker
    Spandiv.DateRangePicker("input[name=time]");
</script>
<script>
    var schedules = $.parseJSON('<?= json_encode($schedules) ?>');
    var events = [];

    $(function() {
        if(!!schedules) {
            Object.keys(schedules).map(k => {
                var row = schedules[k];
                events.push({ id: row.id, title: row.title, color: row.color, start: row.started_at, end: row.ended_at });
            });
        }
        
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();

        // Init FullCalendar
        var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            businessHours: {
                daysOfWeek: [ 1, 2, 3, 4, 5, 6 ], // Monday - Saturday
            },
            selectable: true,
            themeSystem: 'bootstrap5',
            eventMinHeight: '100',
            events: events,
            locale: 'id',
            eventClick: function(info) {
                var details = $("#event-details-modal");
                var id = info.event.id;
                if(!!schedules[id]) {
                    details.find("#title").text(schedules[id].title);
                    details.find("#description").text(schedules[id].description);
                    details.find("#start").text(schedules[id].sdatetext + " WIB");
                    details.find("#end").text(schedules[id].edatetext + " WIB");
                    details.find(".btn-edit, .btn-delete").attr('data-id', id);
                    details.modal("show");
                }
                else {
                    Spandiv.SwalBasic("Tidak ada agenda!");
                }
            },
            eventDidMount: function(info) {
                // Do Something after events mounted
            },
            editable: true
        });

        calendar.render();

        // Form reset listener
        $("#form-schedule").on("reset", function() {
            $("#form-schedule").parents(".card").find(".card-header h5").text("Tambah Agenda");
            $(this).find("input[name=id]").val("");
            $(this).find("input:visible").first().focus();
        });

        // Button Edit
        $(document).on("click", ".btn-edit", function() {
            var id = $(this).attr('data-id');
            $("#form-schedule").parents(".card").find(".card-header h5").text("Edit Agenda");
            if(!!schedules[id]) {
                var form = $("#form-schedule");
                form.find("[name=id]").val(id);
                form.find("[name=title]").val(schedules[id].title);
                form.find("[name=description]").val(schedules[id].description);
                form.find("[name=color]").val(schedules[id].color);
                form.find("[name=time]").val(schedules[id].daterange);
                form.find("[name=time]").data("daterangepicker").setStartDate(schedules[id].sdaterangepicker);
                form.find("[name=time]").data("daterangepicker").setEndDate(schedules[id].edaterangepicker);
                $("#event-details-modal").modal("hide");
                form.find("[name=title]").focus();
            }
            else {
                Spandiv.SwalBasic("Tidak ada agenda!");
            }
        });
        
        // Button Delete
        Spandiv.ButtonDelete(".btn-delete", ".form-delete");
    });
</script>

@endsection

@section('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

@endsection