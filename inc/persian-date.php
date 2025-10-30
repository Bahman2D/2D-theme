<?php
if (!defined('ABSPATH')) exit;

class TwoD_Persian_Date {
    private static $instance = null;
    
    private $persian_months = array(
        1 => 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
        'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
    );
    
    private $persian_days = array(
        'Saturday' => 'شنبه',
        'Sunday' => 'یکشنبه',
        'Monday' => 'دوشنبه',
        'Tuesday' => 'سه‌شنبه',
        'Wednesday' => 'چهارشنبه',
        'Thursday' => 'پنج‌شنبه',
        'Friday' => 'جمعه'
    );
    
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        add_filter('get_the_date', array($this, 'convert_date'), 10, 3);
        add_filter('get_the_modified_date', array($this, 'convert_date'), 10, 3);
        add_filter('get_comment_date', array($this, 'convert_date'), 10, 3);
        add_filter('the_time', array($this, 'convert_date'), 10, 3);
        add_filter('get_the_time', array($this, 'convert_date'), 10, 3);
    }
    
    public function gregorian_to_jalali($g_y, $g_m, $g_d) {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        
        $gy = $g_y - 1600;
        $gm = $g_m - 1;
        $gd = $g_d - 1;
        
        $g_day_no = 365 * $gy + floor(($gy + 3) / 4) - floor(($gy + 99) / 100) + floor(($gy + 399) / 400);
        
        for ($i = 0; $i < $gm; ++$i) {
            $g_day_no += $g_days_in_month[$i];
        }
        
        if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) {
            $g_day_no++;
        }
        
        $g_day_no += $gd;
        $j_day_no = $g_day_no - 79;
        $j_np = floor($j_day_no / 12053);
        $j_day_no = $j_day_no % 12053;
        $jy = 979 + 33 * $j_np + 4 * floor($j_day_no / 1461);
        $j_day_no %= 1461;
        
        if ($j_day_no >= 366) {
            $jy += floor(($j_day_no - 1) / 365);
            $j_day_no = ($j_day_no - 1) % 365;
        }
        
        $j_total_days = $j_day_no + 1;
        
        for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
            $j_day_no -= $j_days_in_month[$i];
        }
        
        $jm = $i + 1;
        $jd = $j_day_no + 1;
        
        return array($jy, $jm, $jd, $j_total_days);
    }
    
    public function format_persian_date($format, $timestamp = null) {
        $timestamp = $timestamp ? $timestamp : time();
        
        $gregorian_date = getdate($timestamp);
        list($j_y, $j_m, $j_d, $j_total_days) = $this->gregorian_to_jalali(
            $gregorian_date['year'],
            $gregorian_date['mon'],
            $gregorian_date['mday']
        );
        
        $replacements = array(
            'Y' => $j_y,
            'y' => substr($j_y, -2),
            'm' => str_pad($j_m, 2, '0', STR_PAD_LEFT),
            'n' => $j_m,
            'd' => str_pad($j_d, 2, '0', STR_PAD_LEFT),
            'j' => $j_d,
            'F' => $this->persian_months[$j_m],
            'M' => mb_substr($this->persian_months[$j_m], 0, 3),
            'l' => $this->persian_days[date('l', $timestamp)],
            'D' => mb_substr($this->persian_days[date('l', $timestamp)], 0, 2),
            'H' => date('H', $timestamp),
            'h' => date('h', $timestamp),
            'G' => date('G', $timestamp),
            'g' => date('g', $timestamp),
            'i' => date('i', $timestamp),
            's' => date('s', $timestamp),
            'a' => (date('a', $timestamp) == 'am') ? 'ق.ظ' : 'ب.ظ',
            'A' => (date('A', $timestamp) == 'AM') ? 'قبل از ظهر' : 'بعد از ظهر',
            'z' => $j_total_days - 1
        );
        
        $output = $format;
        foreach ($replacements as $key => $value) {
            $output = str_replace($key, $value, $output);
        }
        
        return $output;
    }
    
    public function convert_date($the_date, $format = '', $post = null) {
        if (empty($format)) {
            $format = get_option('date_format');
        }
        
        $timestamp = null;
        
        if ($post) {
            if (is_numeric($post)) {
                $post = get_post($post);
            }
            if ($post) {
                $timestamp = strtotime($post->post_date);
            }
        }
        
        if (!$timestamp) {
            $timestamp = time();
        }
        
        return $this->format_persian_date($format, $timestamp);
    }
}

TwoD_Persian_Date::get_instance();

function twod_persian_date($format = 'Y/m/d', $timestamp = null) {
    $pd = TwoD_Persian_Date::get_instance();
    return $pd->format_persian_date($format, $timestamp);
}