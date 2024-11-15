<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Helpers;

use Carbon\CarbonImmutable;
use Throwable;

final class MyCarbon
{
    public static $date_startYear                         = 'Y-m-d';
    public static $date_startDay                          = 'd-m-Y';
    public static $date_startYear_slash                   = 'Y/m/d';
    public static $date_startDay_slash                    = 'd/m/Y';
    public static $date_startMonthWithoutDay_slash        = 'm/Y';
    public static $datetime_startYear                     = 'Y-m-d H:i:s';
    public static $datetime_startYear_withoutSeconds      = 'Y-m-d H:i';
    public static $datetime_startDay_slash                = 'd/m/Y H:i:s';
    public static $datetime_startDay_slash_withoutSeconds = 'd/m/Y H:i';
    public static $datetime_eloquent_timestamps           = 'Y-m-d\TH:i:s.u\Z';
    public static $time                                   = 'H:i:s';

    public static function stringToformat($date, $format, $getNowIfNullRecived = false): ?string
    {
        $isInValid = (is_null($date) || $date === '');
        $returnNow = $getNowIfNullRecived;

        if ($isInValid && !$returnNow) {
            return null;
        }

        if ($isInValid && $returnNow) {
            $carbon = self::now();
        } else {
            $carbon = self::parse($date);
        }

        return $carbon->format($format);
    }

    public static function formatInputDateToAudit($imputDate): ?string
    {
        return MyCarbon::stringToformat($imputDate, MyCarbon::$datetime_startYear);
    }

    public static function parse($date): CarbonImmutable
    {
        return CarbonImmutable::parse($date);
    }

    public static function now(): CarbonImmutable
    {
        return CarbonImmutable::now();
    }

    public static function compare($date1, $operator, $date2)
    {
        if (is_null($date1) || is_null($date2)) {
            return null;
        }
        $timestamp_date1 = self::parse($date1)->timestamp;
        $timestamp_date2 = self::parse($date2)->timestamp;
        $operation = $timestamp_date1.$operator.$timestamp_date2;
        return (eval('return '.$operation.';'));
    }

    /**
     * @param string|CarbonImmutable $date // TODO PHP8 - union types
     * @param string|CarbonImmutable $time // TODO PHP8 - union types
     * @return CarbonImmutable|null
     */
    public static function mergeDateAndTime($date, $time): ?CarbonImmutable
    {
        $date = ($date instanceof CarbonImmutable) ? $date : self::parse($date);
        $time = ($time instanceof CarbonImmutable) ? $time : self::parse($time);
        $date = $date->format(self::$date_startYear);
        $time = $time->format(self::$time);
        return self::parse($date.' '.$time);
    }

    public static function checkFormat(string $date, string $format, bool $allowZeros = false): bool
    {
        // Verificar si el valor es cero según el formato y $allowZeros es true
        if ($allowZeros && self::isZeroDate($date, $format)) {
            return true;
        }

        // Verificar el formato utilizando CarbonImmutable
        try {
            $formatted = CarbonImmutable::parse($date)->format($format);
            return ($date === $formatted);
        } catch (Throwable $e) {
            // Si el parseo falla, retornar false
            return false;
        }
    }

    public static function checkFormats(string $date, array $formats, bool $allowZeros = false): bool
    {
        // Iterar sobre cada formato y llamar a checkFormat
        foreach ($formats as $format) {
            if (self::checkFormat($date, $format, $allowZeros)) {
                return true;
            }
        }

        // Si ningún formato coincide, retornar false
        return false;
    }

    private static function isZeroDate(string $date, string $format): bool
    {
        // Crear una cadena de ceros basada en el formato
        $zeroDate = strtr($format, [
            'Y' => '0000',
            'm' => '00',
            'd' => '00',
            'H' => '00',
            'i' => '00',
            's' => '00',
        ]);

        return $date === $zeroDate;
    }

    public static function debugTime(string $debugTitle, callable $callback)
    {
        dump($debugTitle);
        $init = MyCarbon::now();
        $callback();
        $end = MyCarbon::now();
        $interval = $init->diff($end);
        dump($init->format('H:i:s'));
        dump($end->format('H:i:s'));
        dump($interval->format("%I min %S sec, %f ms"));
        dd('fin');
    }
}
