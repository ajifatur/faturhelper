<?php

namespace Ajifatur\FaturHelper\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Ajifatur\FaturHelper\FaturHelperServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faturhelper:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install FaturHelper package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        // Installing info
        $this->info('Installing FaturHelper package.');

        // Publish
        $this->call('vendor:publish', ['--provider' => FaturHelperServiceProvider::class, '--tag' => 'config']);
        $this->call('vendor:publish', ['--provider' => FaturHelperServiceProvider::class, '--tag' => 'assets']);
        $this->call('vendor:publish', ['--provider' => FaturHelperServiceProvider::class, '--tag' => 'templates']);
        $this->call('vendor:publish', ['--provider' => FaturHelperServiceProvider::class, '--tag' => 'lang']);

        // Update app/models/User.php
        $this->info('Updating app/models/User.php.');
        if(File::exists(app_path('models/User.php'))) {
            $contents = File::get(app_path('models/User.php'));
            if(is_int(strpos($contents, "extends Authenticatable")) == true && is_int(strpos($contents, "extends \Ajifatur\FaturHelper\Models\User")) == false) {
                $contents = str_replace("extends Authenticatable", "extends \Ajifatur\FaturHelper\Models\User", $contents);
                File::put(app_path('models/User.php'), $contents);
            }
        }

        // Update routes/web.php
        $this->info('Updating routes/web.php.');
        $contents = File::get(base_path('routes/web.php'));
        if(is_int(strpos($contents, "\Ajifatur\Helpers\RouteExt::auth();")) == false) {
            $contents = $contents . "\n" . "\Ajifatur\Helpers\RouteExt::auth();";
            File::put(base_path('routes/web.php'), $contents);
        }
        $contents = File::get(base_path('routes/web.php'));
        if(is_int(strpos($contents, "\Ajifatur\Helpers\RouteExt::admin();")) == false) {
            $contents = $contents . "\n" . "\Ajifatur\Helpers\RouteExt::admin();";
            File::put(base_path('routes/web.php'), $contents);
        }

        // Update routes/api.php
        $this->info('Updating routes/api.php.');
        $contents = File::get(base_path('routes/api.php'));
        if(is_int(strpos($contents, "\Ajifatur\Helpers\RouteExt::api();")) == false) {
            $contents = $contents . "\n" . "\Ajifatur\Helpers\RouteExt::api();";
            File::put(base_path('routes/api.php'), $contents);
        }

        // Composer dump autoload
        $composer = new Composer($filesystem);
        $composer->dumpAutoloads();

        // Migrate
        $this->call('migrate');

        // Seed
        $this->call('db:seed', ['--class' => \Ajifatur\FaturHelper\Seeders\DummySeeder::class]);
        $this->call('db:seed', ['--class' => \Ajifatur\FaturHelper\Seeders\DatabaseSeeder::class]);

        // Success info
        $this->info('Successfully installing FaturHelper! Enjoy!');
    }
}