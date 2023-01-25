<?php

/**
 * @var string NAMESPACE
 * 
 * @method static void auth()
 * @method static void admin()
 * @method static void login()
 * @method static void logout()
 * @method static void dashboard()
 * @method static void user()
 * @method static void menu()
 * @method static void roles()
 * @method static void permissions()
 * @method static void settings()
 * @method static void metas()
 * @method static void periods()
 * @method static void schedules()
 * @method static void systems()
 * @method static void database()
 * @method static void dataset()
 * @method static void artisan()
 * @method static void logs()
 * @method static void route()
 * @method static void visitors()
 * @method static void api()
 * @method static void apiAuth()
 */

namespace Ajifatur\Helpers;

use Illuminate\Support\Facades\Route;

class RouteExt
{
    /**
     * The default namespace.
     *
     * @var string
     */
    const NAMESPACE = '\Ajifatur\FaturHelper\Http\Controllers';

    /**
     * Group the auth routes.
     *
     * @return void
     */
    public static function auth()
    {
        self::login();
        self::logout();
    }

    /**
     * Group the admin routes.
     *
     * @return void
     */
    public static function admin()
    {
        self::dashboard();
        self::user();
        self::menu();
        self::roles();
        self::permissions();
        self::settings();
        self::metas();
        self::periods();
        self::systems();
        self::schedules();
        self::database();
        self::dataset();
        self::artisan();
        self::logs();
        self::route();
        self::visitors();
    }

    /**
     * Set the login routes.
     *
     * @return void
     */
    public static function login()
    {
        Route::group(['middleware' => ['faturhelper.guest']], function() {
            // Login
            Route::get('/login', self::NAMESPACE.'\Auth\LoginController@show')->name('auth.login');
            Route::post('/login', self::NAMESPACE.'\Auth\LoginController@authenticate');

            // Login via (Socialite)
            if(config('faturhelper.auth.socialite') === true) {
                Route::get('/auth/{provider}', self::NAMESPACE.'\Auth\LoginController@redirectToProvider')->name('auth.login.provider');
                Route::get('/auth/{provider}/callback', self::NAMESPACE.'\Auth\LoginController@handleProviderCallback')->name('auth.login.provider.callback');
            }
        });
    }

