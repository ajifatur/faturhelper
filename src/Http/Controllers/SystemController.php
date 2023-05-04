<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SystemController extends \App\Http\Controllers\Controller
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

        // Get packages
        $packages = package();

        // View
        return view('faturhelper::admin/system/index', [
            'packages' => $packages
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

    /**
     * Display the package
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function package(Request $request)
    {
        // Check the access
        // has_access(__METHOD__, Auth::user()->role_id);

        // Get the package
        $package = package($request->query('repo'));
        
        // Get releases
        $releases = fetch("https://api.github.com/repos/" . $package['path'] . "/releases?per_page=100");

        // View
        return view('faturhelper::admin/system/package', [
            'package' => $package,
            'releases' => $releases
        ]);
    }
}
