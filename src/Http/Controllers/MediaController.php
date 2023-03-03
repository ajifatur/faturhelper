<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ajifatur\Helpers\FileExt;

class MediaController extends \App\Http\Controllers\Controller
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
        // has_access(__METHOD__, Auth::user()->role_id);

        // Get directories
        $directories = [
            ['name' => 'Icon', 'path' => 'assets/images/icons'],
            ['name' => 'Logo', 'path' => 'assets/images/logos'],
        ];

        // Get the files
        $files = FileExt::get(public_path($request->query('dir')));
        $array = [];
        foreach ($files as $file) {
            $file_info = FileExt::info($file->getRelativePathname());
            array_push($array, $file_info['name']);
        }

        // View
        return view('faturhelper::admin/media/index', [
            'directories' => $directories,
            'files' => $array
        ]);
    }

    /**
     * Update the system / package.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Run process
        $process = new Process(["/opt/plesk/php/7.4/bin/php", "/usr/lib64/plesk-9.0/composer.phar", "update", "ajifatur/faturhelper"], base_path());
        $process->setTimeout(null);
        $process->run();
      
        // Executes after the command finishes
        if(!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        // Display output
        dd($process->getOutput());
    }
}
