<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class FrenchCalendar
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

class FrenchCalendarTest extends TestCase {
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
		$french = new FrenchCalendar;

		$this->assertSame($french::GEDCOM_CALENDAR_ESCAPE, '@#DFRENCH R@');
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers Fisharebest\ExtCalendar\FrenchCalendar::isLeapYear
	 *
	 * @return void
	 */
	public function testIsLeapYear() {
		$french = new FrenchCalendar;

		$this->assertSame($french->isLeapYear(1), false);
		$this->assertSame($french->isLeapYear(2), false);
		$this->assertSame($french->isLeapYear(3), true);
		$this->assertSame($french->isLeapYear(4), false);
		$this->assertSame($french->isLeapYear(5), false);
		$this->assertSame($french->isLeapYear(6), false);
		$this->assertSame($french->isLeapYear(7), true);
		$this->assertSame($french->isLeapYear(8), false);
		$this->assertSame($french->isLeapYear(9), false);
		$this->assertSame($french->isLeapYear(10), false);
		$this->assertSame($french->isLeapYear(11), true);
		$this->assertSame($french->isLeapYear(12), false);
		$this->assertSame($french->isLeapYear(13), false);
		$this->assertSame($french->isLeapYear(14), false);
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonth() {
		$french = new FrenchCalendar;

		// Cannot test year 14 against PHP, due to PHP bug 67976.
		for ($year = 1; $year <= 13; ++$year) {
			for ($month = 1; $month <= 13; ++$month) {
				$this->assertSame($french->daysInMonth($year, $month), cal_days_in_month(CAL_FRENCH, $month, $year));
			}
		}
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Month 0 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthMonthZero() {
		$french = new FrenchCalendar;

		$french->daysInMonth(9, 0);
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Month 14 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthMonthFourteen() {
		$french = new FrenchCalendar;

		$french->daysInMonth(9, 14);
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Year 0 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthYearZero() {
		$french = new FrenchCalendar;

		$french->daysInMonth(0, 6);
	}

	/**
	 * Test the conversion of calendar dates into Julian days.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdTojd() {
		$french = new FrenchCalendar;

		$this->assertSame($french->ymdToJd(1, 1, 1), 2375840);
		$this->assertSame($french->ymdToJd(14, 13, 5), 2380952);

		$this->assertSame($french->jdToYmd(2375840), array(1, 1, 1));
		$this->assertSame($french->jdToYmd(2380952), array(14, 13, 5));
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		$french = new FrenchCalendar;

		foreach (array(3, 4) as $year) {
			for ($day = 1; $day <= 30; ++$day) {
				$julian_day = FrenchToJD(8, $day, $year);
				$ymd = $french->jdToYmd($julian_day);

				$this->assertSame($french->ymdToJd($year, 8, $day), $julian_day);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToFrench($julian_day));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		$french = new FrenchCalendar;

		for ($month=1; $month<=12; ++$month) {
			$julian_day = FrenchToJD($month, 9, 5);
			$ymd = $french->jdToYmd($julian_day);

			$this->assertSame($french->ymdToJd(5, $month, 9), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToFrench($julian_day));

			$julian_day = FrenchToJD($month, 9, 5);
			$ymd = $french->jdToYmd($julian_day);

			$this->assertSame($french->ymdToJd(5, $month, 9), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToFrench($julian_day));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYears() {
		$french = new FrenchCalendar;

		for ($year=1; $year<=14; ++$year) {
			$julian_day = FrenchToJD(8, 9, $year);
			$ymd = $french->jdToYmd($julian_day);

			$this->assertSame($french->ymdToJd($year, 8, 9), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToFrench($julian_day));
		}
	}
}