    /**
     * Set the logout routes.
     *
     * @return void
     */
    public static function logout()
    {
        Route::group(['middleware' => ['faturhelper.nonadmin']], function() {
            Route::post('/logout', self::NAMESPACE.'\Auth\LoginController@logout')->name('auth.logout');
        });

        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::post('/admin/logout', self::NAMESPACE.'\Auth\LoginController@logout')->name('admin.logout');
        });
    }

    /**
     * Set the dashboard routes.
     *
     * @return void
     */
    public static function dashboard()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin', self::NAMESPACE.'\DashboardController@index')->name('admin.dashboard');
            Route::get('/admin/summary', self::NAMESPACE.'\DashboardController@summary')->name('admin.summary');
        });
    }

    /**
     * Set the user, user profile and settings routes.
     *
     * @return void
     */
    public static function user()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            // User
            Route::get('/admin/user', self::NAMESPACE.'\UserController@index')->name('admin.user.index');
            Route::get('/admin/user/create', self::NAMESPACE.'\UserController@create')->name('admin.user.create');
            Route::post('/admin/user/store', self::NAMESPACE.'\UserController@store')->name('admin.user.store');
            Route::get('/admin/user/edit/{id}', self::NAMESPACE.'\UserController@edit')->name('admin.user.edit');
            Route::post('/admin/user/update', self::NAMESPACE.'\UserController@update')->name('admin.user.update');
            Route::post('/admin/user/delete', self::NAMESPACE.'\UserController@delete')->name('admin.user.delete');
            Route::post('/admin/user/delete-bulk', self::NAMESPACE.'\UserController@deleteBulk')->name('admin.user.delete-bulk');

            // User profile and settings
            Route::get('/admin/profile', self::NAMESPACE.'\UserSettingController@index')->name('admin.profile');
            Route::get('/admin/settings/profile', self::NAMESPACE.'\UserSettingController@profile')->name('admin.settings.profile');
            Route::post('/admin/settings/profile/update', self::NAMESPACE.'\UserSettingController@updateProfile')->name('admin.settings.profile.update');
            Route::get('/admin/settings/account', self::NAMESPACE.'\UserSettingController@account')->name('admin.settings.account');
            Route::post('/admin/settings/account/update', self::NAMESPACE.'\UserSettingController@updateAccount')->name('admin.settings.account.update');
            Route::get('/admin/settings/password', self::NAMESPACE.'\UserSettingController@password')->name('admin.settings.password');
            Route::post('/admin/settings/password/update', self::NAMESPACE.'\UserSettingController@updatePassword')->name('admin.settings.password.update');
            Route::get('/admin/settings/avatar', self::NAMESPACE.'\UserSettingController@avatar')->name('admin.settings.avatar');
            Route::post('/admin/settings/avatar/update', self::NAMESPACE.'\UserSettingController@updateAvatar')->name('admin.settings.avatar.update');
        });
    }

    /**
     * Set the menu routes.
     *
     * @return void
     */
    public static function menu()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            // Menu
            Route::get('/admin/menu', self::NAMESPACE.'\MenuController@index')->name('admin.menu.index');

            // Menu Header
            Route::get('/admin/menu/header/create', self::NAMESPACE.'\MenuHeaderController@create')->name('admin.menu.header.create');
            Route::post('/admin/menu/header/store', self::NAMESPACE.'\MenuHeaderController@store')->name('admin.menu.header.store');
            Route::get('/admin/menu/header/edit/{id}', self::NAMESPACE.'\MenuHeaderController@edit')->name('admin.menu.header.edit');
            Route::post('/admin/menu/header/update', self::NAMESPACE.'\MenuHeaderController@update')->name('admin.menu.header.update');
            Route::post('/admin/menu/header/delete', self::NAMESPACE.'\MenuHeaderController@delete')->name('admin.menu.header.delete');
            Route::post('/admin/menu/header/sort', self::NAMESPACE.'\MenuHeaderController@sort')->name('admin.menu.header.sort');

            // Menu Item
            Route::get('/admin/menu/item/create/{header_id}', self::NAMESPACE.'\MenuItemController@create')->name('admin.menu.item.create');
            Route::post('/admin/menu/item/store', self::NAMESPACE.'\MenuItemController@store')->name('admin.menu.item.store');
            Route::get('/admin/menu/item/edit/{header_id}/{item_id}', self::NAMESPACE.'\MenuItemController@edit')->name('admin.menu.item.edit');
            Route::post('/admin/menu/item/update', self::NAMESPACE.'\MenuItemController@update')->name('admin.menu.item.update');
            Route::post('/admin/menu/item/delete', self::NAMESPACE.'\MenuItemController@delete')->name('admin.menu.item.delete');
            Route::post('/admin/menu/item/sort', self::NAMESPACE.'\MenuItemController@sort')->name('admin.menu.item.sort');
        });
    }

    /**
     * Set the role routes.
     *
     * @return void
     */
    public static function roles()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/role', self::NAMESPACE.'\RoleController@index')->name('admin.role.index');
            Route::get('/admin/role/create', self::NAMESPACE.'\RoleController@create')->name('admin.role.create');
            Route::post('/admin/role/store', self::NAMESPACE.'\RoleController@store')->name('admin.role.store');
            Route::get('/admin/role/edit/{id}', self::NAMESPACE.'\RoleController@edit')->name('admin.role.edit');
            Route::post('/admin/role/update', self::NAMESPACE.'\RoleController@update')->name('admin.role.update');
            Route::post('/admin/role/delete', self::NAMESPACE.'\RoleController@delete')->name('admin.role.delete');
            Route::get('/admin/role/reorder', self::NAMESPACE.'\RoleController@reorder')->name('admin.role.reorder');
            Route::post('/admin/role/sort', self::NAMESPACE.'\RoleController@sort')->name('admin.role.sort');
        });
    }

    /**
     * Set the permission routes.
     *
     * @return void
     */
    public static function permissions()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/permission', self::NAMESPACE.'\PermissionController@index')->name('admin.permission.index');
            Route::get('/admin/permission/create', self::NAMESPACE.'\PermissionController@create')->name('admin.permission.create');
            Route::post('/admin/permission/store', self::NAMESPACE.'\PermissionController@store')->name('admin.permission.store');
            Route::get('/admin/permission/edit/{id}', self::NAMESPACE.'\PermissionController@edit')->name('admin.permission.edit');
            Route::post('/admin/permission/update', self::NAMESPACE.'\PermissionController@update')->name('admin.permission.update');
            Route::post('/admin/permission/delete', self::NAMESPACE.'\PermissionController@delete')->name('admin.permission.delete');
            Route::get('/admin/permission/reorder', self::NAMESPACE.'\PermissionController@reorder')->name('admin.permission.reorder');
            Route::post('/admin/permission/sort', self::NAMESPACE.'\PermissionController@sort')->name('admin.permission.sort');
            Route::post('/admin/permission/change', self::NAMESPACE.'\PermissionController@change')->name('admin.permission.change');
        });
    }

    /**
     * Set the setting routes.
     *
     * @return void
     */
    public static function settings()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/setting', self::NAMESPACE.'\SettingController@index')->name('admin.setting.index');
            Route::post('/admin/setting/update', self::NAMESPACE.'\SettingController@update')->name('admin.setting.update');
        });
    }

    /**
     * Set the meta routes.
     *
     * @return void
     */
    public static function metas()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/meta', self::NAMESPACE.'\MetaController@index')->name('admin.meta.index');
            Route::post('/admin/meta/update', self::NAMESPACE.'\MetaController@update')->name('admin.meta.update');
        });
    }

    /**
     * Set the period routes.
     *
     * @return void
     */
    public static function periods()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/period', self::NAMESPACE.'\PeriodController@index')->name('admin.period.index');
            Route::get('/admin/period/create', self::NAMESPACE.'\PeriodController@create')->name('admin.period.create');
            Route::post('/admin/period/store', self::NAMESPACE.'\PeriodController@store')->name('admin.period.store');
            Route::get('/admin/period/edit/{id}', self::NAMESPACE.'\PeriodController@edit')->name('admin.period.edit');
            Route::post('/admin/period/update', self::NAMESPACE.'\PeriodController@update')->name('admin.period.update');
            Route::post('/admin/period/delete', self::NAMESPACE.'\PeriodController@delete')->name('admin.period.delete');
            Route::get('/admin/period/reorder', self::NAMESPACE.'\PeriodController@reorder')->name('admin.period.reorder');
            Route::post('/admin/period/sort', self::NAMESPACE.'\PeriodController@sort')->name('admin.period.sort');
            Route::get('/admin/period/setting', self::NAMESPACE.'\PeriodController@setting')->name('admin.period.setting');
            Route::post('/admin/period/set', self::NAMESPACE.'\PeriodController@set')->name('admin.period.set');
        });
    }

    /**
     * Set the schedule routes.
     *
     * @return void
     */
    public static function schedules()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/schedule', self::NAMESPACE.'\ScheduleController@index')->name('admin.schedule.index');
            Route::post('/admin/schedule/update', self::NAMESPACE.'\ScheduleController@update')->name('admin.schedule.update');
            Route::post('/admin/schedule/delete', self::NAMESPACE.'\ScheduleController@delete')->name('admin.schedule.delete');
        });
    }

    /**
     * Set the system routes.
     *
     * @return void
     */
    public static function systems()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/system', self::NAMESPACE.'\SystemController@index')->name('admin.system.index');
        });
    }

    /**
     * Set the database routes.
     *
     * @return void
     */
    public static function database()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/database', self::NAMESPACE.'\DatabaseController@index')->name('admin.database.index');
        });
    }

    /**
     * Set the dataset routes.
     *
     * @return void
     */
    public static function dataset()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/dataset', self::NAMESPACE.'\DatasetController@index')->name('admin.dataset.index');
        });
    }

    /**
     * Set the artisan routes.
     *
     * @return void
     */
    public static function artisan()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/artisan', self::NAMESPACE.'\ArtisanController@index')->name('admin.artisan.index');
            Route::post('/admin/artisan/run', self::NAMESPACE.'\ArtisanController@run')->name('admin.artisan.run');
        });
    }

    /**
     * Set the log routes.
     *
     * @return void
     */
    public static function logs()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.log.index');
            Route::get('/admin/log/activity', self::NAMESPACE.'\LogController@activity')->name('admin.log.activity');
            Route::get('/admin/log/activity/user', self::NAMESPACE.'\LogController@activityByUserID')->name('admin.log.activity.user');
            Route::get('/admin/log/activity/url', self::NAMESPACE.'\LogController@activityByURL')->name('admin.log.activity.url');
            Route::get('/admin/log/authentication', self::NAMESPACE.'\LogController@authentication')->name('admin.log.authentication');
        });
    }

    /**
     * Set the route routes.
     *
     * @return void
     */
    public static function route()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/route', self::NAMESPACE.'\RouteController@index')->name('admin.route.index');
        });
    }

    /**
     * Set the visitor routes.
     *
     * @return void
     */
    public static function visitors()
    {
        Route::group(['middleware' => ['faturhelper.admin']], function() {
            Route::get('/admin/visitor', self::NAMESPACE.'\VisitorController@index')->name('admin.visitor.index');
        });
    }

    /**
     * Set the API routes.
     *
     * @return void
     */
    public static function api()
    {
        // API routes with authentication
        self::apiAuth();

        // Bootstrap Icons
        Route::get('/dataset/bootstrap-icons', function() {
            return response()->json(bootstrap_icons(), 200);
        })->name('api.bootstrap-icons');

        // Country Code
        Route::get('/dataset/country-code', function() {
            return response()->json(country(), 200);
        })->name('api.country-code');
    }

    /**
     * Set the API routes with authentication.
     *
     * @return void
     */
    public static function apiAuth()
    {
        Route::group(['middleware' => ['faturhelper.api.auth']], function() {
            // User
            Route::get('/user/role', self::NAMESPACE.'\API\UserController@role')->name('api.user.role');
            Route::get('/user/status', self::NAMESPACE.'\API\UserController@status')->name('api.user.status');

            // Visitor
            Route::get('/visitor/device/type', self::NAMESPACE.'\API\VisitorController@deviceType')->name('api.visitor.device.type');
            Route::get('/visitor/device/family', self::NAMESPACE.'\API\VisitorController@deviceFamily')->name('api.visitor.device.family');
            Route::get('/visitor/browser', self::NAMESPACE.'\API\VisitorController@browser')->name('api.visitor.browser');
            Route::get('/visitor/platform', self::NAMESPACE.'\API\VisitorController@platform')->name('api.visitor.platform');
        });
    }
}