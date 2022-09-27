<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ajifatur\FaturHelper\Models\Visitor;

class VisitorController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        if($request->ajax()) {
            // Get visitors
            $visitors = Visitor::has('user')->orderBy('created_at','desc')->get();
    
            // Loop visitors
            foreach($visitors as $visitor) {
                $visitor->device = json_decode($visitor->device, true);
                $visitor->browser = json_decode($visitor->browser, true);
                $visitor->platform = json_decode($visitor->platform, true);
                $visitor->location = json_decode($visitor->location, true);
            }

            // Return datatables
            return datatables()->of($visitors)
                ->addColumn('user', '
                    @php $user = \Ajifatur\FaturHelper\Models\User::find($user_id); @endphp
                    @if($user)
                        <a href="{{ \Route::has(\'admin.user.detail\') ? route(\'admin.user.detail\', [\'id\' => $user->id]) : \'#\' }}" target="_blank">{{ $user->name }}</a>
                        <br>
                        <small>{{ $user->role ? $user->role->name : "" }}</small>
                    @endif
                ')
                ->addColumn('datetime', '
                    <span class="d-none">{{ $created_at }}</span>
                    {{ date("d/m/Y", strtotime($created_at)) }}
                    <br>
                    <small>{{ date("H:i:s", strtotime($created_at)) }}</small>
                ')
                ->editColumn('device', '
                    @if(is_array($device))
                        <strong>Type:</strong> {{ $device[\'type\'] }}
                        <hr class="my-1">
                        <strong>Family:</strong> {{ $device[\'family\'] }}
                        <hr class="my-1">
                        <strong>Model:</strong> {{ $device[\'model\'] }}
                        <hr class="my-1">
                        <strong>Grade:</strong> {{ $device[\'grade\'] }}
                    @endif
                ')
                ->editColumn('browser', '
                    @if(is_array($browser))
                        <strong>Name:</strong> {{ $browser[\'name\'] }}
                        <hr class="my-1">
                        <strong>Family:</strong> {{ $browser[\'family\'] }}
                        <hr class="my-1">
                        <strong>Version:</strong> {{ $browser[\'version\'] }}
                        <hr class="my-1">
                        <strong>Engine:</strong> {{ $browser[\'engine\'] }}
                    @endif
                ')
                ->editColumn('platform', '
                    @if(is_array($platform))
                        <strong>Name:</strong> {{ $platform[\'name\'] }}
                        <hr class="my-1">
                        <strong>Family:</strong> {{ $platform[\'family\'] }}
                        <hr class="my-1">
                        <strong>Version:</strong> {{ $platform[\'version\'] }}
                    @endif
                ')
                ->editColumn('location', '
                    @if(is_array($location))
                        <strong>IP:</strong> {{ $location[\'ip\'] }}
                        <hr class="my-1">
                        <strong>Kota:</strong> {{ $location[\'cityName\'] }}
                        <hr class="my-1">
                        <strong>Regional:</strong> {{ $location[\'regionName\'] }}
                        <hr class="my-1">
                        <strong>Negara:</strong> {{ $location[\'countryName\'] }}
                    @endif
                ')
                ->rawColumns(['user', 'datetime', 'device', 'browser', 'platform', 'location'])
                ->make(true);
        }

        // View
        return view('faturhelper::admin/visitor/index');
    }
}
