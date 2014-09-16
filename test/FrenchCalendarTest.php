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
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$french = new FrenchCalendar;

		$this->assertSame($french::PHP_CALENDAR_NAME, 'French');
		$this->assertSame($french::PHP_CALENDAR_NUMBER, CAL_FRENCH);
		$this->assertSame($french::GEDCOM_CALENDAR_ESCAPE, '@#DFRENCH R@');
	}

	/**
	 * Test the PHP calendar information function.
	 *
	 * @covers Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 * @covers Fisharebest\ExtCalendar\FrenchCalendar::monthNames
	 * @covers Fisharebest\ExtCalendar\Calendar::monthNamesAbbreviated
	 *
	 * @return void
	 */
	public function testPhpCalInfo() {
		$french = new FrenchCalendar;

		$this->assertSame($french->phpCalInfo(), \cal_info($french::PHP_CALENDAR_NUMBER));
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers Fisharebest\ExtCalendar\FrenchCalendar::leapYear
	 *
	 * @return void
	 */
	public function testLeapYear() {
		$french = new FrenchCalendar;

		$this->assertSame($french->leapYear(1), false);
		$this->assertSame($french->leapYear(2), false);
		$this->assertSame($french->leapYear(3), true);
		$this->assertSame($french->leapYear(4), false);
		$this->assertSame($french->leapYear(5), false);
		$this->assertSame($french->leapYear(6), false);
		$this->assertSame($french->leapYear(7), true);
		$this->assertSame($french->leapYear(8), false);
		$this->assertSame($french->leapYear(9), false);
		$this->assertSame($french->leapYear(10), false);
		$this->assertSame($french->leapYear(11), true);
		$this->assertSame($french->leapYear(12), false);
		$this->assertSame($french->leapYear(13), false);
		$this->assertSame($french->leapYear(14), false);
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
				$this->assertSame($french->daysInMonth($year, $month), \cal_days_in_month(CAL_FRENCH, $month, $year));
			}
		}
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
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		$french = new FrenchCalendar;

		foreach (array(3, 4) as $year) {
			for ($day = 1; $day <= 30; ++$day) {
				$jd = \FrenchToJD(8, $day, $year);
				$ymd = $french->jdToYmd($jd);

				$this->assertSame($french->ymdToJd($year, 8, $day), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToFrench($jd));
				$this->assertSame($french->calFromJd($jd), \cal_from_jd($jd, CAL_FRENCH));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		$french = new FrenchCalendar;

		for ($month=1; $month<=12; ++$month) {
			$jd = \FrenchToJD($month, 9, 5);
			$ymd = $french->jdToYmd($jd);

			$this->assertSame($french->ymdToJd(5, $month, 9), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToFrench($jd));
			$this->assertSame($french->calFromJd($jd), \cal_from_jd($jd, CAL_FRENCH));

			$jd = \FrenchToJD($month, 9, 5);
			$ymd = $french->jdToYmd($jd);

			$this->assertSame($french->ymdToJd(5, $month, 9), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToFrench($jd));
			$this->assertSame($french->calFromJd($jd), \cal_from_jd($jd, CAL_FRENCH));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\FrenchCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYears() {
		$french = new FrenchCalendar;

		for ($year=1; $year<=14; ++$year) {
			$jd = \FrenchToJD(8, 9, $year);
			$ymd = $french->jdToYmd($jd);

			$this->assertSame($french->ymdToJd($year, 8, 9), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \JDToFrench($jd));
			$this->assertSame($french->calFromJd($jd), \cal_from_jd($jd, CAL_FRENCH));
		}
	}

	/**
	 * Test the implementation of French::calInfo() against \cal_info()
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 *
	 * @return void
	 */
	public function testCalInfo() {
		$french = new FrenchCalendar;

		$this->assertSame($french->phpCalInfo(), cal_info(CAL_FRENCH));
	}
}
