<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class GregorianCalendar
 *
 * @package   fisharebest/ExtCalendar
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2014 webtrees development team
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

class GregorianCalendarTest extends TestCase {
	/**
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$gregorian = new GregorianCalendar;

		$this->assertSame($gregorian::PHP_CALENDAR_NAME, 'Gregorian');
		$this->assertSame($gregorian::PHP_CALENDAR_NUMBER, CAL_GREGORIAN);
	}

	/**
	 * Test the PHP calendar information function.
	 *
	 * @covers Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 * @covers Fisharebest\ExtCalendar\GregorianCalendar::monthNames
	 * @covers Fisharebest\ExtCalendar\Calendar::monthNamesAbbreviated
	 *
	 * @return void
	 */
	public function testPhpCalInfo() {
		$gregorian = new GregorianCalendar;

		$this->assertSame($gregorian->phpCalInfo(), \cal_info($gregorian::PHP_CALENDAR_NUMBER));
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::leapYear
	 *
	 * @return void
	 */
	public function testLeapYear() {
		$gregorian = new GregorianCalendar;

		$this->assertSame($gregorian->leapYear(-5), true);
		$this->assertSame($gregorian->leapYear(-4), false);
		$this->assertSame($gregorian->leapYear(-3), false);
		$this->assertSame($gregorian->leapYear(-2), false);
		$this->assertSame($gregorian->leapYear(-1), true);
		$this->assertSame($gregorian->leapYear(1500), false);
		$this->assertSame($gregorian->leapYear(1600), true);
		$this->assertSame($gregorian->leapYear(1700), false);
		$this->assertSame($gregorian->leapYear(1800), false);
		$this->assertSame($gregorian->leapYear(1900), false);
		$this->assertSame($gregorian->leapYear(1999), false);
		$this->assertSame($gregorian->leapYear(2000), true);
		$this->assertSame($gregorian->leapYear(2001), false);
		$this->assertSame($gregorian->leapYear(2002), false);
		$this->assertSame($gregorian->leapYear(2003), false);
		$this->assertSame($gregorian->leapYear(2004), true);
		$this->assertSame($gregorian->leapYear(2005), false);
		$this->assertSame($gregorian->leapYear(2100), false);
		$this->assertSame($gregorian->leapYear(2200), false);
	}

	/**
	 * Test the calculation of Easter against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::easterDays
	 *
	 * @return void
	 */
	public function testEasterDaysCoverage() {
		$gregorian = new GregorianCalendar;

		foreach (array(2037, 2035, 2030, 1981, 1894, 1875, -1, -2, -3, -15, -19, -34, -53, -1712, -1788) as $year) {
			$this->assertSame($gregorian->easterDays($year), \easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN));
		}
	}

	/**
	 * Test the calculation of Easter against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::easterDays
	 *
	 * @return void
	 */
	public function testEasterDaysModernTimes() {
		$gregorian = new GregorianCalendar;

		for ($year = 1970; $year <= 2037; ++$year) {
			$this->assertSame($gregorian->easterDays($year), \easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN));
		}
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonth() {
		$gregorian = new GregorianCalendar;

		foreach (array(-5, -4, -1, 1, 1500, 1600, 1700, 1800, 1900, 1999, 2000, 2001, 2002, 2003, 2004, 2005, 2100, 2200) as $year) {
			for ($month = 1; $month <= 12; ++$month) {
				$this->assertSame($gregorian->daysInMonth($year, $month), \cal_days_in_month(CAL_GREGORIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		$gregorian = new GregorianCalendar;

		foreach (array(2012, 2014) as $year) {
			for ($day = 1; $day <= 28; ++$day) {
				$jd = \GregorianToJD(8, $day, $year);
				$ymd = $gregorian->jdToYmd($jd);

				$this->assertSame($gregorian->ymdToJd($year, 8, $day), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToGregorian($jd));
				$this->assertSame($gregorian->calFromJd($jd), \cal_from_jd($jd, CAL_GREGORIAN));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		$gregorian = new GregorianCalendar;

		foreach (array(2012, 2014) as $year) {
			for ($month=1; $month<=12; ++$month) {
				$jd = \GregorianToJD($month, 9, $year);
				$ymd = $gregorian->jdToYmd($jd);

				$this->assertSame($gregorian->ymdToJd($year, $month, 9), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToGregorian($jd));
				$this->assertSame($gregorian->calFromJd($jd), \cal_from_jd($jd, CAL_GREGORIAN));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYears() {
		$gregorian = new GregorianCalendar;

		for ($year=1970; $year<=2037; ++$year) {
			$jd = \GregorianToJD(8, 9, $year);
			$ymd = $gregorian->jdToYmd($jd);

			$this->assertSame($gregorian->ymdToJd($year, 8, 9), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToGregorian($jd));
			$this->assertSame($gregorian->calFromJd($jd), \cal_from_jd($jd, CAL_GREGORIAN));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYearsBc() {
		$gregorian = new GregorianCalendar;

		for ($year=-5; $year<=5; ++$year) {
			if ($year != 0) {
				$jd = \GregorianToJD(1, 1, $year);
				$ymd = $gregorian->jdToYmd($jd);

				$this->assertSame($gregorian->ymdToJd($year, 1, 1), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToGregorian($jd));
				$this->assertSame($gregorian->calFromJd($jd), \cal_from_jd($jd, CAL_GREGORIAN));

				$jd = \GregorianToJD(12, 31, $year);
				$ymd = $gregorian->jdToYmd($jd);

				$this->assertSame($gregorian->ymdToJd($year, 12, 31), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToGregorian($jd));
				$this->assertSame($gregorian->calFromJd($jd), \cal_from_jd($jd, CAL_GREGORIAN));
			}
		}
	}

	/**
	 * Test the implementation of Gregorian::calInfo() against \cal_info()
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 *
	 * @return void
	 */
	public function testCalInfo() {
		$gregorian = new GregorianCalendar;

		$this->assertSame($gregorian->phpCalInfo(), cal_info(CAL_GREGORIAN));
	}

///////////////////////////////////////////////////////

	/**
	 * To iterate over large ranges of test data, use a prime-number interval to
	 * avoid any synchronisation problems.
	 */
	const LARGE_PRIME = 235741;

	/**
	 * Test the implementation of Gregorian::jDMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthName() {
		$gregorian = new GregorianCalendar;

		$start_jd = 1; // 25 November 4715 B.C.E.
		$end_jd = 5373484; // 31 December 9999

		for ($jd = $start_jd; $jd <= $end_jd; $jd += static::LARGE_PRIME) {
			$this->assertSame($gregorian->jDMonthName($jd), \JDMonthName($jd, CAL_MONTH_GREGORIAN_LONG));
		}
	}

	/**
	 * Test the implementation of Gregorian::jDMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameAbbreviated() {
		$gregorian = new GregorianCalendar;

		$start_jd = 1; // 25 November 4715 B.C.E.
		$end_jd = 5373484; // 31 December 9999

		for ($jd = $start_jd; $jd <= $end_jd; $jd += static::LARGE_PRIME) {
			$this->assertSame($gregorian->jDMonthNameAbbreviated($jd), \JDMonthName($jd, CAL_MONTH_GREGORIAN_SHORT));
		}
	}
}
