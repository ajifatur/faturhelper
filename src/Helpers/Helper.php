<?php

/**
 * @method bool|void       has_access(string $permission_code, int $role, bool $isAbort = true)
 * @method string          method(string $method)
 * @method string|array    fetch(string $url, array $query)
 * @method string|int|null role(string|int $key)
 * @method string          setting(string $code)
 * @method string          meta(string $code)
 * @method array           period()
 * @method array           menu()
 * @method void            eval_sidebar(string $condition, string $true, string $false)
 * @method string          slugify(string $text, array $array)
 * @method string          access_token()
 * @method array|null      package(string|null $name)
 * @method array           notifications()
 * @method string          quill(string $html, string $path)
 * @method string          hex_to_rgb(string $code)
 * @method object          rgb_to_hsl(string $code)
 * @method string          reverse_color(string $color)
 * @method string          device_info()
 * @method string          browser_info()
 * @method string          platform_info()
 * @method string          location_info(string $ip)
 */

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Ajifatur\Helpers\FileExt;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use hisorange\BrowserDetect\Parser as Browser;
use Stevebauman\Location\Facades\Location;

/**
 * Check the access for the permission.
 *
 * @param  string $permission_code
 * @param  int    $role
 * @param  bool   $isAbort
 * @return bool|void
 */
if(!function_exists('has_access')) {
    function has_access($permission_code, $role, $isAbort = true) {
        // Get the permission
        $permission = \Ajifatur\FaturHelper\Models\Permission::where('code','=',$permission_code)->first();

        // If the permission is not exist
        if(!$permission) {
            if($isAbort) abort(403);
            else return false;
        }

        // Check role permission
        if(in_array($role, $permission->roles()->pluck('role_id')->toArray())) {
            return true;
        }
        else {
            if($isAbort) abort(403);
            else return false;
        }
    }
}

/**
 * Get the method from object.
 *
 * @param  string $method
 * @return string
 */
if(!function_exists('method')) {
    function method($method) {
        $explode = explode('\\', $method);
        return end($explode);
    }
}

/**
 * Fetch data by GET method.
 *
 * @param  string $url
 * @param  array  $query
 * @return array|string
 */
if(!function_exists('fetch')) {
    function fetch($url, $query = []) {
        try {
            $client = new Client;
            $response = $client->request('GET', $url, [
                'query' => $query
            ]);
        }
        catch (ClientException $e) {
            return Psr7\Message::toString($e->getResponse());
        }
        return json_decode($response->getBody(), true);
    }
}

/**
 * Get the role ID or name.
 *
 * @param  string|int $key
 * @return string|int|null
 */
if(!function_exists('role')) {
    function role($key) {
        // Get the role by ID
        if(is_int($key)) {
            $role = \Ajifatur\FaturHelper\Models\Role::find($key);
            return $role ? $role->name : null;
        }
        // Get the role by key
        elseif(is_string($key)) {
            $role = \Ajifatur\FaturHelper\Models\Role::where('code','=',$key)->first();
            return $role ? $role->id : null;
        }
        else return null;
    }
}

/**
 * Get the setting content by key.
 *
 * @param  string $key
 * @return string
 */
if(!function_exists('setting')) {
    function setting($key) {
        // Get the setting by key
        $setting = \Ajifatur\FaturHelper\Models\Setting::where('code','=',$key)->first();
        return $setting ? $setting->content : '';
    }
}

/**
 * Get the meta content by key.
 *
 * @param  string $key
 * @return string
 */
if(!function_exists('meta')) {
    function meta($key) {
        // Get the meta by key
        $meta = \Ajifatur\FaturHelper\Models\Meta::where('code','=',$key)->first();
        return $meta ? $meta->content : '';
    }
}

/**
 * Get periodes.
 *
 * @return array
 */
if(!function_exists('period')) {
    function period() {
        // Get periodes
        $periods = \Ajifatur\FaturHelper\Models\Period::orderBy('num_order','asc')->get();
        return $periods;
    }
}

/**
 * Get the menu.
 *
 * @return array
 */
