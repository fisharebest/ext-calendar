<?php
namespace Fisharebest\ExtCalendar;

/**
 * class Shim - PHP implementations of functions from the PHP calendar extension.
 *
 * @link      http://php.net/manual/en/book.calendar.php
 *
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2014 Greg Roach
 * @license   This program is free software: you can redistribute it and/or modify
 *            it under the terms of the GNU General Public License as published by
 *            the Free Software Foundation, either version 3 of the License, or
 *            (at your option) any later version.
 *
 *            This program is distributed in the hope that it will be useful,
 *            but WITHOUT ANY WARRANTY; without even the implied warranty of
 *            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *            GNU General Public License for more details.
 *
 *            You should have received a copy of the GNU General Public License
 *            along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class Shim {
	/** @var FrenchCalendar */
	private static $french_calendar;

	/** @var GregorianCalendar */
	private static $gregorian_calendar;

	/** @var JewishCalendar */
	private static $jewish_calendar;

	/** @var JulianCalendar */
	private static $julian_calendar;

	/**
	 * English names for the days of the week.
	 *
	 * @var string[]
	 */
	private static $DAY_NAMES = array(
		'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',
	);

	/**
	 * Abbreviated English names for the days of the week.
	 *
	 * @var string[]
	 */
	private static $DAY_NAMES_ABBREVIATED = array(
		'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat',
	);

	/** @var string[] Names of the months of the Gregorian/Julian calendars */
	private static $MONTH_NAMES = array(
		'', 'January', 'February', 'March', 'April', 'May', 'June',
		'July', 'August', 'September', 'October', 'November', 'December',
	);

	/** @var string[] Abbreviated names of the months of the Gregorian/Julian calendars */
	private static $MONTH_NAMES_ABBREVIATED = array(
		'', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
	);

	/** @var string[] Name of the months of the French calendar */
	private static $MONTH_NAMES_FRENCH = array(
		'', 'Vendemiaire', 'Brumaire', 'Frimaire', 'Nivose', 'Pluviose', 'Ventose',
		'Germinal', 'Floreal', 'Prairial', 'Messidor', 'Thermidor', 'Fructidor', 'Extra'
	);

	/** @var string[] Names of the months of the Jewish calendar in a non-leap year */
	private static $MONTH_NAMES_JEWISH = array(
		'', 'Tishri', 'Heshvan', 'Kislev', 'Tevet', 'Shevat', 'Adar',
		'Adar', 'Nisan', 'Iyyar', 'Sivan', 'Tammuz', 'Av', 'Elul',
	);

	/** @var string[] Names of the months of the Jewish calendar in a leap year */
	private static $MONTH_NAMES_JEWISH_LEAP_YEAR = array(
		'', 'Tishri', 'Heshvan', 'Kislev', 'Tevet', 'Shevat', 'Adar I',
		'Adar II', 'Nisan', 'Iyyar', 'Sivan', 'Tammuz', 'Av', 'Elul',
	);

	/** @var string[] Names of the months of the Jewish calendar (before PHP bug 54254 was fixed)*/
	private static $MONTH_NAMES_JEWISH_54254 = array(
		'', 'Tishri', 'Heshvan', 'Kislev', 'Tevet', 'Shevat', 'AdarI',
		'AdarII', 'Nisan', 'Iyyar', 'Sivan', 'Tammuz', 'Av', 'Elul',
	);

	/**
	 * Create the necessary shims to emulate the ext/calendar packate.
	 *
	 * @param FrenchCalendar    $french_calendar
	 * @param GregorianCalendar $gregorian_calendar
	 * @param JewishCalendar    $jewish_calendar
	 * @param JulianCalendar    $julian_calendar
	 *
	 * @return void
	 */
	public static function create(
		FrenchCalendar    $french_calendar    = null,
		GregorianCalendar $gregorian_calendar = null,
		JewishCalendar    $jewish_calendar    = null,
		JulianCalendar    $julian_calendar    = null
	) {
		self::$french_calendar    = $french_calendar    ?: new FrenchCalendar;
		self::$gregorian_calendar = $gregorian_calendar ?: new GregorianCalendar;
		self::$jewish_calendar    = $jewish_calendar    ?: new JewishCalendar;
		self::$julian_calendar    = $julian_calendar    ?: new JulianCalendar;

		defined('CAL_NUM_CALS') || require __DIR__ . '/shims.php';
	}

	/**
	 * Do we need to emulate PHP bug #54254?
	 *
	 * This bug relates to the names used for months 6 and 7 in the Jewish calendar.
	 *
	 * It was fixed in PHP 5.5.0
	 *
	 * @link https://bugs.php.net/bug.php?id=54254
	 *
	 * @return bool
	 */
	public static function emulateBug54254() {
		return version_compare(PHP_VERSION, '5.5.0', '<');
	}

	/**
	 * Do we need to emulate PHP bug #67960?
	 *
	 * This bug relates to the constants CAL_DOW_SHORT and CAL_DOW_LONG.
	 *
	 * It will hopefully be fixed in PHP 5.6.1
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 * @link https://github.com/php/php-src/pull/806
	 *
	 * @return bool
	 */
	public static function emulateBug67960() {
		return true;
	}

	/**
	 * Do we need to emulate PHP bug #67976?
	 *
	 * This bug relates to the number of days in the month 13 of year 14 in
	 * the French calendar.
	 *
	 * @link https://bugs.php.net/bug.php?id=67976
	 *
	 * @return bool
	 */
	public static function emulateBug67976() {
		return true;
	}

	/**
	 * Return the number of days in a month for a given year and calendar.
	 *
	 * Shim implementation of cal_days_in_month()
	 *
	 * @link https://php.net/cal_days_in_month
	 * @link https://bugs.php.net/bug.php?id=67976
	 *
	 * @param int $calendar_id
	 * @param int $month
	 * @param int $year
	 *
	 * @return int The number of days in the specified month
	 */
	public static function calDaysInMonth($calendar_id, $month, $year) {
		switch ($calendar_id) {
		case CAL_FRENCH:
			return self::calDaysInMonthFrench($year, $month);

		case CAL_GREGORIAN:
			return self::calDaysInMonthCalendar(self::$gregorian_calendar, $year, $month);

		case CAL_JEWISH:
			return self::calDaysInMonthJewish($year, $month);

		case CAL_JULIAN:
			return self::calDaysInMonthCalendar(self::$julian_calendar, $year, $month);

		default:
			return trigger_error('invalid calendar ID ' . $calendar_id, E_USER_WARNING);
		}
	}

	/**
	 * Calculate the number of days in a month in a specified calendar
	 *
	 * @param int $year
	 * @param int $month
	 *
	 * @return int
	 */
	private static function calDaysInMonthCalendar(CalendarInterface $calendar, $year, $month) {
		if ($year == 0 || $month < 1 || $month > 12) {
			return trigger_error('invalid date.', E_USER_WARNING);
		} else {
			return $calendar->daysInMonth($year, $month);
		}
	}

	/**
	 * Calculate the number of days in a month in the French calendar
	 *
	 * @param int $year
	 * @param int $month
	 *
	 * @return int
	 */
	private static function calDaysInMonthFrench($year, $month) {
		if ($month == 13 && $year == 14 && self::emulateBug67976()) {
			return -2380948;
		} elseif ($year < 1 || $year > 14 || $month < 1 || $month > 13) {
			return trigger_error('invalid date.', E_USER_WARNING);
		} else {
			return self::$french_calendar->daysInMonth($year, $month);
		}
	}

	/**
	 * Calculate the number of days in a month in the French calendar
	 *
	 * @param int $year
	 * @param int $month
	 *
	 * @return int
	 */
	private static function calDaysInMonthJewish($year, $month) {
		if ($year < 1 || $month < 1 || $month > 13) {
			return trigger_error('invalid date.', E_USER_WARNING);
		} else {
			return self::$jewish_calendar->daysInMonth($year, $month);
		}
	}

	/**
	 * Converts from Julian Day Count to a supported calendar.
	 *
	 * Shim implementation of cal_from_jd()
	 *
	 * @link https://php.net/cal_from_jd
	 *
	 * @param int $julian_day  Julian Day number
	 * @param int $calendar_id Calendar constant
	 *
	 * @return array
	 */
	public static function calFromJd($julian_day, $calendar_id) {
		switch ($calendar_id) {
		case CAL_FRENCH:
			list($month, $day, $year) = explode('/', self::jdToFrench($julian_day));
			$months = self::$MONTH_NAMES_FRENCH;
			$months_abbreviated = $months;
			break;

		case CAL_GREGORIAN:
			list($month, $day, $year) = explode('/', self::jdToGregorian($julian_day));
			$months = self::$MONTH_NAMES;
			$months_abbreviated = self::$MONTH_NAMES_ABBREVIATED;
			break;

		case CAL_JEWISH:
			list($month, $day, $year) = explode('/', self::jdToJewish($julian_day, false, 0));
			if (self::$jewish_calendar->leapYear($year)) {
				$months = self::emulateBug54254() ? self::$MONTH_NAMES_JEWISH_54254 : self::$MONTH_NAMES_JEWISH_LEAP_YEAR;
			} else {
				$months = self::emulateBug54254() ? self::$MONTH_NAMES_JEWISH_54254 : self::$MONTH_NAMES_JEWISH;
			}
			$months_abbreviated = $months;
			break;

		case CAL_JULIAN:
			list($month, $day, $year) = explode('/', self::jdToJulian($julian_day));
			$months = self::$MONTH_NAMES;
			$months_abbreviated = self::$MONTH_NAMES_ABBREVIATED;
			break;

		default:
			return trigger_error('invalid calendar ID ' . $calendar_id, E_USER_WARNING);
		}

		return array(
			'date' => $month . '/' . $day . '/' . $year,
			'month' => (int)$month,
			'day' => (int)$day,
			'year' => (int)$year,
			'dow' => self::jdDayOfWeek($julian_day, 0),
			'abbrevdayname' => self::jdDayOfWeek($julian_day, 2),
			'dayname' => self::jdDayOfWeek($julian_day, 1),
			'abbrevmonth' => $months_abbreviated[$month],
			'monthname' => $months[$month],
		);
	}

	/**
	 * Returns information about a particular calendar.
	 *
	 * Shim implementation of cal_info()
	 *
	 * @link https://php.net/cal_info
	 *
	 * @param int $calendar_id
	 *
	 * @return array
	 */
	public static function calInfo($calendar_id) {
		switch ($calendar_id) {
		case CAL_FRENCH:
			return self::calInfoFrench();

		case CAL_GREGORIAN:
			return self::calInfoGregorian();

		case CAL_JEWISH:
			return self::calInfoJewish();

		case CAL_JULIAN:
			return self::calInfoJulian();

		case -1:
			return array(
				CAL_GREGORIAN => self::calInfoGregorian(),
				CAL_JULIAN => self::calInfoJulian(),
				CAL_JEWISH => self::calInfoJewish(),
				CAL_FRENCH => self::calInfoFrench(),
			);

		default:
			return trigger_error('invalid calendar ID ' . $calendar_id, E_USER_WARNING);
		}
	}

	/**
	 * Returns information about the French calendar.
	 *
	 * @return array
	 */
	private static function calInfoFrench() {
		return array(
			'months' => array_slice(self::$MONTH_NAMES_FRENCH, 1, 13, true),
			'abbrevmonths' => array_slice(self::$MONTH_NAMES_FRENCH, 1, 13, true),
			'maxdaysinmonth' => 30,
			'calname' => 'French',
			'calsymbol' => 'CAL_FRENCH',
		);
	}

	/**
	 * Returns information about the Gregorian calendar.
	 *
	 * @return array
	 */
	private static function calInfoGregorian() {
		return array(
			'months' => array_slice(self::$MONTH_NAMES, 1, 12, true),
			'abbrevmonths' => array_slice(self::$MONTH_NAMES_ABBREVIATED, 1, 12, true),
			'maxdaysinmonth' => 31,
			'calname' => 'Gregorian',
			'calsymbol' => 'CAL_GREGORIAN',
		);
	}

	/**
	 * Returns information about the Jewish calendar.
	 *
	 * @return array
	 */
	private static function calInfoJewish() {
		$months = self::emulateBug54254() ? self::$MONTH_NAMES_JEWISH_54254 : self::$MONTH_NAMES_JEWISH_LEAP_YEAR;

		return array(
			'months' => array_slice($months, 1, 13, true),
			'abbrevmonths' => array_slice($months, 1, 13, true),
			'maxdaysinmonth' => 30,
			'calname' => 'Jewish',
			'calsymbol' => 'CAL_JEWISH',
		);
	}

	/**
	 * Returns information about the Julian calendar.
	 *
	 * @return array
	 */
	private static function calInfoJulian() {
		return array(
			'months' => array_slice(self::$MONTH_NAMES, 1, 12, true),
			'abbrevmonths' => array_slice(self::$MONTH_NAMES_ABBREVIATED, 1, 12, true),
			'maxdaysinmonth' => 31,
			'calname' => 'Julian',
			'calsymbol' => 'CAL_JULIAN',
		);
	}

	/**
	 *  Converts from a supported calendar to Julian Day Count
	 *
	 * Shim implementation of cal_to_jd()
	 *
	 * @link https://php.net/cal_to_jd
	 *
	 * @param int $calendar
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function calToJd($calendar, $month, $day, $year) {
		switch ($calendar) {
		case CAL_FRENCH:
			return Shim::frenchToJd($month, $day, $year);

		case CAL_GREGORIAN:
			return Shim::gregorianToJd($month, $day, $year);

		case CAL_JEWISH:
			return Shim::jewishToJd($month, $day, $year);

		case CAL_JULIAN:
			return Shim::julianToJd($month, $day, $year);

		default:
			return trigger_error('invalid calendar ID ' . $calendar . '.', E_USER_WARNING);
		}
	}

	/**
	 * Get Unix timestamp for midnight on Easter of a given year.
	 *
	 * Shim implementation of easter_date()
	 *
	 * @link https://php.net/easter_date
	 *
	 * @param int $year
	 *
	 * @return int
	 */
	public static function easterDate($year) {
		if ($year < 1970 || $year > 2037) {
			return trigger_error('This function is only valid for years between 1970 and 2037 inclusive', E_USER_WARNING);
		}

		$days = self::$gregorian_calendar->easterDays($year);

		// Calculate time-zone offset
		$date_time = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));
		$offset_seconds = $date_time->format('Z');

		if ($days < 11) {
			return jdtounix(self::$gregorian_calendar->ymdToJd($year, 3, $days + 21)) - $offset_seconds;
		} else {
			return jdtounix(self::$gregorian_calendar->ymdToJd($year, 4, $days - 10)) - $offset_seconds;
		}
	}

	/**
	 * Get number of days after March 21 on which Easter falls for a given year.
	 *
	 * Shim implementation of easter_days()
	 *
	 * @link https://php.net/easter_days
	 *
	 * @param int $year
	 * @param int $method   Use the Julian or Gregorian calendar
	 *
	 * @return int
	 */
	public static function easterDays($year, $method) {
		switch ($method) {
			case CAL_EASTER_ROMAN:
				if ($year <= 1582) {
					return self::$julian_calendar->easterDays($year);
				} else {
					return self::$gregorian_calendar->easterDays($year);
				}

			case CAL_EASTER_ALWAYS_GREGORIAN:
				return self::$gregorian_calendar->easterDays($year);

			case CAL_EASTER_ALWAYS_JULIAN:
				return self::$julian_calendar->easterDays($year);

			default: // CAL_EASTER_DEFAULT or any other value
				if ($year <= 1752) {
					return self::$julian_calendar->easterDays($year);
				} else {
					return self::$gregorian_calendar->easterDays($year);
				}
		}
	}

	/**
	 * Converts a date from the French Republican Calendar to a Julian Day Count.
	 *
	 * Shim implementation of FrenchToJD()
	 *
	 * @link https://php.net/FrenchToJD
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function frenchToJd($month, $day, $year) {
		if ($year <= 0) {
			return 0;
		} else {
			return self::$french_calendar->ymdToJd($year, $month, $day);
		}
	}

	/**
	 * Converts a Gregorian date to Julian Day Count.
	 *
	 * Shim implementation of GregorianToJD()
	 *
	 * @link https://php.net/GregorianToJD
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function gregorianToJd($month, $day, $year) {
		if ($year == 0) {
			return 0;
		} else {
			return self::$gregorian_calendar->ymdToJd($year, $month, $day);
		}
	}

	/**
	 * Returns the day of the week.
	 *
	 * Shim implementation of JDDayOfWeek()
	 *
	 * @link https://php.net/JDDayOfWeek
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @param int $julian_day
	 * @param int $mode
	 *
	 * @return mixed
	 */
	public static function jdDayOfWeek($julian_day, $mode) {
		$day_of_week = ($julian_day + 1) % 7;
		if ($day_of_week < 0) {
			$day_of_week += 7;
		}

		switch ($mode) {
			case 1: // 1, not CAL_DOW_LONG - see bug 67960
				return self::$DAY_NAMES[$day_of_week];

			case 2: // 2, not CAL_DOW_SHORT - see bug 67960
				return self::$DAY_NAMES_ABBREVIATED[$day_of_week];

			default: // CAL_DOW_DAYNO or anything else
				return $day_of_week;
		}
	}

	/**
	 * Returns a month name.
	 *
	 * Shim implementation of JDMonthName()
	 *
	 * @link https://php.net/JDMonthName
	 *
	 * @param int $julian_day
	 * @param int $mode
	 *
	 * @return string
	 */
	public static function jdMonthName($julian_day, $mode) {
		switch ($mode) {
			case CAL_MONTH_GREGORIAN_LONG:
				list(, $month) = self::$gregorian_calendar->jdToYmd($julian_day);

				return self::$MONTH_NAMES[$month];

			case CAL_MONTH_JULIAN_LONG:
				list(, $month) = self::$julian_calendar->jdToYmd($julian_day);

				return self::$MONTH_NAMES[$month];

			case CAL_MONTH_JULIAN_SHORT:
				list(, $month) = self::$julian_calendar->jdToYmd($julian_day);

				return self::$MONTH_NAMES_ABBREVIATED[$month];

			case CAL_MONTH_JEWISH:
				list($year, $month) = self::$jewish_calendar->jdToYmd($julian_day);
				if (self::$jewish_calendar->leapYear($year)) {
					$months = self::emulateBug54254() ? self::$MONTH_NAMES_JEWISH_54254 : self::$MONTH_NAMES_JEWISH_LEAP_YEAR;
				} else {
					$months = self::emulateBug54254() ? self::$MONTH_NAMES_JEWISH_54254 : self::$MONTH_NAMES_JEWISH;
				}

				return $months[$month];

			case CAL_MONTH_FRENCH:
				list(, $month) = self::$french_calendar->jdToYmd($julian_day);
				return self::$MONTH_NAMES_FRENCH[$month];

			default: // CAL_MONTH_GREGORIAN_SHORT and anything else
				list(, $month) = self::$gregorian_calendar->jdToYmd($julian_day);
				return self::$MONTH_NAMES_ABBREVIATED[$month];
		}
	}

	/**
	 * Converts a Julian Day Count to the French Republican Calendar.
	 *
	 * Shim implementation of JDToFrench()
	 *
	 * @link https://php.net/JDToFrench
	 *
	 * @param int $julian_day A Julian Day number
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdToFrench($julian_day) {
		// JDToFrench() converts years 1 to 14 inclusive, even though the calendar
		// officially ended on 10 Nivôse 14 (JD 2380687, 31st December 1805 Gregorian).
		if ($julian_day >= 2375840 && $julian_day <= 2380952) {
			list($year, $month, $day) = self::$french_calendar->jdToYmd($julian_day);

			return $month . '/' . $day . '/' . $year;
		} else {
			return '0/0/0';
		}
	}

	/**
	 * Converts Julian Day Count to Gregorian date.
	 *
	 * Shim implementation of JDToGregorian()
	 *
	 * @link https://php.net/JDToGregorian
	 *
	 * @param int $julian_day A Julian Day number
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdToGregorian($julian_day) {
		// PHP has different limits on 32 and 64 bit systems.
		$MAX_JD = PHP_INT_SIZE == 4 ? 536838866 : 2305843009213661906;

		if ($julian_day >= 1 && $julian_day <= $MAX_JD) {
			list($year, $month, $day) = self::$gregorian_calendar->jdToYmd($julian_day);

			return $month . '/' . $day . '/' . $year;
		} else {
			return '0/0/0';
		}
	}

	/**
	 * Converts a Julian day count to a Jewish calendar date.
	 *
	 * Shim implementation of JdtoJjewish()
	 *
	 * @link https://php.net/JdtoJewish
	 *
	 * @param int $julian_day A Julian Day number
	 * @param bool $hebrew    If true, the date is returned in Hebrew text
	 * @param int $fl         If $hebrew is true, then add alafim and gereshayim to the text
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdToJewish($julian_day, $hebrew, $fl) {
		if ($hebrew) {
			if ($julian_day < 347998 || $julian_day > 4000075) {
				return trigger_error('Year out of range (0-9999).', E_USER_WARNING);
			}

			return self::$jewish_calendar->jdToHebrew($julian_day, $fl & CAL_JEWISH_ADD_ALAFIM_GERESH, $fl & CAL_JEWISH_ADD_ALAFIM, $fl & CAL_JEWISH_ADD_GERESHAYIM);
		} else {
			// The upper limit is hard-coded into PHP to prevent numeric overflow on 32 bit systems.
			if ($julian_day >= 347998 && $julian_day <= 324542846) {
				list($year, $month, $day) = self::$jewish_calendar->jdToYmd($julian_day);

				return $month . '/' . $day . '/' . $year;
			} else {
				return '0/0/0';
			}
		}
	}

	/**
	 * Converts a Julian Day Count to a Julian Calendar Date.
	 *
	 * Shim implementation of JDToJulian()
	 *
	 * @link https://php.net/JDToJulian
	 *
	 * @param int $julian_day A Julian Day number
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdToJulian($julian_day) {
		// PHP has different limits on 32 and 64 bit systems.
		$MAX_JD = PHP_INT_SIZE == 4 ? 536838829 : 784368370349;

		if ($julian_day >= 1 && $julian_day <= $MAX_JD) {
			list($year, $month, $day) = self::$julian_calendar->jdToYmd($julian_day);

			return $month . '/' . $day . '/' . $year;
		} else {
			return '0/0/0';
		}
	}

	/**
	 * Convert Julian Day to Unix timestamp.
	 *
	 * Shim implementation of jdtounix()
	 *
	 * @link https://php.net/jdtounix
	 *
	 * @param int $julian_day
	 *
	 * @return int
	 */
	public static function jdToUnix($julian_day) {
		if ($julian_day >= 2440588 && $julian_day <= 2465343) {
			return (int)($julian_day - 2440588) * 86400;
		} else {
			return false;
		}
	}

	/**
	 * Converts a date in the Jewish Calendar to Julian Day Count.
	 *
	 * Shim implementation of JewishToJD()
	 *
	 * @link https://php.net/JewishToJD
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function jewishToJd($month, $day, $year) {
		if ($year <= 0) {
			return 0;
		} else {
			return self::$jewish_calendar->ymdToJd($year, $month, $day);
		}
	}

	/**
	 * Converts a Julian Calendar date to Julian Day Count.
	 *
	 * Shim implementation of JdToJulian()
	 *
	 * @link https://php.net/JdToJulian
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function julianToJd($month, $day, $year) {
		if ($year == 0) {
			return 0;
		} else {
			return self::$julian_calendar->ymdToJd($year, $month, $day);
		}
	}

	/**
	 * Convert Unix timestamp to Julian Day.
	 *
	 * Shim implementation of unixtojd()
	 *
	 * @link https://php.net/unixtojd
	 *
	 * @param int $timestamp
	 *
	 * @return int
	 */
	public static function unixToJd($timestamp) {
		if ($timestamp < 0) {
			return false;
		} else {
			// Convert timestamp based on local timezone
			return self::GregorianToJd(gmdate('n', $timestamp), gmdate('j', $timestamp), gmdate('Y', $timestamp));
		}
	}
}
