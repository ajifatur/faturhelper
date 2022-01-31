<?php

/**
 * Generate Helpers:
 * @method string generate_method(string $method)
 * @method int generate_age(string $date)
 * @method string generate_date(string $date)
 * @method string generate_date_time(string $datetime)
 * @method string generate_date_format(string $date, string $format)
 * @method string generate_date_range(string $type, string $date)
 * @method string generate_time(int $time)
 * @method string generate_time_elapsed(string $datetime, bool $full = false)
 * @method array generate_file(string $path, array $exception_array = [])
 * @method string generate_inversion_color(string $color)
 * @method string generate_image_name(string $path, string $image_base64, string $image_url)
 * @method string generate_invoice(int $id, string $prefix = '')
 * @method string generate_permalink(string $string)
 * @method string generate_size(double $bytes)
 */

// Generate method
if(!function_exists('generate_method')){
    function generate_method($method){
        $explode = explode('\\', $method);
        return end($explode);
    }
}

// Generate umur / usia
if(!function_exists('generate_age')){
    function generate_age($date){
        $birthdate = new DateTime($date);
        $today = new DateTime('today');
        $old = $today->diff($birthdate)->y;
        return $old;
    }
}

// Generate tanggal
if(!function_exists('generate_date')){
    function generate_date($date){
        $explode = explode(" ", $date);
        $explode = explode("-", $explode[0]);
        return count($explode) == 3 ? ($explode[1]-1) >= 0 ? $explode[2]." ".array_indo_month()[$explode[1]-1]." ".$explode[0] : '' : '';
    }
}

// Generate tanggal dan waktu
if(!function_exists('generate_date_time')){
    function generate_date_time($datetime){
        $explode = explode(" ", $datetime);
        if(count($explode) == 2){
            $date = explode("-", $explode[0]);
            return count($date) == 3 ? ($date[1]-1) >= 0 ? $date[2]." ".array_indo_month()[$date[1]-1]." ".$date[0].", ".substr($explode[1],0,5) : '' : '';
        }
        else{
            return '';
        }
    }
}

// Generate format tanggal
if(!function_exists('generate_date_format')){
    function generate_date_format($date, $format){
        if($format == 'd/m/y'){
            $explode = explode("-", $date);
            return count($explode) == 3 ? $explode[2].'/'.$explode[1].'/'.$explode[0] : '';
        }
        elseif($format == 'y-m-d'){
            $explode = explode("/", $date);
            return count($explode) == 3 ? $explode[2].'-'.$explode[1].'-'.$explode[0] : '';
        }
        else
            return '';
    }
}

// Generate tanggal (range)
if(!function_exists('generate_date_range')){
    function generate_date_range($type, $date){
        // Join date range
        if($type == 'join'){
            $explode_dash = explode(" - ", $date);
            $explode_from = explode(" ", $explode_dash[0]);
            $explode_date_from = explode("-", $explode_from[0]);
            $from = $explode_date_from[2].'/'.$explode_date_from[1].'/'.$explode_date_from[0].' '.substr($explode_from[1],0,5);
            $explode_to = explode(" ", $explode_dash[1]);
            $explode_date_to = explode("-", $explode_to[0]);
            $to = $explode_date_to[2].'/'.$explode_date_to[1].'/'.$explode_date_to[0].' '.substr($explode_to[1],0,5);
            return array('from' => $from, 'to' => $to);
        }
        elseif($type == 'explode'){
            $explode_dash = explode(" - ", $date);
            $explode_from = explode(" ", $explode_dash[0]);
            $explode_date_from = explode("/", $explode_from[0]);
            $from = $explode_date_from[2].'-'.$explode_date_from[1].'-'.$explode_date_from[0].' '.$explode_from[1].':00';
            $explode_to = explode(" ", $explode_dash[1]);
            $explode_date_to = explode("/", $explode_to[0]);
            $to = $explode_date_to[2].'-'.$explode_date_to[1].'-'.$explode_date_to[0].' '.$explode_to[1].':00';
            return array('from' => $from, 'to' => $to);
        }
    }
}

// Generate time
if(!function_exists('generate_time')){
    function generate_time($time){
        if($time < 60)
            return $time." detik";
        elseif($time >= 60 && $time < 3600)
            return floor($time / 60)." menit ".fmod($time, 60)." detik";
        else
            return floor($time / 3600)." jam ".(floor($time / 60) - (floor($time / 3600) * 60))." menit ".fmod($time, 60)." detik";
    }
}

// Generate time elapsed
if(!function_exists('generate_time_elapsed')){
    function generate_time_elapsed($datetime, $full = false){
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                // $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'Baru saja';
    }
}

// Generate file dari folder
if(!function_exists('generate_file')){
    function generate_file($path, $exception_array = []){
        $dir = $path;
        $array = [];
        if(is_dir($dir)){
            if($handle = opendir($dir)){
                // Loop file
                while(($file = readdir($handle)) !== false){
                    // Pilih jika nama file bukan ".", "..", file bukan folder, serta file tidak dikecualikan
                    if($file != '.' && $file != '..' && !is_dir($dir.'/'.$file) && !in_array($file, $exception_array)){
                        array_push($array, $file);
                    }
                }
                closedir($handle);
            }
        }
        return $array;
    }
}

// Generate warna kebalikan
if(!function_exists('generate_inversion_color')){
    function generate_inversion_color($color){
        $hsl = rgb_to_hsl(hex_to_rgb($color));
        if($hsl->lightness > 200) return '#000000';
        else return '#ffffff';
    }
}

// Generate image name
if(!function_exists('generate_image_name')){
    function generate_image_name($path, $image_base64, $image_url){
        if($image_base64 != '')
            $image_name = upload_file($image_base64, $path);
        elseif($image_url != '')
            $image_name = str_replace(url()->to($path).'/', '', $image_url);
        else
            $image_name = '';

        return $image_name;
    }
}

// Generate invoice
if(!function_exists('generate_invoice')){
    function generate_invoice($id, $prefix = ''){    
        // Max 999.999
        if($id > 0 && $id < 10)
            $invoice = $prefix."00000".($id);
        elseif($id >= 10 && $id < 100)
            $invoice = $prefix."0000".($id);
        elseif($id >= 100 && $id < 1000)
            $invoice = $prefix."000".($id);
        elseif($id >= 1000 && $id < 10000)
            $invoice = $prefix."00".($id);
        elseif($id >= 10000 && $id < 100000)
            $invoice = $prefix."0".($id);
        elseif($id >= 100000 && $id < 1000000)
            $invoice = $prefix.($id);
        
        return $invoice;
    }
}

// Generate permalink
if(!function_exists('generate_permalink')){
    function generate_permalink($string){
        $result = strtolower($string);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = preg_replace("/\s+/", " ",$result);
        $result = str_replace(" ", "-", $result);
        return $result;
    }
}

// Generate ukuran dari satuan byte
if(!function_exists('generate_size')){
    function generate_size($bytes){ 
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return round($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return round($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return round($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return round($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}