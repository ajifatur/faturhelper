<?php

/**
 * @var string DATESEPARATOR
 * @var string TIMESEPARATOR
 * @var array  MONTHS
 * 
 * @method static string|null  change(string $date)
 * @method static array|null   split(string $date)
 * @method static string       merge(array $date)
 * @method static int          diff(string $from, string $to)
 * @method static string       toString(int $time)
 * @method static string       elapsed(string $datetime, bool $full)
 * @method static string       day(string $datetime)
 * @method static string|array month(int|null $number)
 * @method static string       full(string $datetime)
 */

namespace Ajifatur\Helpers;

class DateTimeExt
{
    const DATESEPARATOR = ' - ';
    const TIMESEPARATOR = ' ';
    const DAYS = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
    const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    /**
     * Change date format.
     *
     * @param  string $date
     * @return string|null
     */
    public static function change($date)
    {
        // If the date format is YYYY-MM-DD
        if(is_int(strpos($date, '-'))) {
            $explode = explode('-', $date);
            return count($explode) == 3 ? $explode[2].'/'.$explode[1].'/'.$explode[0] : null;
        }
        // If the date format is DD/MM/YYYY
        elseif(is_int(strpos($date, '/'))){
            $explode = explode('/', $date);
            return count($explode) == 3 ? $explode[2].'-'.$explode[1].'-'.$explode[0] : null;
        }
        else return null;
    }

    /**
     * Split date from daterangepicker format.
     *
     * @param  string $date
     * @return array|null
     */
    public static function split($date)
    {
        // Split date by separator
        $times = explode(self::DATESEPARATOR, $date);

        // Set start time and end time
        if(count($times) == 2) {
            // Start time
            $start_time = explode(self::TIMESEPARATOR, $times[0]);
            $start_at = count($start_time) == 2 ? self::change($start_time[0], '/').' '.$start_time[1].':00' : null;

            // End time
            $end_time = explode(self::TIMESEPARATOR, $times[1]);
            $end_at = count($end_time) == 2 ? self::change($end_time[0], '/').' '.$end_time[1].':00' : null;
        }

        // Return
        return [$start_at, $end_at];
    }

    /**
     * Merge date to be daterangepicker format.
     *
     * @param  array $date
     * @return string
     */
    public static function merge($date)
    {
        // Validate date format
        if(count(array_filter($date)) == 2) {
            return date('d/m/Y H:i', strtotime($date[0])) . self::DATESEPARATOR . date('d/m/Y H:i', strtotime($date[1]));
        }
        else return '';
    }

    /**
     * Get the difference between two dates.
     *
     * @param  string $from
     * @param  string $to
     * @return int
     */
    public static function diff($from, $to = null)
    {
        $dateFrom = new \DateTime($from);
        $dateTo = $to == null ? new \DateTime('today') : new \DateTime($to);
        $diff = $dateTo->diff($dateFrom)->y;
        return abs($diff);
    }

    /**
     * Convert the time to string format.
     *
     * @param  int $time
     * @return string
     */
    public static function toString($time)
    {
        if($time < 60)
            return $time." detik";
        elseif($time >= 60 && $time < 3600)
            return fmod($time, 60) > 0 ? floor($time / 60)." menit ".fmod($time, 60)." detik" : floor($time / 60)." menit";
        else
            return fmod($time, 60) > 0 ? floor($time / 3600)." jam ".(floor($time / 60) - (floor($time / 3600) * 60))." menit ".fmod($time, 60)." detik" : floor($time / 3600)." jam ".(floor($time / 60) - (floor($time / 3600) * 60))." menit";
    }

    /**
     * Get the elapsed time.
     *
     * @param  string $datetime
     * @param  bool   $full
     * @return string
     */
    public static function elapsed($datetime, $full = false)
    {
        $from = new \DateTime;
        $to = new \DateTime($datetime);
        $diff = $from->diff($to);

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
            if($diff->$k)
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            else
                unset($string[$k]);
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'Baru saja';
    }

    /**
     * Get the Indonesian day by date.
     *
     * @param  string $datetime
     * @return string
     */
    public static function day($datetime)
    {
        $days = self::DAYS;

        $w = date('w', strtotime($datetime));

        return array_key_exists($w, $days) ? $days[$w] : '';
    }

    /**
     * Get the Indonesian month.
     *
     * @param  int|null $number
     * @return array|string
     */
    public static function month($number = null)
    {
        $months = self::MONTHS;

        if($number == null)
            return $months;
        else
            return array_key_exists($number-1, $months) ? $months[$number-1] : '';
    }

    /**
     * Get the datetime with string format.
     *
     * @param  string $datetime
     * @return string
     */
    public static function full($datetime)
    {
        // Split date and time
        $time = explode(self::TIMESEPARATOR, $datetime);

        // If the parameter is date with time
        if(count($time) == 2) {
            $date = explode('-', $time[0]);
            return count($date) == 3 ? self::month($date[1]) != '' ? $date[2]." ".self::month($date[1])." ".$date[0].", ".substr($time[1],0,5) : '' : '';
        }
        // If the parameter is date without time
        elseif(count($time) == 1) {
            $date = explode('-', $time[0]);
            return count($date) == 3 ? self::month($date[1]) != '' ? $date[2]." ".self::month($date[1])." ".$date[0] : '' : '';
        }
        else return '';
    }
}