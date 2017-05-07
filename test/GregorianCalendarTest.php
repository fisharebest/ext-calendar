<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit\Framework\TestCase;

/**
 * Test harness for the class GregorianCalendar
 *
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2014-2015 webtrees development team
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
	 * Create the shim functions, so we can run tests on servers which do
	 * not have the ext/calendar library installed.  For example HHVM.
	 *
	 * @return void
	 */
	public function setUp() {
		Shim::create();
	}

	/**
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$calendar = new GregorianCalendar;

		$this->assertSame('@#DGREGORIAN@', $calendar->gedcomCalendarEscape());
		$this->assertSame(1, $calendar->jdStart());
		$this->assertSame(PHP_INT_MAX, $calendar->jdEnd());
		$this->assertSame(7, $calendar->daysInWeek());
		$this->assertSame(12, $calendar->monthsInYear());
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::isLeapYear
	 *
	 * @return void
	 */
	public function testIsLeapYear() {
		$gregorian = new GregorianCalendar;

		$this->assertSame($gregorian->isLeapYear(-5), true);
		$this->assertSame($gregorian->isLeapYear(-4), false);
		$this->assertSame($gregorian->isLeapYear(-3), false);
		$this->assertSame($gregorian->isLeapYear(-2), false);
		$this->assertSame($gregorian->isLeapYear(-1), true);
		$this->assertSame($gregorian->isLeapYear(1500), false);
		$this->assertSame($gregorian->isLeapYear(1600), true);
		$this->assertSame($gregorian->isLeapYear(1700), false);
		$this->assertSame($gregorian->isLeapYear(1800), false);
		$this->assertSame($gregorian->isLeapYear(1900), false);
		$this->assertSame($gregorian->isLeapYear(1999), false);
		$this->assertSame($gregorian->isLeapYear(2000), true);
		$this->assertSame($gregorian->isLeapYear(2001), false);
		$this->assertSame($gregorian->isLeapYear(2002), false);
		$this->assertSame($gregorian->isLeapYear(2003), false);
		$this->assertSame($gregorian->isLeapYear(2004), true);
		$this->assertSame($gregorian->isLeapYear(2005), false);
		$this->assertSame($gregorian->isLeapYear(2100), false);
		$this->assertSame($gregorian->isLeapYear(2200), false);
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
			$this->assertSame($gregorian->easterDays($year), easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN));
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
			$this->assertSame($gregorian->easterDays($year), easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN));
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
				$this->assertSame($gregorian->daysInMonth($year, $month), cal_days_in_month(CAL_GREGORIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		$gregorian = new GregorianCalendar;

		foreach (array(2012, 2014) as $year) {
			for ($day = 1; $day <= 28; ++$day) {
				$julian_day = GregorianToJD(8, $day, $year);
				$ymd = $gregorian->jdToYmd($julian_day);

				$this->assertSame($gregorian->ymdToJd($year, 8, $day), $julian_day);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToGregorian($julian_day));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		$gregorian = new GregorianCalendar;

		foreach (array(2012, 2014) as $year) {
			for ($month=1; $month<=12; ++$month) {
				$julian_day = GregorianToJD($month, 9, $year);
				$ymd = $gregorian->jdToYmd($julian_day);

				$this->assertSame($gregorian->ymdToJd($year, $month, 9), $julian_day);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToGregorian($julian_day));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYears() {
		$gregorian = new GregorianCalendar;

		for ($year=1970; $year<=2037; ++$year) {
			$julian_day = GregorianToJD(8, 9, $year);
			$ymd = $gregorian->jdToYmd($julian_day);

			$this->assertSame($gregorian->ymdToJd($year, 8, 9), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToGregorian($julian_day));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYearsBc() {
		$gregorian = new GregorianCalendar;

		for ($year=-5; $year<=5; ++$year) {
			if ($year != 0) {
				$julian_day = GregorianToJD(1, 1, $year);
				$ymd = $gregorian->jdToYmd($julian_day);

				$this->assertSame($gregorian->ymdToJd($year, 1, 1), $julian_day);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToGregorian($julian_day));

				$julian_day = GregorianToJD(12, 31, $year);
				$ymd = $gregorian->jdToYmd($julian_day);

				$this->assertSame($gregorian->ymdToJd($year, 12, 31), $julian_day);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToGregorian($julian_day));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days, and vice versa, returns the same result.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testJdToYmdReciprocity() {
		$calendar = new GregorianCalendar;

		for ($jd = $calendar->jdStart(); $jd < min(2457755, $calendar->jdEnd()); $jd += 79) {
			list($y, $m, $d) = $calendar->jdToYmd($jd);
			$this->assertSame($jd, $calendar->ymdToJd($y, $m, $d));
		}
	}

	/**
	 * Test the conversion of a YMD date to JD when the month is not a valid number.
	 *
	 * @covers \Fisharebest\ExtCalendar\GregorianCalendar::ymdToJd
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Month 14 is invalid for this calendar
	 */
	public function testYmdToJdInvalidMonth() {
		$calendar = new ArabicCalendar;
		$calendar->ymdToJd(4, 14, 1);
	}
}
