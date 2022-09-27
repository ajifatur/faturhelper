# DateTime

Methods:
- change
- split
- merge
- diff
- toString
- elapsed
- day
- month
- full

How to use the object:

```php
use Ajifatur\Helpers\DateTimeExt;
```

## change

Convert the date from YYYY-MM-DD format to DD/MM/YYYY format:

``` php
echo DateTimeExt::change('2021-11-26'); // Output: 26/11/2021
```

Convert the date from DD/MM/YYYY format to YYYY-MM-DD format:

``` php
echo DateTimeExt::change('26/11/2021'); // Output: 2021-11-26
```

If the date format is unavailable, it will return null:

``` php
echo DateTimeExt::change('1 Nov 2021'); // Output: null
```

## split

Split the date from Daterangepicker format to array that contains timestamp format:

``` php
print_r(DateTimeExt::split('01/11/2021 10:00 - 26/11/2021 12:00'));
// Output: ['2021-11-01 10:00:00', '2021-11-26 12:00:00']
```

## merge

Merge the date from two timestamps to Daterangepicker format:

``` php
echo DateTimeExt::merge(['2021-11-01 10:00:00', '2021-11-26 12:00:00']);
// Output: 01/11/2021 10:00 - 26/11/2021 12:00
```

## diff

Get the difference in years between two dates:

``` php
echo DateTimeExt::diff('2000-01-01', '2010-05-01'); // Output: 10
```

The default of second parameter is null. If it's null, it will get the difference to the current date:

``` php
echo DateTimeExt::diff('2000-01-01'); // Output: 21 (Let's assume that the current date is '2021-11-26')
```

## toString

Convert the time to string format:

``` php
echo DateTimeExt::toString(57);   // Output: 57 detik
echo DateTimeExt::toString(125);  // Output: 2 menit 5 detik
echo DateTimeExt::toString(3670); // Output: 1 jam 1 menit 10 detik
```

## elapsed

Get the elapsed time to the current time:

``` php
echo DateTimeExt::elapsed('2021-08-01 12:00:00'); // Output: 3 bulan yang lalu
echo DateTimeExt::elapsed('2020-01-01 12:00:00'); // Output: 1 tahun yang lalu
```

## day

Get the Indonesian day by datetime:

``` php
echo DateTimeExt::day('2022-09-27');  // Output: Selasa
echo DateTimeExt::day('2022-09-30');  // Output: Jum'at
```

## month

Get the Indonesian month by number:

``` php
echo DateTimeExt::month(5);  // Output: Mei
```

If the month is unavailable, it will return "":

``` php
echo DateTimeExt::month(13); // Output: ""
```

The default of parameter is null. If it's null, it will return the Indonesian month array:

``` php
echo DateTimeExt::month();
// Output: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
```

## full

Get the datetime with string format:

``` php
echo DateTimeExt::full('2021-02-21 11:05:45'); // Output: 21 Februari 2021, 11:05
echo DateTimeExt::full('2021-05-21');          // Output: 21 Mei 2021
```
