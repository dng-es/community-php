<?php
///////////////////////////////////////////////////////////////////////////////////
// LOCALE, DATE AND TIME DEFINITIONS
///////////////////////////////////////////////////////////////////////////////////
$LANGUAGE_LOCALE = 'en_GB.UTF-8';
$LANGUAGE_TIMEZONE = 'Europe/Madrid';
$DATE_MONTH = '%m';  // this is used for strftime()
$DATE_MONTH_LONG = '%B';  // this is used for strftime()
$DATE_DAY = '%d';  // this is used for strftime()
$DATE_YEAR ='%Y';  // this is used for strftime()
$DATE_FORMAT_SHORT = '%Y/%m/%d';  // this is used for strftime()
$DATE_FORMAT_LONG = '%A %d %B %Y'; // this is used for strftime()
$DATE_FORMAT = 'Y/m/d';  // this is used for date()
$TIME_FORMAT = '%H:%M:%S';
$DATE_TIME_FORMAT = $DATE_FORMAT_SHORT . ' ' . $TIME_FORMAT;
?>