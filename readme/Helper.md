# Helper

Methods:
- has_access
- method
- role
- setting
- meta
- period
- menu
- eval_sidebar
- slugify
- access_token
- package
- quill
- hex_to_rgb
- rgb_to_hsl
- reverse_color
- device_info
- browser_info
- platform_info
- location_info

## has_access

Check the access for the permission by the role:

``` php
has_access(method(__METHOD__), Auth::user()->role_id); // Return: void or abort 403
```

The default of third parameter is true. If it's false, it will return boolean without aborting:

``` php
has_access('UserController::index', Auth::user()->role_id, false); // Return: boolean
```

## method

Get the method from the object:

``` php
echo method(__METHOD__); // Output: UserController::index
```

## role

Get the role name by ID:

``` php
echo role(1); // Output: Admin
```

Get the role ID by key:

``` php
echo role('admin'); // Output: 1
```

## setting

Get the setting content by key:

``` php
echo setting('name'); // Output: FaturHelper
```

## meta

Get the meta content by key:

``` php
echo meta('author'); // Output: Aji Fatur
```

## period

Get periods:

``` php
print_r(period()); // Output: [...]
```

## menu

## eval_sidebar

## slugify

Set the slug according to exist array. If the slug is not in array, the slug won't be changed:

``` php
echo slugify('Lorem Ipsum Sit Dolor Amet', []);
// Output: lorem-ipsum-sit-dolor-amet
```

If the slug is in array, the slug will be changed:

``` php
echo slugify('Lorem Ipsum Sit Dolor Amet', ['lorem-ipsum-sit-dolor-amet']);
// Output: lorem-ipsum-sit-dolor-amet-2
```

## access_token

Generate the access token for user:

``` php
echo access_token(); // Output: abcd...z
```

## package

Get the package by name:

``` php
print_r(package('ajifatur/faturhelper')); // Output: [...]
```

The default of parameter is null. If it's null, it will return the package array:

``` php
print_r(package()); // Output: [...]
```

## quill

Set HTML entities from Quill Editor and upload the image:

``` php
echo quill('...'); // Output: ...
```

## hex_to_rgb

Convert Hex to RGB:

``` php
echo hex_to_rgb('#333333'); // Output: 3355443
```

## rgb_to_hsl

Convert RGB to HSL:

``` php
print_r(rgb_to_hsl('3355443')); // Output: {["hue"] => 0, ["saturation"] => 0, ["lightness"] => 51}
```

## reverse_color

Reverse the color to be dark or light:

``` php
echo reverse_color('#333333'); // Output: #ffffff
```

## device_info

Get the user device info in JSON format:

``` php
echo device_info(); // Output: {"type":"Desktop","family":"Unknown","model":"","grade":""}
```

## browser_info

Get the user browser info in JSON format:

``` php
echo browser_info(); // Output: {"name":"Opera 83.0.4254","family":"Opera","version":"83.0.4254","engine":"Blink"}
```

## platform_info

Get the user platform info in JSON format:

``` php
echo platform_info(); // Output: {"name":"Windows 10","family":"Windows","version":"10"}
```

## location_info

Get the user location info by IP address in JSON format:

``` php
echo location_info('127.0.0.1'); // Output: ""
```