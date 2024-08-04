<?php

namespace App\Services;

class DateId
{
    public static array $days = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
    public static array $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'December'];


    public static function getDay(string $dayInEn): string
    {
        return self::$days[$dayInEn];
    }
    public static function getMonth(int $m): string
    {
        return self::$months[$m - 1];
    }
}
