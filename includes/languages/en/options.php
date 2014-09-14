<?php
///////////////////////////////////////////////////////////////////////////////////
// LOCALE, DATE AND TIME DEFINITIONS
///////////////////////////////////////////////////////////////////////////////////
@setlocale(LC_TIME, 'es_ES.ISO_8859-1');
setlocale(LC_TIME, 'spanish');
date_default_timezone_set('Europe/Madrid');
define('DATE_MONTH', '%m');  // this is used for strftime()
define('DATE_DAY', '%d');  // this is used for strftime()
define('DATE_YEAR', '%Y');  // this is used for strftime()
define('DATE_FORMAT_SHORT', '%Y/%m/%d');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'Y/m/d');  // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('TIME_FORMAT', ' %H:%M:%S');
?>