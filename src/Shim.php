<?php
namespace Fisharebest\ExtCalendar;

/**
 * class Shim - PHP implementations of functions from the PHP calendar extension.
 *
 * @link      http://php.net/manual/en/book.calendar.php
 *
 * Some PHP installations are built without the ext-calendar extension, which
 * provides functions for working with, and converting between, various calendars
 * such as Gregorian, Julian and Jewish.
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
	/**
	 * Convert a French Republican date into a Julian Day number.
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function frenchtojd($month, $day, $year) {
		return 2375444 + $day + $month * 30 + $year * 365 + (int)($year / 4);
	}

	/**
	 * Convert a Gregorian date into a Julian Day number.
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function gregoriantojd($month, $day, $year) {
		if ($year < 0) {
			// 0=1BC, -1=2BC, etc.
			++$year;
		}
		$a = (int)((14 - $month) / 12);
		$year = $year + 4800 - $a;
		$month = $month + 12 * $a - 3;

		return $day + (int)((153 * $month + 2) / 5) + 365 * $year + (int)($year / 4) - (int)($year / 100) + (int)($year / 400) - 32045;
	}

	/**
	 * Convert a Julian Day number into the French Republican calendar.
	 *
	 * @param int $julian A Julian Day number
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdtofrench($julian) {
		if ($julian < 2375840 || $julian > 2380952) {
			// Out-of range.  This is in contrast to Gregorian and Julian
			// which are implemented as ‘proleptic’ calendars.
			$year = 0;
			$month = 0;
			$day = 0;
		} else {
			$year = (int)(($julian - 2375109) * 4 / 1461) - 1;
			$month = (int)(($julian - 2375475 - $year * 365 - (int)($year / 4)) / 30) + 1;
			$day = $julian - 2375444 - $month * 30 - $year * 365 - (int)($year / 4);
		}

		return $month . '/' . $day . '/' . $year;
	}

	/**
	 * Convert a Julian Day number into the Gregorian calendar.
	 *
	 * @param int $julian A Julian Day number
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdtogregorian($julian) {
		$a = $julian + 32044;
		$b = (int)((4 * $a + 3) / 146097);
		$c = $a - (int)($b * 146097 / 4);
		$d = (int)((4 * $c + 3) / 1461);
		$e = $c - (int)((1461 * $d) / 4);
		$m = (int)((5 * $e + 2) / 153);
		$day = $e - (int)((153 * $m + 2) / 5) + 1;
		$month = $m + 3 - 12 * (int)($m / 10);
		$year = $b * 100 + $d - 4800 + (int)($m / 10);
		if ($year < 1) { // 0=1BC, -1=2BC, etc.
			--$year;
		}

		return $month . '/' . $day . '/' . $year;;
	}

	/**
	 * Convert a Julian Day number into the Julian calendar.
	 *
	 * @param int $julian A Julian Day number
	 *
	 * @return string A string of the form "month/day/year"
	 */
	public static function jdtojulian($julian) {
		$c = $julian + 32082;
		$d = (int)((4 * $c + 3) / 1461);
		$e = $c - (int)(1461 * $d / 4);
		$m = (int)((5 * $e + 2) / 153);
		$day = $e - (int)((153 * $m + 2) / 5) + 1;
		$month = $m + 3 - 12 * (int)($m / 10);
		$year = $d - 4800 + (int)($m / 10);
		if ($year<1) {
			// 0=1BC, -1=2BC, etc.
			--$year;
		}
		return array($year, $month, $day);

		return $month . '/' . $day . '/' . $year;;
	}

	/**
	 * Convert a Julian date into a Julian Day number.
	 *
	 * @param int $month
	 * @param int $day
	 * @param int $year
	 *
	 * @return int
	 */
	public static function juliantojd($month, $day, $year) {
		if ($year < 0) {
			// 0=1BC, -1=2BC, etc.
			++$year;
		}
		$a = (int)((14 - $month) / 12);
		$year = $year + 4800 - $a;
		$month = $month + 12 * $a - 3;

		return $day + (int)((153 * $month + 2) / 5) + 365 * $year + (int)($year / 4) - 32083;
	}
}