if(!function_exists('menu')) {
    function menu() {
        // Declare menu
        $menus = [];

        // Get menu headers
        $menuheaders = \Ajifatur\FaturHelper\Models\MenuHeader::orderBy('num_order','asc')->get();

        if(count($menuheaders) > 0) {
            foreach($menuheaders as $menuheader) {
                // Get menu items
                $menuitems = $menuheader->items()->where('parent','=',0)->orderBy('num_order','asc')->get();
                $items = [];
                if(count($menuitems) > 0) {
                    foreach($menuitems as $menuitem) {
                        if($menuitem->visible_conditions == '' || ($menuitem->visible_conditions != '' && (bool)eval_sidebar($menuitem->visible_conditions, true, false))) {
                            // Get menu subitems
                            $menusubitems = $menuheader->items()->where('parent','=',$menuitem->id)->orderBy('num_order','asc')->get();
                            $subitems = [];
                            if(count($menusubitems) > 0) {
                                foreach($menusubitems as $menusubitem) {
                                    // Push to array
                                    array_push($subitems, [
                                        'name' => $menusubitem->name,
                                        'route' => $menusubitem->route != '' ? $menusubitem->routeparams != '' ? route($menusubitem->route, json_decode($menusubitem->routeparams, true)) : route($menusubitem->route) : '',
                                        'visible_conditions' => $menusubitem->visible_conditions,
                                        'active_conditions' => $menusubitem->active_conditions,
                                    ]);
                                }
                            }

                            // Push to array
                            array_push($items, [
                                'name' => $menuitem->name,
                                'route' => $menuitem->route != '' ? $menuitem->routeparams != '' ? route($menuitem->route, json_decode($menuitem->routeparams, true)) : route($menuitem->route) : '',
                                'icon' => $menuitem->icon,
                                'visible_conditions' => $menuitem->visible_conditions,
                                'active_conditions' => $menuitem->active_conditions,
                                'children' => $subitems
                            ]);
                        }
                    }
                }

                // Push to array
                array_push($menus, [
                    'header' => $menuheader->name,
                    'items' => $items
                ]);
            }
        }

        // Return
        return $menus;
    }
}

/**
 * Eval the sidebar.
 *
 * @param  string $condition
 * @param  string $true
 * @param  string $false
 * @return void
 */
if(!function_exists('eval_sidebar')) {
    function eval_sidebar($condition, $true, $false = '') {
        return eval("if(".$condition.") return '".$true."'; else return '".$false."';");
    }
}

/**
 * Slugify the text.
 *
 * @param  string $text
 * @param  array  $array
 * @return string
 */
if(!function_exists('slugify')) {
    function slugify($text, $array) {
        // Convert the text to slug
        $slug = Str::slug($text);

        // Check the slug from exist slugs
        $i = 1;
        while(in_array($slug, $array)) {
            $i++;
            $slug = Str::slug($text).'-'.$i;
        }

        // Return
        return $slug;
    }
}

/**
 * Generate the access token for user.
 *
 * @return string
 */
if(!function_exists('access_token')) {
    function access_token() {
        // Generate token
        $token = Str::random(40);

        // Get exist tokens
        $exist_tokens = \Ajifatur\FaturHelper\Models\User::pluck('access_token')->toArray();

        // Check the token from exist tokens
        while(in_array($token, $exist_tokens)) {
            $token = Str::random(40);
        }

        // Return
        return $token;
    }
}

/**
 * Get the package.
 *
 * @param  string|null $name
 * @return array|null
 */
if(!function_exists('package')) {
    function package($name = null) {
        // Get the composer lock
        $composer = File::get(base_path('composer.lock'));

        // Get packages
        $array = json_decode($composer, true);
        $packages = array_key_exists('packages', $array) ? $array['packages'] : [];

        // Get the package if name is not null
        if($name === null) {
            return $packages;
        }
        else {
            $index = '';
            if(count($packages)>0) {
                foreach($packages as $key=>$package) {
                    if($package['name'] == $name) $index = $key;
                }
            }
            return array_key_exists($index, $packages) ? $packages[$index] : null;
        }
    }
}

/**
 * Get the notifications.
 *
 * @return array
 */
if(!function_exists('notifications')) {
    function notifications() {
        // Set notifications
        $notifications = [];

        // Check whether super admin account still using default password
        $default_password = Hash::check('password', \Ajifatur\FaturHelper\Models\User::first()->password);
        if($default_password === true) {
            array_push($notifications, [
                'title' => 'Password Akun',
                'description' => 'Anda masih menggunakan password default. Segera ganti demi keamanan akun Anda.',
                'route' => route('admin.settings.password'),
                'icon_name' => 'bi-exclamation-circle',
                'icon_color' => 'text-danger',
            ]);
        }

        // Return
        return $notifications;
    }
}

