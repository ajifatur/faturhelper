
<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="/" target="_blank">
			@if(setting('logo') != '' && File::exists(public_path('assets/images/logos/'.setting('logo'))))
				<img src="{{ asset('assets/images/logos/'.setting('logo')) }}" height="40" alt="{{ config('app.name') }}" style="max-width: 100%;">
			@else
				<span class="align-middle">{{ config('app.name') }}</span>
			@endif
		</a>
		<ul class="sidebar-nav">
			@foreach(menu() as $key=>$menu)
				@if($menu['header'] != '' && count($menu['items']) > 0)
					<li class="sidebar-header">{{ $menu['header'] }}</li>
				@endif
				@if(count($menu['items']) > 0)
					@foreach($menu['items'] as $key2=>$item)
						@if(count($item['children']) > 0)
							<li class="sidebar-item {{ eval_sidebar($item['active_conditions'], 'active') }}">
								<a data-bs-target="#sidebar-subitem-{{ $key }}-{{ $key2 }}" data-bs-toggle="collapse" class="sidebar-link {{ eval_sidebar($item['active_conditions'], '', 'collapsed') }}">
									<i class="align-middle {{ $item['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $item['name'] }}</span>
								</a>
								<ul id="sidebar-subitem-{{ $key }}-{{ $key2 }}" class="sidebar-dropdown list-unstyled collapse {{ eval_sidebar($item['active_conditions'], 'show') }}" data-bs-parent="#sidebar">
									@foreach($item['children'] as $key3=>$subitem)
										@if(count($subitem['children']) > 0)
											<li class="sidebar-item {{ eval_sidebar($subitem['active_conditions'], 'active') }}">
												<a data-bs-target="#sidebar-subitem-2-{{ $key2 }}-{{ $key3 }}" data-bs-toggle="collapse" class="sidebar-link {{ eval_sidebar($subitem['active_conditions'], '', 'collapsed') }}">
													<i class="align-middle {{ $subitem['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $subitem['name'] }}</span>
												</a>
												<ul id="sidebar-subitem-2-{{ $key2 }}-{{ $key3 }}" class="sidebar-dropdown list-unstyled collapse {{ eval_sidebar($subitem['active_conditions'], 'show') }}">
													@foreach($subitem['children'] as $key4=>$subitem_level_2)
														@if(count($subitem_level_2['children']) > 0)
															<li class="sidebar-item {{ eval_sidebar($subitem_level_2['active_conditions'], 'active') }}">
																<a data-bs-target="#sidebar-subitem-3-{{ $key3 }}-{{ $key4 }}" data-bs-toggle="collapse" class="sidebar-link {{ eval_sidebar($subitem_level_2['active_conditions'], '', 'collapsed') }}">
																	<i class="align-middle {{ $subitem_level_2['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $subitem_level_2['name'] }}</span>
																</a>
																<ul id="sidebar-subitem-3-{{ $key3 }}-{{ $key4 }}" class="sidebar-dropdown list-unstyled collapse {{ eval_sidebar($subitem_level_2['active_conditions'], 'show') }}">
																@foreach($subitem_level_2['children'] as $subitem_level_3)
																	<li class="sidebar-item {{ eval_sidebar($subitem_level_3['active_conditions'], 'active') }}">
																		<a class="sidebar-link" href="{{ $subitem_level_3['route'] }}">
																			<i class="align-middle {{ $subitem_level_3['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $subitem_level_3['name'] }}</span>
																		</a>
																	</li>
																@endforeach
																</ul>
															</li>
														@else
															<li class="sidebar-item {{ eval_sidebar($subitem_level_2['active_conditions'], 'active') }}">
																<a class="sidebar-link" href="{{ $subitem_level_2['route'] }}">
																	<i class="align-middle {{ $subitem_level_2['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $subitem_level_2['name'] }}</span>
																</a>
															</li>
														@endif
													@endforeach
												</ul>
											</li>
										@else
											<li class="sidebar-item {{ eval_sidebar($subitem['active_conditions'], 'active') }}">
												<a class="sidebar-link" href="{{ $subitem['route'] }}">
													<i class="align-middle {{ $subitem['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $subitem['name'] }}</span>
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
						@else
							<li class="sidebar-item {{ eval_sidebar($item['active_conditions'], 'active') }}">
								<a class="sidebar-link" href="{{ $item['route'] }}">
									<i class="align-middle {{ $item['icon'] }}" style="font-size: 1rem;"></i> <span class="align-middle">{{ $item['name'] }}</span>
								</a>
							</li>
						@endif
					@endforeach
				@endif
			@endforeach
		</ul>
	</div>
</nav>
