@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Pengguna')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Pengguna</h1>
    <div class="btn-group">
        <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Pengguna</a>
    </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-header d-sm-flex justify-content-end align-items-center">
                <div></div>
                <div class="ms-sm-2 ms-0">
                    <select name="role" class="form-select form-select-sm">
                        <option value="0">Semua Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ Request::query('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="my-0">
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
                                <th width="30" class="notexport"><input type="checkbox" class="form-check-input checkbox-all"></th>
                                <th>Nama</th>
                                <th width="100">Username</th>
                                <th width="100">Role</th>
                                <th width="80">Status</th>
                                <th width="60" class="notexport">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td align="center"><input type="checkbox" class="form-check-input checkbox-one" data-id="{{ $user->id }}"></td>
                                <td>
                                    {{ $user->name }}
                                    <div class="small text-muted">{{ $user->email }}</div>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @if(setting('multiple_roles') == 1)
                                        @if(count($user->roles) <= 0)
                                            {{ $user->role->name }}
                                        @else
                                            @foreach($user->roles as $key=>$role)
                                                {{ $role->name }}
                                                @if($key < count($user->roles)-1)
                                                <hr class="my-0">
                                                @endif
                                            @endforeach
                                        @endif
                                    @else
                                        {{ $user->role->name }}
                                    @endif
                                </td>
                                <td><span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ status($user->status) }}</span></td>
                                <td align="center">
                                    <div class="btn-group">
                                        @if(((session()->exists('user') && session('user') != $user->id) || session()->exists('user') == false) && Auth::user()->id != $user->id)
                                        <a href="#" class="btn btn-sm btn-info btn-camouflage" data-id="{{ $user->id }}" data-bs-toggle="tooltip" title="Kamuflase"><i class="bi-person-x"></i></a>
                                        @endif
                                        <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<form class="form-camouflage d-none" method="post" action="{{ route('admin.camouflage.login') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<form class="form-delete d-none" method="post" action="{{ route('admin.user.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<form class="form-delete-bulk d-none" method="post" action="{{ route('admin.user.delete-bulk') }}">
    @csrf
    <input type="hidden" name="ids">
</form>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    Spandiv.DataTable("#datatable", {
        buttons: true,
        deleteBulk: true
    });

    // Button Camouflage
    $(document).on("click", ".btn-camouflage", function(e) {
        e.preventDefault();
        $(".form-camouflage").find("input[name=id]").val($(this).data("id"));
        $(".form-camouflage").submit();
    });

    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");

    // Button Delete Bulk
    Spandiv.ButtonDeleteBulk(".btn-delete-bulk", ".form-delete-bulk");
    
    // Change the role
    $(document).on("change", ".card-header select[name=role]", function() {
		var role = $(this).val();
		if(role === "0") window.location.href = Spandiv.URL("{{ route('admin.user.index') }}");
		else window.location.href = Spandiv.URL("{{ route('admin.user.index') }}", {role: role});
    });
</script>

@endsection