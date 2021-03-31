<?php

// EIT = European IT
define('BATCH_PREFIX', 'EIT');

/**
 * Create Batch Name
 * @param $course_title_short
 * @param $year
 * @param $month
 * @param $batch_number
 * @return string
 */
function batch_name($course_title_short, $year, $month, $batch_number)
{
    $batch_name = BATCH_PREFIX;
    $batch_name .= $course_title_short;
    $batch_name .= substr($year, -2);
    $batch_name .= ($month <= 9) ? '0' . $month : $month;
    $batch_name .= ($batch_number <= 9) ? '0' . $batch_number : $batch_number;
    return $batch_name;
}

function error_clean($str)
{
    if (!empty($str)) {
        return str_replace(['-', '_', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ' ', $str);
    }
    return $str;
}

function installment_message() {
    $message = 'Today is your installment date. Please clear all your previous dues positively.';
    return $message;
}