/**
 * Set HTML entities from Quill Editor and upload the image.
 *
 * @param  string $html
 * @param  string $path
 * @return string
 */
if(!function_exists('quill')) {
    function quill($html, $path) {
        // Get the image from <img>
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $images = $dom->getElementsByTagName('img');

        foreach($images as $key=>$image) {
            // Get the "src" attribute
            $code = $image->getAttribute('src');

            // Get the image that not URL
            if(filter_var($code, FILTER_VALIDATE_URL) == false) {
                // Upload the image
                list($type, $code) = explode(';', $code);
                list(, $code)      = explode(',', $code);
                $code = base64_decode($code);
                $mime = str_replace('data:', '', $type);
                $image_name = date('Y-m-d-H-i-s').' ('.($key+1).')';
                $image_name = $image_name.'.'.mime($mime);
                file_put_contents($path.$image_name, $code);

                // Change the "src" attribute
                $image->setAttribute('src', URL::to('/').'/'.$path.$image_name);
            }
        }
        
        // Return
        return htmlentities($dom->saveHTML());
    }
}

/**
 * Convert Hex to RGB.
 *
 * @param  string $code
 * @return string
 */
if(!function_exists('hex_to_rgb')) {
    function hex_to_rgb($code) {
        if($code[0] == '#')
            $code = substr($code, 1);

        if(strlen($code) == 3)
            $code = $code[0] . $code[0] . $code[1] . $code[1] . $code[2] . $code[2];

        $r = hexdec($code[0] . $code[1]);
        $g = hexdec($code[2] . $code[3]);
        $b = hexdec($code[4] . $code[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }
}

/**
 * Convert RGB to HSL.
 *
 * @param  string $code
 * @return object
 */
if(!function_exists('rgb_to_hsl')) {
    function rgb_to_hsl($code) {
        $r = 0xFF & ($code >> 0x10);
        $g = 0xFF & ($code >> 0x8);
        $b = 0xFF & $code;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC) {
            $s = 0;
            $h = 0;
        }
        else {
            if($l < .5)
                $s = ($maxC - $minC) / ($maxC + $minC);
            else
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);

            if($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0; 
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }
}

/**
 * Reverse the color to be dark or light.
 *
 * @param  string $color
 * @return string
 */
if(!function_exists('reverse_color')) {
    function reverse_color($color) {
        $hsl = rgb_to_hsl(hex_to_rgb($color));
        if($hsl->lightness > 200) return '#000000';
        else return '#ffffff';
    }
}

/**
 * Get the user device info.
 *
 * @return string
 */
if(!function_exists('device_info')) {
    function device_info() {
        // Device type
        $device_type = '';
        if(Browser::isMobile()) $device_type = 'Mobile';
        if(Browser::isTablet()) $device_type = 'Tablet';
        if(Browser::isDesktop()) $device_type = 'Desktop';
        if(Browser::isBot()) $device_type = 'Bot';

        $device = [
            'type' => $device_type,
            'family' => Browser::deviceFamily(),
            'model' => Browser::deviceModel(),
            'grade' => Browser::mobileGrade(),
        ];

        return json_encode($device);
    }
}

/**
 * Get the user browser info.
 *
 * @return string
 */
if(!function_exists('browser_info')) {
    function browser_info() {
        $browser = [
            'name' => Browser::browserName(),
            'family' => Browser::browserFamily(),
            'version' => Browser::browserVersion(),
            'engine' => Browser::browserEngine(),
        ];

        return json_encode($browser);
    }
}

/**
 * Get the user platform info.
 *
 * @return string
 */
if(!function_exists('platform_info')) {
    function platform_info() {
        $platform = [
            'name' => Browser::platformName(),
            'family' => Browser::platformFamily(),
            'version' => Browser::platformVersion(),
        ];

        return json_encode($platform);
    }
}

/**
 * Get the user location info.
 *
 * @param  string $ip
 * @return string
 */
if(!function_exists('location_info')) {
    function location_info($ip) {
        $location = Location::get($ip);
        return $location ? json_encode($location) : '';
    }
}
