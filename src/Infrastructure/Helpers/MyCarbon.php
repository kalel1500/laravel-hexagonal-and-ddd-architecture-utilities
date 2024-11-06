<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Helpers;

use Carbon\CarbonImmutable;

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

    public static function checkFormat(string $date, string $format): bool
    {
        $formatted = CarbonImmutable::parse($date)->format($format);
        return ($date === $formatted);
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
