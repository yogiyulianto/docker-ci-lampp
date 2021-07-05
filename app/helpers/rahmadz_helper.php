<?php

//------------------ Date Function

function dPickerCvt($date, $time = false) {
    $x = null;
    if (!empty($date)) {
        $dateReset = str_replace(array(".", "_", "/"), "-", $date);
        $new_date = explode("-", $dateReset);
        $getY = null;
        foreach ($new_date as $d_nom => $d_row) {
            if (strlen($d_row) == 4) {
                $getY = $d_nom;
            }
        }
        if (in_array($d_nom, array(0, 2))) {
            $x = date("Y-m-d", strtotime($dateReset));
        }
    }
    return $x;
}

function indoDateCvt($date, $length = null, $hourShow = null, $secondShow = null) {
    $datetime = explode(' ', $date);
    $getHour = null;
    if (!empty($datetime[1])) {
        if (isset($hourShow)) {
            $hour = explode(":", $datetime[1]);
            $milis = !empty($secondShow) ? ":$hour[2]" : null;
            $getHour = "<i class='fas fa-clock m-r-5 m-l-5'></i> $hour[0]:$hour[1]$milis";
        }
    }
    $dateCvt = date("d # Y", strtotime(dPickerCvt($datetime[0])));
    return str_replace("#", indoMonthCvt(date('n', strtotime(dPickerCvt($datetime[0]))), $length), $dateCvt) . (!empty($length) ? " $getHour" : $getHour);
}

function indoMonthCvt($getMo, $length = null) {
    if ($getMo == 1)
        $mo = empty($length) ? "Januari" : "Jan";
    if ($getMo == 2)
        $mo = empty($length) ? "Februari" : "Feb";
    if ($getMo == 3)
        $mo = empty($length) ? "Maret" : "Mar";
    if ($getMo == 4)
        $mo = empty($length) ? "April" : "Apr";
    if ($getMo == 5)
        $mo = "Mei";
    if ($getMo == 6)
        $mo = "Juni";
    if ($getMo == 7)
        $mo = "Juli";
    if ($getMo == 8)
        $mo = empty($length) ? "Agustus" : "Agust";
    if ($getMo == 9)
        $mo = empty($length) ? "September" : "Sept";
    if ($getMo == 10)
        $mo = empty($length) ? "Oktober" : "Okt";
    if ($getMo == 11)
        $mo = empty($length) ? "November" : "Nov";
    if ($getMo == 12)
        $mo = empty($length) ? "Desember" : "Des";
    return $mo;
}


if (!function_exists('rupiah')) {
	/**
	 * Format rupiah
	 * 
	 * @param  any $number number to format
	 * @return string         formated number
	 */
	function rupiah($number, $decimal = 0)
	{
		if (!$double = (float) $number) {
			return $number;
		}
		return 'Rp.  ' . number_format($double, $decimal, ',', '.');
	}
}

if ( ! function_exists('slugify'))
{
    function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
	}
}
