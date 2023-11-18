@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Menu')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Menu</h1>
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

                <a href="{{ route('admin.menu.header.create') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi-plus me-1"></i>Tambah Header</a>
                <br>

                @if(count($menu_headers) > 0)
                <!-- Menu Header -->
                <p class="fst-italic small text-muted"><i class="bi-info-circle me-1"></i> Tekan dan geser menu di bawah ini untuk mengurutkannya.</p>
                <div class="sortable" data-url="{{ route('admin.menu.header.sort') }}">
                    @csrf
                    @foreach($menu_headers as $menu_header)
                    <div class="card border mb-2 {{ $menu_header->name == '' ? 'ui-state-disabled' : '' }}" data-id="{{ $menu_header->id }}">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center p-2">
                            <h6 class="mb-0">
                                <a href="#" class="{{ $menu_header->name == '' ? 'text-dark' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse-menu-header-{{ $menu_header->id }}">
                                    {{ $menu_header->name != '' ? $menu_header->name : '<Tanpa Header>' }}
                                </a>
                            </h6>
                            <div class="btn-group">
                                <a href="{{ route('admin.menu.item.create', ['header_id' => $menu_header->id]) }}" class="btn btn-sm btn-outline-secondary btn-add-menu-item" data-bs-toggle="tooltip" title="Tambah Item"><i class="bi-plus"></i></a>
                                <a href="{{ route('admin.menu.header.edit', ['id' => $menu_header->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Header"><i class="bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-header" data-id="{{ $menu_header->id }}" data-bs-toggle="tooltip" title="Hapus Header"><i class="bi-trash"></i></a>
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="card-body p-2 collapse show" id="collapse-menu-header-{{ $menu_header->id }}">

                            <!-- Menu Item -->
                            @if(count($menu_header->items) > 0)
                                <div class="sortable" data-url="{{ route('admin.menu.item.sort') }}">
                                @foreach($menu_header->items()->where('parent','=',0)->orderBy('num_order','asc')->get() as $menu_item)
                                    @php
                                        $submenu_items = $menu_header->items()->where('parent','=',$menu_item->id)->orderBy('num_order','asc')->get();
                                    @endphp
                                    <div class="card border mb-2" data-id="{{ $menu_item->id }}">
                                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center p-2">
                                            <div>
                                                <i class="{{ $menu_item->icon }} me-1" data-bs-toggle="tooltip" title="{{ $menu_item->name }}"></i>
                                                <a href="{{ $menu_item->route != '' ? is_array(json_decode($menu_item->routeparams, true)) ? route($menu_item->route, json_decode($menu_item->routeparams, true)) : route($menu_item->route) : '#' }}">{{ $menu_item->name }}</a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $menu_item->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $menu_item->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                            </div>
                                        </div>
                                        @if(count($submenu_items) > 0)
                                            <div class="card-body p-2">
                                                <div class="list-group sortable" data-url="{{ route('admin.menu.item.sort') }}">
                                                    @foreach($submenu_items as $submenu_item)
                                                        @php
                                                            $submenu_items_level_2 = $menu_header->items()->where('parent','=',$submenu_item->id)->orderBy('num_order','asc')->get();
                                                        @endphp
                                                        <div class="list-group-item p-2" data-id="{{ $submenu_item->id }}">
                                                            <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                                                <div>
                                                                    <i class="{{ $submenu_item->icon }} me-1" data-bs-toggle="tooltip" title="{{ $submenu_item->name }}"></i>
                                                                    <a href="{{ $submenu_item->route != '' ? is_array(json_decode($submenu_item->routeparams, true)) ? route($submenu_item->route, json_decode($submenu_item->routeparams, true)) : route($submenu_item->route) : '#' }}">{{ $submenu_item->name }}</a>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $submenu_item->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                                                    <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $submenu_item->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                                                </div>
                                                            </div>
                                                            @if(count($submenu_items_level_2) > 0)
                                                                <div class="list-group sortable" data-url="{{ route('admin.menu.item.sort') }}">
                                                                    @foreach($submenu_items_level_2 as $submenu_item_level_2)
                                                                        <div class="list-group-item d-flex justify-content-between align-items-center p-2" data-id="{{ $submenu_item_level_2->id }}">
                                                                            <div>
                                                                                <i class="{{ $submenu_item_level_2->icon }} me-1" data-bs-toggle="tooltip" title="{{ $submenu_item_level_2->name }}"></i>
                                                                                <a href="{{ $submenu_item_level_2->route != '' ? is_array(json_decode($submenu_item_level_2->routeparams, true)) ? route($submenu_item_level_2->route, json_decode($submenu_item_level_2->routeparams, true)) : route($submenu_item_level_2->route) : '#' }}">{{ $submenu_item_level_2->name }}</a>
                                                                            </div>
                                                                            <div class="btn-group">
                                                                                <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $submenu_item_level_2->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                                                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $submenu_item_level_2->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                </div>
                            @else
                                <em class="text-danger">Belum ada item.</em>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <em class="text-danger">Belum ada menu.</em>
                @endif

            </div>
        </div>
    </div>
</div>

<form class="form-delete-menu-header d-none" method="post" action="{{ route('admin.menu.header.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<form class="form-delete-menu-item d-none" method="post" action="{{ route('admin.menu.item.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 d-none">
    <div class="toast align-items-center text-white bg-success border-0" id="toast-sort" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // Button Delete Menu Header
    Spandiv.ButtonDelete(".btn-delete-menu-header", ".form-delete-menu-header");

    // Button Delete Menu Item
    Spandiv.ButtonDelete(".btn-delete-menu-item", ".form-delete-menu-item");

    // Sortable Menu Header and Menu Item
    Spandiv.Sortable(".sortable");
</script>

@endsection