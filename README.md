[![Build Status](https://travis-ci.org/fisharebest/localization.svg?branch=master)](https://travis-ci.org/fisharebest/localization)
[![Coverage Status](https://coveralls.io/repos/fisharebest/localization/badge.png)](https://coveralls.io/r/fisharebest/localization)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a252b4b3-62c1-40bd-be44-43a7dc6e4a9b/mini.png)](https://insight.sensiolabs.com/projects/a252b4b3-62c1-40bd-be44-43a7dc6e4a9b)

PHP Calendar functions
==========================

This package provides replacements for the functions in PHP‘s
[calendar](php.net/manual/en/book.calendar.php) extension.
It allows you to implement calendar conversion on servers
where this extension is not installed.

The following functions are implemented

* jdtofrench()
* jdtogregorian()
* jdtojulian()

The following constants are implemented:

* CAL_GREGORIAN
* CAL_JULIAN
* CAL_JEWISH
* CAL_FRENCH
* CAL_NUM_CALS
* CAL_DOW_DAYNO
* CAL_DOW_SHORT
* CAL_DOW_LONG
* CAL_MONTH_GREGORIAN_SHORT
* CAL_MONTH_GREGORIAN_LONG
* CAL_MONTH_JULIAN_SHORT
* CAL_MONTH_JULIAN_LONG
* CAL_MONTH_JEWISH
* CAL_MONTH_FRENCH
* CAL_EASTER_DEFAULT
* CAL_EASTER_ROMAN
* CAL_EASTER_ALWAYS_GREGORIAN
* CAL_EASTER_ALWAYS_JULIAN
* CAL_JEWISH_ADD_ALAFIM_GERESH
* CAL_JEWISH_ADD_ALAFIM
* CAL_JEWISH_ADD_GERESHAYIM


The following functions still need to be written

* cal_days_in_month()
* cal_from_jd()
* cal_info()
* cal_to_jd()
* easter_date()
* easter_days()
* frenchtojd()
* gregoriantojd()
* jddayofweek()
* jdmonthname()
* jdtofrench()
* jdtogregorian()
* jdtojewish()
* jdtojulian()
* jdtounix()
* jewishtojd()
* juliantojd()
* unixtojd()


Getting started
===============

Add the package as a dependency in your `composer.json` file:

    require {
        "fisharebest/localization": "1.*"
    }

Bootstrap the package before you use it:

    // bootstrap.php
    \Fisharebest\ExtCalendar\Bootstrap\init();

Development
===========

Note that `require-dev` will require `ext-calendar`, as we use it as a reference
implementation for testing.

Pull requests are welcome.  Please ensure you include unit-tests where applicable,
and follow the coding conventions.  These are to follow PSR, except for

* tabs are used for indentation
* opening braces always go on the end of the previous line
