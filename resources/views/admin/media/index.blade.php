@extends('faturhelper::layouts/admin/main')

@section('title', 'Media')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Media</h1>
</div>

<div class="row">
    <div class="col-md-4 col-xl-3 mb-3 mb-md-0">
        <div class="list-group">
            @foreach($directories as $directory)
            <a href="{{ route('admin.media.index', ['dir' => $directory['path']]) }}" class="list-group-item list-group-item-action py-2 px-3 {{ Request::query('dir') == $directory['path'] ? 'active' : '' }}">{{ $directory['name'] }}</a>
            @endforeach
        </div>
    </div>
	<div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                @if(Request::query('dir') != null)
                    <p><i class="bi bi-folder me-1"></i> {{ asset(Request::query('dir')) }}</p>
                    @if(count($files)>0)
                        <div class="row">
                            @foreach($files as $file)
                                <div class="col-auto text-center">
                                    <a class="btn-mpopup" href="{{ asset(Request::query('dir').'/'.$file) }}" title="{{ $file }}">
                                        <img src="{{ asset(Request::query('dir').'/'.$file) }}" class="border p-1 mb-2" height="100">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-message alert-danger text-center mb-0">Tidak ada file.</div>
                    @endif
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 150px">
                        <div class="text-center">
                            <div><i class="bi bi-folder-x" style="font-size: 3rem;"></i></div>
                            <p class="h4 mb-0">Silahkan pilih item di sebelah kiri.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    // Magnific Popup
    Spandiv.MagnificPopup(".btn-mpopup");
</script>

@endsection