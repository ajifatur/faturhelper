<?php

/**
 * @method array        datasets(string $category)
 * 
 * @method string|array gender(string|null $code)
 * @method string|array platform(string|null $code)
 * @method string|array relationship(string|null $code)
 * @method string|array religion(string|null $code)
 * @method string|array status(string|null $code)
 * 
 * @method array        bootstrap_icons()
 * @method string|array color(string|null $name, string|null $type)
 * @method string|array country(string|null $code)
 * @method string|array dial_code(string|null $code)
 * @method string       mime(string $type)
 * @method string       quote(string|null $random)
 */

use Ajifatur\Helpers\FileExt;

/**
 * Get the array of available datasets.
 *
 * @param  string $category
 * @return array
 */
if(!function_exists('datasets')) {
    function datasets($category) {
        $array = [
            'small' => [
                'gender' => 'Jenis Kelamin',
                'platform' => 'Platform',
                'relationship' => 'Hubungan',
                'religion' => 'Agama',
                'status' => 'Status'
            ],
            'large' => [
                'bootstrap-icons' => 'Bootstrap Icon',
                'color' => 'Warna',
                'country-code' => 'Kode Negara',
                'mime' => 'MIME',
                'quote' => 'Kutipan Inspiratif',
                'timezone' => 'Zona Waktu',
            ]
        ];

        return array_key_exists($category, $array) ? $array[$category] : [];
    }
}

/**
 * Get the gender.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('gender')) {
    function gender($code = null) {
        // Get genders from datasets
        $array = FileExt::json('gender.json');

        // Remove N gender
        if(setting('n_gender_visibility') == 0) {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['key'] == 'N') $index = $key;
            }
            unset($array[$index]);
        }

        // Set the gender / genders
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['key'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['name'] : '';
        }
    }
}

/**
 * Get the platform.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('platform')) {
    function platform($code = null) {
        // Get platforms from datasets
        $array = FileExt::json('platform.json');

        // Set the platform / platforms
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['key'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['name'] : '';
        }
    }
}

/**
 * Get the relationship.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('relationship')) {
    function relationship($code = null) {
        // Get relationships from datasets
        $array = FileExt::json('relationship.json');

        // Set the relationship / relationships
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['key'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['name'] : '';
        }
    }
}

/**
 * Get the religion.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('religion')) {
    function religion($code = null) {
        // Get religions from datasets
        $array = FileExt::json('religion.json');

        // Set the religion / religion
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['key'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['name'] : '';
        }
    }
}

/**
 * Get the status.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('status')) {
    function status($code = null) {
        // Get status from datasets
        $array = FileExt::json('status.json');

        // Set the status
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['key'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['name'] : '';
        }
    }
}

/**
 * Get the Bootstrap Icons.
 *
 * @return array
 */
if(!function_exists('bootstrap_icons')) {
    function bootstrap_icons() {
        // Get Bootstrap Icons from datasets
        $array = FileExt::json('bootstrap-icons.json');

        // Change array
        $new_array = [];
        foreach($array as $key=>$data) {
            $new_array[$key]['name'] = "bi-".$data;
        }

        // Return
        return $new_array;
    }
}

/**
 * Get the color.
 *
 * @param  string|null $name
 * @param  string|null $type
 * @return string|array
 */
if(!function_exists('color')) {
    function color($name = null, $type = null) {
        // Get colors from datasets
        $array = FileExt::json('color.json');
        $array = $array['colors'];

        // Set the color / colors
        if($name === null)
            return $array;
        else {
            // Get color index
            $index = '';
            foreach($array as $key=>$value) {
                if($value['name'] == $name) $index = $key;
            }

            // Get color description
            if($type === 'hex')
                return array_key_exists($index, $array) ? $array[$index]['hex'] : '';
            elseif($type === 'rgb')
                return array_key_exists($index, $array) ? [$array[$index]['r'], $array[$index]['g'], $array[$index]['b']] : [];
            elseif($type === 'hsl')
                return array_key_exists($index, $array) ? [$array[$index]['h'], $array[$index]['s'], $array[$index]['l']] : [];
            else
                return array_key_exists($index, $array) ? $array[$index] : [];
        }
    }
}

/**
 * Get the country.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('country')) {
    function country($code = null) {
        // Get countries from datasets
        $array = FileExt::json('country-code.json');

        // Set the country / countries
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['code'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['name'] : '';
        }
    }
}

/**
 * Get the dial code.
 *
 * @param  string|null $code
 * @return string|array
 */
if(!function_exists('dial_code')) {
    function dial_code($code = null) {
        // Get dial codes from datasets
        $array = FileExt::json('country-code.json');

        // Set the dial code / dial codes
        if($code === null) return $array;
        else {
            $index = '';
            foreach($array as $key=>$value) {
                if($value['code'] == $code) $index = $key;
            }
            return array_key_exists($index, $array) ? $array[$index]['dial_code'] : '';
        }
    }
}

/**
 * Get the MIME by type.
 *
 * @param  string $type
 * @return string
 */
if(!function_exists('mime')) {
    function mime($type) {
        // Get MIME from datasets
        $array = FileExt::json('mime.json');

        // Get the extension by type
        $mime = '';
        foreach($array as $key=>$value) {
            if($value == $type) $mime = $key;
        }

        // Return
        return $mime;
    }
}

/**
 * Get the quote.
 *
 * @param  string|null $type
 * @return string
 */
if(!function_exists('quote')) {
    function quote($random = null) {
        // Get quotes from datasets
        $array = FileExt::json('quote.json');

        // If random
        if($random === 'random') {
            return $array[rand(0, count($array)-1)];
        }
        else {
            return $array;
        }
    }
}