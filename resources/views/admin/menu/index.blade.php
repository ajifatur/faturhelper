@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Menu')

@section('content')

@php
    $visibleRoleBadges = function ($conditions) use ($roles) {
        if (trim((string) $conditions) === '') {
            return $roles;
        }

        preg_match_all("/role\\('([^']+)'\\)/", (string) $conditions, $matches);
        $roleCodes = array_unique($matches[1] ?? []);

        return $roles->filter(function ($role) use ($roleCodes) {
            return in_array($role->code, $roleCodes, true);
        });
    };
@endphp

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

                <div class="menu-toolbar">
                    <a href="{{ route('admin.menu.header.create') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi-plus me-1"></i>Tambah Header
                    </a>
                </div>

                @if(count($menu_headers) > 0)
                <p class="fst-italic small text-muted mt-3">
                    <i class="bi-info-circle me-1"></i> Tekan dan geser menu untuk mengatur urutannya.
                </p>
                <div class="sortable" data-url="{{ route('admin.menu.header.sort') }}">
                    @csrf
                    @foreach($menu_headers as $menu_header)
                    @php
                        $menu_items = $menu_header->items;
                        $root_items = $menu_items->where('parent', 0);
                        $header_collapse_id = 'collapse-menu-header-'.$menu_header->id;
                    @endphp
                    <div class="card border mb-2 menu-sortable-card menu-header-card {{ $menu_header->name == '' ? 'ui-state-disabled' : '' }}" data-id="{{ $menu_header->id }}">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center p-2">
                            <div class="text-start {{ $menu_header->name == '' ? 'text-dark' : '' }}">
                                <i class="bi-grip-vertical text-muted me-1"></i>
                                <strong>{{ $menu_header->name != '' ? $menu_header->name : '<Tanpa Header>' }}</strong>
                                <span class="badge rounded-pill bg-light text-secondary border ms-1">{{ $root_items->count() }}</span>
                            </div>
                            <div class="btn-group">
                                @if($root_items->count() > 0)
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-toggle-menu-item" data-bs-toggle="collapse" data-bs-target="#{{ $header_collapse_id }}" aria-controls="{{ $header_collapse_id }}" aria-expanded="true" title="Tampilkan/sembunyikan item">
                                    <i class="bi-chevron-down"></i>
                                </button>
                                @endif
                                <a href="{{ route('admin.menu.item.create', ['header_id' => $menu_header->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Tambah Item"><i class="bi-plus"></i></a>
                                <a href="{{ route('admin.menu.header.edit', ['id' => $menu_header->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Header"><i class="bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-header" data-id="{{ $menu_header->id }}" data-bs-toggle="tooltip" title="Hapus Header"><i class="bi-trash"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-2 collapse show" id="{{ $header_collapse_id }}">
                            @if($root_items->count() > 0)
                            <div class="sortable" data-url="{{ route('admin.menu.item.sort') }}">
                                @foreach($root_items as $menu_item)
                                @php
                                    $children = $menu_items->where('parent', $menu_item->id);
                                    $item_collapse_id = 'collapse-menu-item-'.$menu_item->id;
                                @endphp
                                <div class="card border mb-2 menu-sortable-card" data-id="{{ $menu_item->id }}">
                                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center p-2">
                                        <a class="btn btn-link text-start text-decoration-none p-0 flex-grow-1" href="{{ $menu_item->route != '' ? (is_array(json_decode($menu_item->routeparams, true)) ? route($menu_item->route, json_decode($menu_item->routeparams, true)) : route($menu_item->route)) : '#' }}">
                                            <i class="bi-grip-vertical text-muted me-1"></i>
                                            <i class="{{ $menu_item->icon }} me-1"></i>
                                            <span>{{ $menu_item->name }}</span>
                                            @if($children->count() > 0)<span class="badge rounded-pill bg-light text-secondary border ms-1">{{ $children->count() }}</span>@endif
                                        </a>
                                        <div class="btn-group">
                                            <div class="menu-role-badges">
                                                @if(trim((string) $menu_item->visible_conditions) === '')
                                                <span class="badge rounded-pill bg-light text-secondary border">Semua role</span>
                                                @else
                                                @forelse($visibleRoleBadges($menu_item->visible_conditions) as $role)
                                                <span class="badge rounded-pill bg-light text-secondary border">{{ $role->name }}</span>
                                                @empty
                                                <span class="badge rounded-pill bg-light text-secondary border">Tidak diketahui</span>
                                                @endforelse
                                                @endif
                                            </div>
                                            @if($children->count() > 0)
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-toggle-menu-item" data-bs-toggle="collapse" data-bs-target="#{{ $item_collapse_id }}" aria-controls="{{ $item_collapse_id }}" aria-expanded="true" title="Tampilkan/sembunyikan child">
                                                <i class="bi-chevron-down"></i>
                                            </button>
                                            @endif
                                            <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $menu_item->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                            <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $menu_item->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                        </div>
                                    </div>
                                    @if($children->count() > 0)
                                    <div class="card-body p-2 collapse show" id="{{ $item_collapse_id }}">
                                        <div class="list-group sortable" data-url="{{ route('admin.menu.item.sort') }}">
                                            @foreach($children as $submenu_item)
                                            @php
                                                $grandchildren = $menu_items->where('parent', $submenu_item->id);
                                                $submenu_collapse_id = 'collapse-menu-subitem-'.$submenu_item->id;
                                            @endphp
                                            <div class="list-group-item p-2" data-id="{{ $submenu_item->id }}">
                                                <div class="d-flex w-100 justify-content-between align-items-center">
                                                    <a class="btn btn-link text-start text-decoration-none p-0 flex-grow-1" href="{{ $submenu_item->route != '' ? (is_array(json_decode($submenu_item->routeparams, true)) ? route($submenu_item->route, json_decode($submenu_item->routeparams, true)) : route($submenu_item->route)) : '#' }}">
                                                        <i class="bi-grip-vertical text-muted me-1"></i>
                                                        <i class="{{ $submenu_item->icon }} me-1"></i>
                                                        <span>{{ $submenu_item->name }}</span>
                                                        @if($grandchildren->count() > 0)<span class="badge rounded-pill bg-light text-secondary border ms-1">{{ $grandchildren->count() }}</span>@endif
                                                    </a>
                                                    <div class="btn-group">
                                                        <div class="menu-role-badges">
                                                            @if(trim((string) $submenu_item->visible_conditions) === '')
                                                            <span class="badge rounded-pill bg-light text-secondary border">Semua role</span>
                                                            @else
                                                            @forelse($visibleRoleBadges($submenu_item->visible_conditions) as $role)
                                                            <span class="badge rounded-pill bg-light text-secondary border">{{ $role->name }}</span>
                                                            @empty
                                                            <span class="badge rounded-pill bg-light text-secondary border">Tidak diketahui</span>
                                                            @endforelse
                                                            @endif
                                                        </div>
                                                        @if($grandchildren->count() > 0)
                                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-toggle-menu-item" data-bs-toggle="collapse" data-bs-target="#{{ $submenu_collapse_id }}" aria-controls="{{ $submenu_collapse_id }}" aria-expanded="true" title="Tampilkan/sembunyikan child">
                                                            <i class="bi-chevron-down"></i>
                                                        </button>
                                                        @endif
                                                        <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $submenu_item->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                                        <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $submenu_item->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                                    </div>
                                                </div>
                                                @if($grandchildren->count() > 0)
                                                <div class="list-group sortable mt-2 collapse show" data-url="{{ route('admin.menu.item.sort') }}" id="{{ $submenu_collapse_id }}">
                                                    @foreach($grandchildren as $submenu_item_level_2)
                                                    @php $level_3 = $menu_items->where('parent', $submenu_item_level_2->id); @endphp
                                                    <div class="list-group-item p-2" data-id="{{ $submenu_item_level_2->id }}">
                                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                                            <a class="text-decoration-none text-reset" href="{{ $submenu_item_level_2->route != '' ? (is_array(json_decode($submenu_item_level_2->routeparams, true)) ? route($submenu_item_level_2->route, json_decode($submenu_item_level_2->routeparams, true)) : route($submenu_item_level_2->route)) : '#' }}"><i class="bi-grip-vertical text-muted me-1"></i><i class="{{ $submenu_item_level_2->icon }} me-1"></i>{{ $submenu_item_level_2->name }}</a>
                                                            <div class="btn-group">
                                                                <div class="menu-role-badges">
                                                                    @if(trim((string) $submenu_item_level_2->visible_conditions) === '')
                                                                    <span class="badge rounded-pill bg-light text-secondary border">Semua role</span>
                                                                    @else
                                                                    @forelse($visibleRoleBadges($submenu_item_level_2->visible_conditions) as $role)
                                                                    <span class="badge rounded-pill bg-light text-secondary border">{{ $role->name }}</span>
                                                                    @empty
                                                                    <span class="badge rounded-pill bg-light text-secondary border">Tidak diketahui</span>
                                                                    @endforelse
                                                                    @endif
                                                                </div>
                                                                <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $submenu_item_level_2->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $submenu_item_level_2->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                                            </div>
                                                        </div>
                                                        @if($level_3->count() > 0)
                                                        <div class="list-group sortable mt-2" data-url="{{ route('admin.menu.item.sort') }}">
                                                            @foreach($level_3 as $submenu_item_level_3)
                                                            <div class="list-group-item d-flex w-100 justify-content-between align-items-center p-2" data-id="{{ $submenu_item_level_3->id }}">
                                                                <a class="text-decoration-none text-reset" href="{{ $submenu_item_level_3->route != '' ? (is_array(json_decode($submenu_item_level_3->routeparams, true)) ? route($submenu_item_level_3->route, json_decode($submenu_item_level_3->routeparams, true)) : route($submenu_item_level_3->route)) : '#' }}"><i class="bi-grip-vertical text-muted me-1"></i><i class="{{ $submenu_item_level_3->icon }} me-1"></i>{{ $submenu_item_level_3->name }}</a>
                                                                <div class="btn-group">
                                                                    <div class="menu-role-badges">
                                                                        @if(trim((string) $submenu_item_level_3->visible_conditions) === '')
                                                                        <span class="badge rounded-pill bg-light text-secondary border">Semua role</span>
                                                                        @else
                                                                        @forelse($visibleRoleBadges($submenu_item_level_3->visible_conditions) as $role)
                                                                        <span class="badge rounded-pill bg-light text-secondary border">{{ $role->name }}</span>
                                                                        @empty
                                                                        <span class="badge rounded-pill bg-light text-secondary border">Tidak diketahui</span>
                                                                        @endforelse
                                                                        @endif
                                                                    </div>
                                                                    <a href="{{ route('admin.menu.item.edit', ['header_id' => $menu_header->id, 'item_id' => $submenu_item_level_3->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Item"><i class="bi-pencil"></i></a>
                                                                    <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-menu-item" data-id="{{ $submenu_item_level_3->id }}" data-bs-toggle="tooltip" title="Hapus Item"><i class="bi-trash"></i></a>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @endif
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
    Spandiv.ButtonDelete(".btn-delete-menu-header", ".form-delete-menu-header");
    Spandiv.ButtonDelete(".btn-delete-menu-item", ".form-delete-menu-item");
    Spandiv.Sortable(".sortable");
</script>
@endsection

@section('css')
<style>
    .menu-toolbar {
        position: sticky;
        top: 1rem;
        z-index: 10;
        display: flex;
        justify-content: flex-end;
        pointer-events: none;
    }

    .menu-toolbar .btn {
        pointer-events: auto;
        box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .15);
    }

    .menu-header-card > .card-header {
        position: sticky;
        top: 1rem;
        z-index: 9;
        background-color: var(--bs-body-bg) !important;
        box-shadow: 0 .125rem .35rem rgba(0, 0, 0, .08);
    }

    .menu-sortable-card > .card-header,
    .list-group-item {
        transition: background-color .15s ease, box-shadow .15s ease;
    }

    .menu-sortable-card > .card-header:hover,
    .list-group-item:hover {
        background-color: var(--bs-light);
    }

    .menu-sortable-card .btn-link,
    .list-group-item .btn-link {
        color: inherit;
    }

    .menu-role-badges {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .5rem;
        margin-right: .5rem;
    }

    .btn-toggle-menu-item i {
        display: inline-block;
        transition: transform .15s ease;
    }

    .btn-toggle-menu-item[aria-expanded="false"] i {
        transform: rotate(-90deg);
    }
</style>
@endsection
