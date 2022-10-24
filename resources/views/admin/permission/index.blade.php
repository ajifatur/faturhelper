@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Hak Akses')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Hak Akses</h1>
    <div class="btn-group">
        <a href="{{ route('admin.permission.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Hak Akses</a>
        <a href="{{ route('admin.permission.reorder') }}" class="btn btn-sm btn-success"><i class="bi-shuffle me-1"></i> Urutkan Hak Akses</a>
        @if(Request::query('default') == 1)
            <a href="{{ route('admin.permission.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
        @else
            <a href="{{ route('admin.permission.index', ['default' => 1]) }}" class="btn btn-sm btn-secondary"><i class="bi-lock me-1"></i> Default</a>
        @endif
    </div>
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
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="30"><input type="checkbox" class="form-check-input checkbox-all"></th>
                                <th>Akses</th>
                                @foreach($roles as $role)
                                <th width="50" class="small">
                                    {{ $role->name }}
                                    <br>
                                    <span class="fw-normal fst-italic text-muted">({{ $role->code }})</span>
                                </th>
                                @endforeach
                                <th width="50">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($permissions) > 0)
                                @foreach($permissions as $permission)
                                <tr data-id="{{ $permission->id }}">
                                    <td align="center"><input type="checkbox" class="form-check-input checkbox-one"></td>
                                    <td>
                                        {{ $permission->name }}
                                        <br>
                                        <span class="small text-muted">{{ $permission->code }}</span>
                                    </td>
                                    @foreach($roles as $role)
                                    <td align="center">
                                        <span class="d-none">{{ $permission->num_order }}</span>
                                        <input class="form-check-input checkbox-role-permission" type="checkbox" data-role="{{ $role->id }}" data-permission="{{ $permission->id }}" {{ in_array($role->id, $permission->roles()->pluck('role_id')->toArray()) ? 'checked' : '' }}>
                                    </td>
                                    @endforeach
                                    <td align="center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.permission.edit', ['id' => $permission->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $permission->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.permission.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 d-none">
    <div class="toast align-items-center text-white bg-success border-0" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    Spandiv.DataTable("#datatable", {
        pageLength: -1,
        fixedHeader: true
    });

    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");

    // Change Status
    $(document).on("click", "#datatable .form-check-input.checkbox-role-permission", function(e) {
        e.preventDefault();
        if(typeof Pace !== "undefined") Pace.restart();
        var permission = $(this).data("permission");
        var role = $(this).data("role");
        $.ajax({
            type: "post",
            url: "{{ route('admin.permission.change') }}",
            data: {_token: "{{ csrf_token() }}", permission: permission, role: role},
            success: function(response) {
                if(response == "Berhasil mengganti status hak akses.") {
                    $("#toast").hasClass("bg-danger") ? $("#toast").removeClass("bg-danger") : '';
                    !$("#toast").hasClass("bg-success") ? $("#toast").addClass("bg-success") : '';
                    e.target.checked = !e.target.checked;
                }
                else {
                    $("#toast").hasClass("bg-success") ? $("#toast").removeClass("bg-success") : '';
                    !$("#toast").hasClass("bg-danger") ? $("#toast").addClass("bg-danger") : '';
                }
                Spandiv.Toast("#toast", response);
            }
        });
    });
</script>

@endsection

@section('css')

<style type="text/css">
    .table tr td:not(:first-child) .form-check-input {height: 1.25rem; width: 1.25rem;}
</style>

@endsection