<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class JulianCalendar
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

class JulianCalendarTest extends TestCase {
	/**
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$julian = new JulianCalendar;

		$this->assertSame($julian::PHP_CALENDAR_NAME, 'Julian');
		$this->assertSame($julian::PHP_CALENDAR_NUMBER, CAL_JULIAN);
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::leapYear
	 *
	 * @return void
	 */
	public function testLeapYear() {
		$julian = new JulianCalendar;

		$this->assertSame($julian->leapYear(1500), true);
		$this->assertSame($julian->leapYear(1600), true);
		$this->assertSame($julian->leapYear(1700), true);
		$this->assertSame($julian->leapYear(1800), true);
		$this->assertSame($julian->leapYear(1900), true);
		$this->assertSame($julian->leapYear(1999), false);
		$this->assertSame($julian->leapYear(2000), true);
		$this->assertSame($julian->leapYear(2001), false);
		$this->assertSame($julian->leapYear(2002), false);
		$this->assertSame($julian->leapYear(2003), false);
		$this->assertSame($julian->leapYear(2004), true);
		$this->assertSame($julian->leapYear(2005), false);
		$this->assertSame($julian->leapYear(2100), true);
		$this->assertSame($julian->leapYear(2200), true);
	}

	/**
	 * Test the calculation of Easter against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::easterDays
	 *
	 * @return void
	 */
	public function testEasterDaysCoverage() {
		$julian = new JulianCalendar;

		foreach (array(2037, 2036, 2029, 1972, -4, -5, -9, -19, -20, -23, -175) as $year) {
			$this->assertSame($julian->easterDays($year), \easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
		}
	}

	/**
	 * Test the calculation of Easter against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::easterDays
	 *
	 * @return void
	 */
	public function testEasterDaysModernTimes() {
		$julian = new JulianCalendar;

		for ($year = 1970; $year <= 2037; ++$year) {
			$this->assertSame($julian->easterDays($year), \easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
		}
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonth() {
		$julian = new JulianCalendar;

		foreach (array(-5, -4, -1, 1, 1500, 1600, 1700, 1800, 1900, 1999, 2000, 2001, 2002, 2003, 2004, 2005, 2100, 2200) as $year) {
			for ($month = 1; $month <= 12; ++$month) {
				$this->assertSame($julian->daysInMonth($year, $month), \cal_days_in_month(CAL_JULIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		$julian = new JulianCalendar;

		foreach (array(2012, 2014) as $year) {
			for ($day = 1; $day <= 28; ++$day) {
				$jd = \JulianToJD(8, $day, $year);
				$ymd = $julian->jdToYmd($jd);

				$this->assertSame($julian->ymdToJd($year, 8, $day), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToJulian($jd));
				$this->assertSame($julian->calFromJd($jd), \cal_from_jd($jd, CAL_JULIAN));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		$julian = new JulianCalendar;

		for ($month=1; $month<=12; ++$month) {
			foreach (array(2012, 2014) as $year) {
				$jd = \JulianToJD($month, 9, $year);
				$ymd = $julian->jdToYmd($jd);

				$this->assertSame($julian->ymdToJd($year, $month, 9), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToJulian($jd));
				$this->assertSame($julian->calFromJd($jd), \cal_from_jd($jd, CAL_JULIAN));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYears() {
		$julian = new JulianCalendar;

		for ($year=1970; $year<=2037; ++$year) {
			$jd = \JulianToJD(8, 9, $year);
			$ymd = $julian->jdToYmd($jd);

			$this->assertSame($julian->ymdToJd($year, 8, 9), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToJulian($jd));
			$this->assertSame($julian->calFromJd($jd), \cal_from_jd($jd, CAL_JULIAN));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYearsBc() {
		$julian = new JulianCalendar;

		for ($year=-5; $year<=5; ++$year) {
			if ($year != 0) {
				$jd = \JulianToJD(1, 1, $year);
				$ymd = $julian->jdToYmd($jd);

				$this->assertSame($julian->ymdToJd($year, 1, 1), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToJulian($jd));
				$this->assertSame($julian->calFromJd($jd), \cal_from_jd($jd, CAL_JULIAN));

				$jd = \JulianToJD(12, 31, $year);
				$ymd = $julian->jdToYmd($jd);

				$this->assertSame($julian->ymdToJd($year, 12, 31), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToJulian($jd));
				$this->assertSame($julian->calFromJd($jd), \cal_from_jd($jd, CAL_JULIAN));
			}
		}
	}

	/**
	 * Test the implementation of Julian::calInfo() against \cal_info()
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 *
	 * @return void
	 */
	public function testCalInfo() {
		$julian = new JulianCalendar;

		$this->assertSame($julian->phpCalInfo(), cal_info(CAL_JULIAN));
	}

/////////////////////////////////////////////////////////

	/**
	 * To iterate over large ranges of test data, use a prime-number interval to
	 * avoid any synchronisation problems.
	 */
	const LARGE_PRIME = 235741;

	/**
	 * Test the implementation of Julian::jDMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthName() {
		$julian = new JulianCalendar;

		$start_jd = 1; // 25 November 4715 B.C.E.
		$end_jd = 5373484; // 31 December 9999

		for ($jd = $start_jd; $jd <= $end_jd; $jd += static::LARGE_PRIME) {
			$this->assertSame($julian->jDMonthName($jd), \JDMonthName($jd, CAL_MONTH_JULIAN_LONG));
		}
	}

	/**
	 * Test the implementation of Julian::jDMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameAbbreviated() {
		$julian = new JulianCalendar;

		$start_jd = 1; // 25 November 4715 B.C.E.
		$end_jd = 5373484; // 31 December 9999

		for ($jd = $start_jd; $jd <= $end_jd; $jd += static::LARGE_PRIME) {
			$this->assertSame($julian->jDMonthNameAbbreviated($jd), \JDMonthName($jd, CAL_MONTH_JULIAN_SHORT));
		}
	}
}
