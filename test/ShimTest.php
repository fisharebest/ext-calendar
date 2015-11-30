<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class Shim.
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
class ShimTest extends TestCase {
	// Use this many random dates to test date conversion functions.
	const ITERATIONS = 512;
	/**
	 * To iterate over large ranges of test data, use a prime-number interval to
	 * avoid any synchronisation problems.
	 */
	const LARGE_PRIME = 235741;

	/**
	 * Test that the shim defines all the necessary constants.
	 *
	 * @return void
	 */
	public function testConstantsExist() {
		$this->assertTrue(defined('CAL_GREGORIAN'));
		$this->assertTrue(defined('CAL_JULIAN'));
		$this->assertTrue(defined('CAL_JEWISH'));
		$this->assertTrue(defined('CAL_FRENCH'));
		$this->assertTrue(defined('CAL_NUM_CALS'));
		$this->assertTrue(defined('CAL_DOW_DAYNO'));
		$this->assertTrue(defined('CAL_DOW_SHORT'));
		$this->assertTrue(defined('CAL_DOW_LONG'));
		$this->assertTrue(defined('CAL_MONTH_GREGORIAN_SHORT'));
		$this->assertTrue(defined('CAL_MONTH_GREGORIAN_LONG'));
		$this->assertTrue(defined('CAL_MONTH_JULIAN_SHORT'));
		$this->assertTrue(defined('CAL_MONTH_JULIAN_LONG'));
		$this->assertTrue(defined('CAL_MONTH_JEWISH'));
		$this->assertTrue(defined('CAL_MONTH_FRENCH'));
		$this->assertTrue(defined('CAL_EASTER_DEFAULT'));
		$this->assertTrue(defined('CAL_EASTER_ROMAN'));
		$this->assertTrue(defined('CAL_EASTER_ALWAYS_GREGORIAN'));
		$this->assertTrue(defined('CAL_EASTER_ALWAYS_JULIAN'));
		$this->assertTrue(defined('CAL_JEWISH_ADD_ALAFIM_GERESH'));
		$this->assertTrue(defined('CAL_JEWISH_ADD_ALAFIM'));
		$this->assertTrue(defined('CAL_JEWISH_ADD_GERESHAYIM'));

		$this->assertSame(0, CAL_GREGORIAN);
		$this->assertSame(1, CAL_JULIAN);
		$this->assertSame(2, CAL_JEWISH);
		$this->assertSame(3, CAL_FRENCH);
		$this->assertSame(4, CAL_NUM_CALS);
		$this->assertSame(0, CAL_DOW_DAYNO);
		$this->assertSame(Shim::shouldEmulateBug67960() ? 1 : 2, CAL_DOW_SHORT);
		$this->assertSame(Shim::shouldEmulateBug67960() ? 2 : 1, CAL_DOW_LONG);
		$this->assertSame(0, CAL_MONTH_GREGORIAN_SHORT);
		$this->assertSame(1, CAL_MONTH_GREGORIAN_LONG);
		$this->assertSame(2, CAL_MONTH_JULIAN_SHORT);
		$this->assertSame(3, CAL_MONTH_JULIAN_LONG);
		$this->assertSame(4, CAL_MONTH_JEWISH);
		$this->assertSame(5, CAL_MONTH_FRENCH);
		$this->assertSame(0, CAL_EASTER_DEFAULT);
		$this->assertSame(1, CAL_EASTER_ROMAN);
		$this->assertSame(2, CAL_EASTER_ALWAYS_GREGORIAN);
		$this->assertSame(3, CAL_EASTER_ALWAYS_JULIAN);
		$this->assertSame(2, CAL_JEWISH_ADD_ALAFIM_GERESH);
		$this->assertSame(4, CAL_JEWISH_ADD_ALAFIM);
		$this->assertSame(8, CAL_JEWISH_ADD_GERESHAYIM);
	}

	/**
	 * Test that the shim defines all the necessary functions.
	 *
	 * @return void
	 */
	public function testFunctionsExist() {
		$this->assertTrue(function_exists('cal_days_in_month'));
		$this->assertTrue(function_exists('cal_from_jd'));
		$this->assertTrue(function_exists('cal_info'));
		$this->assertTrue(function_exists('easter_date'));
		$this->assertTrue(function_exists('easter_days'));
		$this->assertTrue(function_exists('FrenchToJD'));
		$this->assertTrue(function_exists('GregorianToJD'));
		$this->assertTrue(function_exists('JDDayOfWeek'));
		$this->assertTrue(function_exists('JDMonthName'));
		$this->assertTrue(function_exists('JDToFrench'));
		$this->assertTrue(function_exists('JDToGregorian'));
		$this->assertTrue(function_exists('jdtojewish'));
		$this->assertTrue(function_exists('JDToJulian'));
		$this->assertTrue(function_exists('jdtounix'));
		$this->assertTrue(function_exists('JewishToJD'));
		$this->assertTrue(function_exists('JulianToJD'));
		$this->assertTrue(function_exists('unixtojd'));
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @return void
	 */
	public function testCalDaysInMonthFrench() {
		foreach (array(3, 4) as $year) {
			foreach (array(1, 12, 13) as $month) {
				$this->assertSame(Shim::calDaysInMonth(CAL_FRENCH, $month, $year), cal_days_in_month(CAL_FRENCH, $month, $year));
			}
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @return void
	 */
	public function testCalDaysInMonthFrenchBug67976() {
		$this->assertSame(Shim::calDaysInMonth(CAL_FRENCH, 13, 14), cal_days_in_month(CAL_FRENCH, 13, 14));
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchInvalidMonth1() {
		Shim::calDaysInMonth(CAL_FRENCH, 14, 10);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchInvalidMonth2() {
		cal_days_in_month(CAL_FRENCH, 14, 10);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchZeroYear1() {
		Shim::calDaysInMonth(CAL_FRENCH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchZeroYear2() {
		cal_days_in_month(CAL_FRENCH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchNegativeYear1() {
		Shim::calDaysInMonth(CAL_FRENCH, 1, -1);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchNegativeYear2() {
		cal_days_in_month(CAL_FRENCH, 1, -1);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchHighYear1() {
		Shim::calDaysInMonth(CAL_FRENCH, 1, 15);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchHighYear2() {
		cal_days_in_month(CAL_FRENCH, 1, 15);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testCalDaysInMonthGregorian() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(-4713, 9999);
			$month = mt_rand(1, 12);
			if ($year != 0) {
				$this->assertSame(Shim::calDaysInMonth(CAL_GREGORIAN, $month, $year), cal_days_in_month(CAL_GREGORIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidMonth1() {
		Shim::calDaysInMonth(CAL_GREGORIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidMonth2() {
		cal_days_in_month(CAL_GREGORIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidYear1() {
		Shim::calDaysInMonth(CAL_GREGORIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidYear2() {
		cal_days_in_month(CAL_GREGORIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testCalDaysInMonthJulian() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(-4713, 9999);
			$month = mt_rand(1, 12);
			if ($year != 0) {
				$this->assertSame(Shim::calDaysInMonth(CAL_GREGORIAN, $month, $year), cal_days_in_month(CAL_GREGORIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testCalDaysInMonthJewish() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(1, 6000);
			$month = mt_rand(1, 13);
			$this->assertSame(Shim::calDaysInMonth(CAL_JEWISH, $month, $year), cal_days_in_month(CAL_JEWISH, $month, $year));
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidMonth1() {
		Shim::calDaysInMonth(CAL_JEWISH, 14, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidMonth2() {
		cal_days_in_month(CAL_JEWISH, 14, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidYear1() {
		Shim::calDaysInMonth(CAL_JEWISH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidYear2() {
		cal_days_in_month(CAL_JEWISH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidMonth1() {
		Shim::calDaysInMonth(CAL_JULIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidMonth2() {
		cal_days_in_month(CAL_JULIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidYear1() {
		Shim::calDaysInMonth(CAL_JULIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidYear2() {
		cal_days_in_month(CAL_JULIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalDaysInMonthInvalidCalendar1() {
		Shim::calDaysInMonth(999, 1, 1);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against cal_days_in_month()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalDaysInMonthInvalidCalendar2() {
		cal_days_in_month(999, 1, 1);
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @return void
	 */
	public function testCalFromJdFrench() {
		// 0/0/0
		$this->assertSame(cal_from_jd(2375839, CAL_FRENCH), Shim::calFromJd(2375839, CAL_FRENCH));
		// 1/1/1
		$this->assertSame(cal_from_jd(2375840, CAL_FRENCH), Shim::calFromJd(2375840, CAL_FRENCH));
		// 13/5/14
		$this->assertSame(cal_from_jd(2380952, CAL_FRENCH), Shim::calFromJd(2380952, CAL_FRENCH));
		// 0/0/0
		$this->assertSame(cal_from_jd(2380953, CAL_FRENCH), Shim::calFromJd(2380953, CAL_FRENCH));
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @return void
	 */
	public function testCalFromJdGregorian() {
		// 0/0/0
		$this->assertSame(cal_from_jd(0, CAL_GREGORIAN), Shim::calFromJd(0, CAL_GREGORIAN));
		// 11/25/-4714
		$this->assertSame(cal_from_jd(1, CAL_GREGORIAN), Shim::calFromJd(1, CAL_GREGORIAN));
		// 12/31/-1
		$this->assertSame(cal_from_jd(1721425, CAL_GREGORIAN), Shim::calFromJd(1721425, CAL_GREGORIAN));
		// 1/1/1
		$this->assertSame(cal_from_jd(1721426, CAL_GREGORIAN), Shim::calFromJd(1721426, CAL_GREGORIAN));
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @return void
	 */
	public function testCalFromJdJewish() {
		// 0/0/0
		$this->assertSame(cal_from_jd(347997, CAL_JEWISH), Shim::calFromJd(347997, CAL_JEWISH));
		// 1/1/1
		$this->assertSame(cal_from_jd(347998, CAL_JEWISH), Shim::calFromJd(347998, CAL_JEWISH));
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @return void
	 */
	public function testCalFromJdJulian() {
		// 0/0/0
		$this->assertSame(cal_from_jd(0, CAL_JULIAN), Shim::calFromJd(0, CAL_JULIAN));
		// 1/2/-4713
		$this->assertSame(cal_from_jd(1, CAL_JULIAN), Shim::calFromJd(1, CAL_JULIAN));
		// 12/31/-1
		$this->assertSame(cal_from_jd(1721423, CAL_JULIAN), Shim::calFromJd(1721423, CAL_JULIAN));
		// 1/1/1
		$this->assertSame(cal_from_jd(1721424, CAL_JULIAN), Shim::calFromJd(1721424, CAL_JULIAN));
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalFromJdInvalidCalendar1() {
		Shim::calFromJd(2345678, 999);
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalFromJdInvalidCalendar2() {
		cal_from_jd(2345678, 999);
	}

	/**
	 * Test the implementation of Shim::calInfo() against cal_info()
	 *
	 * @return void
	 */
	public function testCalInfo() {
		$this->assertSame(Shim::calInfo(CAL_FRENCH),    cal_info(CAL_FRENCH));
		$this->assertSame(Shim::calInfo(CAL_GREGORIAN), cal_info(CAL_GREGORIAN));
		$this->assertSame(Shim::calInfo(CAL_JEWISH),    cal_info(CAL_JEWISH));
		$this->assertSame(Shim::calInfo(CAL_JULIAN),    cal_info(CAL_JULIAN));
	}

	/**
	 * Test the implementation of Shim::calInfo() against cal_info()
	 *
	 * @return void
	 */
	public function testCalInfoAll() {
		$this->assertSame(Shim::calInfo(-1), cal_info(-1));
	}

	/**
	 * Test the implementation of Shim::calInfo() against cal_info()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalInfoInvalid1() {
		Shim::calInfo(999);
	}

	/**
	 * Test the implementation of Shim::calInfo() against cal_info()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalInfoInvalid2() {
		cal_info(999);
	}

	/**
	 * Test the implementation of Shim::calToJd() against cal_to_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalToJdInvalidCalendar1() {
		Shim::calToJd(999, 1, 1, 1);
	}

	/**
	 * Test the implementation of Shim::calToJd() against cal_to_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalToJdInvalidCalendar2() {
		cal_to_jd(999, 1, 1, 1);
	}

	/**
	 * Test the implementation of Shim::easterDate() against easter_date()
	 *
	 * @return void
	 */
	public function testEasterDate() {
		$this->assertSame(Shim::easterDate(2013), easter_date(2013));
		$this->assertSame(Shim::easterDate(2014), easter_date(2014));
	}

	/**
	 * Test the implementation of Shim::easterDate() against easter_date()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage This function is only valid for years between 1970 and 2037 inclusive
	 *
	 * @return void
	 */
	public function testEasterDateHighYear1() {
		Shim::easterDate(2038);
	}

	/**
	 * Test the implementation of Shim::easterDate() against easter_date()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage This function is only valid for years between 1970 and 2037 inclusive
	 *
	 * @return void
	 */
	public function testEasterDateHighYear2() {
		easter_date(2038);
	}

	/**
	 * Test the implementation of Shim::easterDate() against easter_date()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage This function is only valid for years between 1970 and 2037 inclusive
	 *
	 * @return void
	 */
	public function testEasterDateLowYear1() {
		Shim::easterDate(1969);
	}

	/**
	 * Test the implementation of Shim::easterDate() against easter_date()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage This function is only valid for years between 1970 and 2037 inclusive
	 *
	 * @return void
	 */
	public function testEasterDateLowYear2() {
		easter_date(1969);
	}

	/**
	 * Test the implementation of Shim::easterDays() against easter_days()
	 *
	 * @return void
	 */
	public function testEasterDays() {
		foreach (array(-4, 1751, 1752, 1753, 1581, 1582, 1583) as $year) {
			$this->assertSame(Shim::easterDays($year, 999), easter_days($year, 999));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_DEFAULT), easter_days($year, CAL_EASTER_DEFAULT));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_ROMAN), easter_days($year, CAL_EASTER_ROMAN));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_ALWAYS_GREGORIAN), easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_ALWAYS_JULIAN), easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
		}
	}

	/**
	 * Test the implementation of Shim::frenchToJd() against FrenchToJd()
	 * Test the implementation of Shim::calToJd() against cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testFrenchToJd() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(1, 14);
			$month = mt_rand(1, 13);
			$day = mt_rand(1, $month == 13 ? 6 : 28);

			$this->assertSame(Shim::frenchToJd($month, $day, $year), FrenchToJd($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_FRENCH, $month, $day, $year), cal_to_jd(CAL_FRENCH, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::frenchToJd() against FrenchToJd()
	 *
	 * @return void
	 */
	public function testFrenchToJdOutOfRange() {
		$this->assertSame(Shim::frenchToJd(1, 1, 0), FrenchToJd(1, 1, 0));
	}

	/**
	 * Test the implementation of Shim::gregorianToJd() against GregorianToJD()
	 * Test the implementation of Shim::calToJd() against cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testGregorianToJD() {
		$this->assertSame(Shim::gregorianToJd(1, 1, 0), GregorianToJD(1, 1, 0));

		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(-4713, 9999);
			$month = mt_rand(1, 12);
			$day = mt_rand(1, 30);

			$this->assertSame(Shim::gregorianToJd($month, $day, $year), GregorianToJD($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_GREGORIAN, $month, $day, $year), cal_to_jd(CAL_GREGORIAN, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekSunday() {
		$julian_day = GregorianToJD(8, 31, 2014);

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), 'Sunday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), 'Sun');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 0);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Sun' : 'Sunday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Sunday' : 'Sun');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekMonday() {
		$julian_day = GregorianToJD(9, 1, 2014); // 2456902

		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 1);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Mon' : 'Monday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Monday' : 'Mon');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekTuesday() {
		$julian_day = GregorianToJD(9, 2, 2014); // 2456903

		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 2);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Tue' : 'Tuesday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Tuesday' : 'Tue');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekWednesday() {
		$julian_day = GregorianToJD(9, 3, 2014); // 2456904

		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 3);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Wed' : 'Wednesday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Wednesday' : 'Wed');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekThursday() {
		$julian_day = GregorianToJD(9, 4, 2014); // 2456905

		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 4);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Thu' : 'Thursday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Thursday' : 'Thu');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekFriday() {
		$julian_day = GregorianToJD(9, 5, 2014); // 2456906

		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 5);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Fri' : 'Friday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Friday' : 'Fri');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekSaturday() {
		$julian_day = GregorianToJD(9, 6, 2014); // 2456907

		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_DAYNO), 6);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_LONG), Shim::shouldEmulateBug67960() ? 'Sat' : 'Saturday');
		$this->assertSame(Shim::jdDayOfWeek($julian_day, CAL_DOW_SHORT), Shim::shouldEmulateBug67960() ? 'Saturday' : 'Sat');

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 0), JDDayOfWeek($julian_day, 0));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 1), JDDayOfWeek($julian_day, 1));
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 2), JDDayOfWeek($julian_day, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @return void
	 */
	public function testJdDayOfWeekNegative() {
		$this->assertSame(Shim::jdDayOfWeek(-2, 0), 6);
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against JDDayOfWeek()
	 *
	 * @return void
	 */
	public function testJdDayOfWeekInvalidMode() {
		$julian_day = GregorianToJD(8, 31, 2014); // 2456901

		$this->assertSame(Shim::jdDayOfWeek($julian_day, 999), 0);
		$this->assertSame(Shim::jdDayOfWeek($julian_day, 999), JDDayOfWeek($julian_day, 999));
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameFrench() {
		for ($month=1; $month <= 13; ++$month) {
			$julian_day = FrenchToJD($month, 1, 10);
			$this->assertSame(Shim::jdMonthName($julian_day, CAL_MONTH_FRENCH), JDMonthName($julian_day, CAL_MONTH_FRENCH));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameGregorian() {
		for ($month=1; $month <= 12; ++$month) {
			$julian_day = GregorianToJD($month, 1, 2014);
			$this->assertSame(Shim::jdMonthName($julian_day, CAL_MONTH_GREGORIAN_LONG), JDMonthName($julian_day, CAL_MONTH_GREGORIAN_LONG));
			$this->assertSame(Shim::jdMonthName($julian_day, CAL_MONTH_GREGORIAN_SHORT), JDMonthName($julian_day, CAL_MONTH_GREGORIAN_SHORT));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameJewish() {
		// Both leap and non-leap years
		foreach (array(5000, 5001) as $year) {
			for ($month = 1; $month <= 13; ++$month) {
				$julian_day = JewishToJD($month, 1, $year);
				$this->assertSame(Shim::jdMonthName($julian_day, CAL_MONTH_JEWISH), JDMonthName($julian_day, CAL_MONTH_JEWISH));
			}
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameJulian() {
		for ($month=1; $month <= 12; ++$month) {
			$julian_day = JulianToJD($month, 1, 2014);
			$this->assertSame(Shim::jdMonthName($julian_day, CAL_MONTH_JULIAN_LONG), JDMonthName($julian_day, CAL_MONTH_JULIAN_LONG));
			$this->assertSame(Shim::jdMonthName($julian_day, CAL_MONTH_JULIAN_SHORT), JDMonthName($julian_day, CAL_MONTH_JULIAN_SHORT));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameInvalidMode() {
		$julian_day = JulianToJD(1, 1, 2014);

		$this->assertSame(Shim::jdMonthName($julian_day, 999), 'Jan');
		$this->assertSame(Shim::jdMonthName($julian_day, 999), JDMonthName($julian_day, 999));
	}

	/**
	 * Test the implementation of Shim::jdToFrench() against JDToFrench()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToFrench() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$julian_day = mt_rand(GregorianToJD(9, 22, 1792), GregorianToJD(9, 22, 1806));
			$this->assertSame(Shim::jdToFrench($julian_day), JDToFrench($julian_day));
			$this->assertSame(Shim::calFromJd($julian_day, CAL_FRENCH), cal_from_jd($julian_day, CAL_FRENCH));
		}
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 * Test the implementation of Shim::jdToFrench() against JDToFrench()
	 *
	 * @return void
	 */
	public function testJdToFrenchEdgeCases() {
		$this->assertSame(cal_from_jd(2375839, CAL_FRENCH), Shim::calFromJd(2375839, CAL_FRENCH));
		$this->assertSame('0/0/0', Shim::jdToFrench(2375839));
		$this->assertSame('0/0/0', JDToFrench(2375839));

		$this->assertSame(cal_from_jd(2375840, CAL_FRENCH), Shim::calFromJd(2375840, CAL_FRENCH));
		$this->assertSame('1/1/1', Shim::jdToFrench(2375840));
		$this->assertSame('1/1/1', JDToFrench(2375840));

		$this->assertSame(cal_from_jd(2380952, CAL_FRENCH), Shim::calFromJd(2380952, CAL_FRENCH));
		$this->assertSame('13/5/14', Shim::jdToFrench(2380952));
		$this->assertSame('13/5/14', JDToFrench(2380952));

		$this->assertSame(cal_from_jd(2380953, CAL_FRENCH), Shim::calFromJd(2380953, CAL_FRENCH));
		$this->assertSame('0/0/0', Shim::jdToFrench(2380953));
		$this->assertSame('0/0/0', JDToFrench(2380953));
	}

	/**
	 * Test the implementation of Shim::jdToFrench() against JDToFrench()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @return void
	 */
	public function testJdToFrenchOutOfRange() {
		$julian_day_low = 2375840 - 1;
		$julian_day_high = 2380953 + 2;

		$this->assertSame(Shim::jdToFrench($julian_day_low), JDToFrench($julian_day_low));
		$this->assertSame(Shim::jdToFrench($julian_day_high), JDToFrench($julian_day_high));
		$this->assertSame(Shim::calFromJd($julian_day_low, CAL_FRENCH), cal_from_jd($julian_day_low, CAL_FRENCH));
		$this->assertSame(Shim::calFromJd($julian_day_high, CAL_FRENCH), cal_from_jd($julian_day_high, CAL_FRENCH));
	}

	/**
	 * Test the implementation of Shim::jdToGregorian() against JDToGregorian()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToGregorian() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$julian_day = mt_rand(1, GregorianToJD(12, 31, 9999));

			$this->assertSame(Shim::jdToGregorian($julian_day), JDToGregorian($julian_day));
			$this->assertSame(Shim::calFromJd($julian_day, CAL_GREGORIAN), cal_from_jd($julian_day, CAL_GREGORIAN));
		}
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 * Test the implementation of Shim::jdToGregorian() against JDToGregorian()
	 *
	 * @return void
	 */
	public function testJdToGregorianEdgeCases() {
		$MAX_JD = PHP_INT_SIZE == 4 ? 536838866 : 2305843009213661906;

		$this->assertSame(cal_from_jd(-1, CAL_GREGORIAN), Shim::calFromJd(-1, CAL_GREGORIAN));
		$this->assertSame('0/0/0', Shim::jdToGregorian(-1));
		$this->assertSame('0/0/0', JDToGregorian(-1));

		$this->assertSame(cal_from_jd(0, CAL_GREGORIAN), Shim::calFromJd(0, CAL_GREGORIAN));
		$this->assertSame('0/0/0', Shim::jdToGregorian(0));
		$this->assertSame('0/0/0', JDToGregorian(0));

		$this->assertSame(cal_from_jd(1, CAL_GREGORIAN), Shim::calFromJd(1, CAL_GREGORIAN));
		$this->assertSame('11/25/-4714', Shim::jdToGregorian(1));
		$this->assertSame('11/25/-4714', JDToGregorian(1));

		// PHP overflows and gives bogus results
		//$this->assertSame(cal_from_jd($MAX_JD, CAL_GREGORIAN), Shim::calFromJd($MAX_JD, CAL_GREGORIAN));
		//$this->assertSame(JDToGregorian($MAX_JD), Shim::jdToGregorian($MAX_JD));
		$this->assertNotSame('0/0/0', JDToGregorian($MAX_JD));
		$this->assertNotSame('0/0/0', Shim::jdToGregorian($MAX_JD));

		$this->assertSame(cal_from_jd($MAX_JD + 1, CAL_GREGORIAN), Shim::calFromJd($MAX_JD + 1, CAL_GREGORIAN));
		$this->assertSame('0/0/0', Shim::jdToGregorian($MAX_JD + 1));
		$this->assertSame('0/0/0', JDToGregorian($MAX_JD + 1));
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToJewish() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$julian_day = mt_rand(JewishToJD(1, 1, 1000), JewishToJD(13, 29, 9999));

			$this->assertSame(Shim::jdToJewish($julian_day, false, 0), jdtojewish($julian_day));
			$this->assertSame(Shim::calFromJd($julian_day, CAL_JEWISH), cal_from_jd($julian_day, CAL_JEWISH));
		}
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToJewishEdgeCases() {
		$this->assertSame(cal_from_jd(347997, CAL_JEWISH), Shim::calFromJd(347997, CAL_JEWISH));
		$this->assertSame('0/0/0', Shim::jdToJewish(347997, false, 0));
		$this->assertSame('0/0/0', JDToJewish(347997));

		$this->assertSame(cal_from_jd(347998, CAL_JEWISH), Shim::calFromJd(347998, CAL_JEWISH));
		$this->assertSame('1/1/1', Shim::jdToJewish(347998, false, 0));
		$this->assertSame('1/1/1', JDToJewish(347998));

		$this->assertSame(cal_from_jd(4000075, CAL_JEWISH), Shim::calFromJd(4000075, CAL_JEWISH));
		$this->assertSame('13/29/9999', Shim::jdToJewish(4000075, false, 0));
		$this->assertSame('13/29/9999', JDToJewish(4000075));

		$this->assertSame(cal_from_jd(4000076, CAL_JEWISH), Shim::calFromJd(4000076, CAL_JEWISH));
		$this->assertSame('1/1/10000', Shim::jdToJewish(4000076, false, 0));
		$this->assertSame('1/1/10000', JDToJewish(4000076));

		$this->assertSame(cal_from_jd(324542846, CAL_JEWISH), Shim::calFromJd(324542846, CAL_JEWISH));
		$this->assertSame('12/13/887605', Shim::jdToJewish(324542846, false, 0));
		$this->assertSame('12/13/887605', JDToJewish(324542846));

		$this->assertSame(cal_from_jd(324542847, CAL_JEWISH), Shim::calFromJd(324542847, CAL_JEWISH));
		$this->assertSame('0/0/0', Shim::jdToJewish(324542847, false, 0));
		$this->assertSame('0/0/0', JDToJewish(324542847));
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToJewishHebrew() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$julian_day = mt_rand(JewishToJD(1, 1, 1000), JewishToJD(13, 29, 9999));
			$flags = mt_rand(0, 7);
			$this->assertSame(Shim::jdToJewish($julian_day, true, $flags), jdtojewish($julian_day, true, $flags));
		}
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage Year out of range (0-9999).
	 * @return                   void
	 */
	public function testJdToJewishHebrewOutOfRangeLow1() {
		$julian_day = JewishToJd(1,1,1) - 1;

		Shim::jdToJewish($julian_day, true, 0);
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage Year out of range (0-9999).
	 * @return                   void
	 */
	public function testJdToJewishHebrewOutOfRangeLow2() {
		$julian_day = JewishToJd(1, 1, 1) - 1;

		JdToJewish($julian_day, true, 0);
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage Year out of range (0-9999).
	 * @return                   void
	 */
	public function testJdToJewishHebrewOutOfRangeHigh1() {
		$julian_day = JewishToJd(13, 29, 9999) + 1;

		Shim::jdToJewish($julian_day, true, 0);
	}

	/**
	 * Test the implementation of Shim::jdToJewish() against jdtojewish()
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 *
	 * @expectedException        \PHPUnit_Framework_Error_Warning
	 * @expectedExceptionMessage Year out of range (0-9999).
	 * @return                   void
	 */
	public function testJdToJewishHebrewOutOfRangeHigh2() {
		$julian_day = JewishToJd(13, 29, 9999) + 1;

		JdToJewish($julian_day, true, 0);
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 * Test the implementation of Shim::jdToJulian() against JDToJulian()
	 *
	 * @return void
	 */
	public function testJdToJulian() {
		$start_jd = JulianToJD(1, 1, -2500);
		$end_jd = JulianToJD(1, 1, 2500);

		for ($julian_day = $start_jd; $julian_day <= $end_jd; $julian_day += static::LARGE_PRIME) {
			$this->assertSame(Shim::calFromJd($julian_day, CAL_JULIAN), cal_from_jd($julian_day, CAL_JULIAN));
			$this->assertSame(Shim::jdToJulian($julian_day), JDToJulian($julian_day));
		}
	}

	/**
	 * Test the implementation of Shim::calFromJd() against cal_from_jd()
	 * Test the implementation of Shim::jdToJulian() against JDToJulian()
	 *
	 * @return void
	 */
	public function testJdToJulianEdgeCases() {
		$MAX_JD = PHP_INT_SIZE == 4 ? 536838829 : 784368370349;

		$this->assertSame(cal_from_jd(-1, CAL_JULIAN), Shim::calFromJd(-1, CAL_JULIAN));
		$this->assertSame('0/0/0', Shim::jdToJulian(-1));
		$this->assertSame('0/0/0', JDToJulian(-1));

		$this->assertSame(cal_from_jd(0, CAL_JULIAN), Shim::calFromJd(0, CAL_JULIAN));
		$this->assertSame('0/0/0', Shim::jdToJulian(0));
		$this->assertSame('0/0/0', JDToJulian(0));

		$this->assertSame(cal_from_jd(1, CAL_JULIAN), Shim::calFromJd(1, CAL_JULIAN));
		$this->assertSame('1/2/-4713', Shim::jdToJulian(1));
		$this->assertSame('1/2/-4713', JDToJulian(1));

		// PHP overflows and gives bogus results
		//$this->assertSame(cal_from_jd($MAX_JD, CAL_JULIAN), Shim::calFromJd($MAX_JD, CAL_JULIAN));
		//$this->assertSame(JDToJulian($MAX_JD), Shim::jdToJulian($MAX_JD));
		$this->assertNotSame('0/0/0', JDToJulian($MAX_JD));
		$this->assertNotSame('0/0/0', Shim::jdToJulian($MAX_JD));

		$this->assertSame(cal_from_jd($MAX_JD + 1, CAL_JULIAN), Shim::calFromJd($MAX_JD + 1, CAL_JULIAN));
		$this->assertSame('0/0/0', Shim::jdToJulian($MAX_JD + 1));
		$this->assertSame('0/0/0', JDToJulian($MAX_JD + 1));
	}

	/**
	 * Test the implementation of Shim::jdToUnix() against jdtojunix()
	 *
	 * @return void
	 */
	public function testJdToUnix() {
		$julian_day_start = GregorianToJD(1, 1, 1980);
		$julian_day_end = GregorianToJD(12, 31, 2030);

		for ($julian_day = $julian_day_start; $julian_day <= $julian_day_end; $julian_day += 23) {
			$this->assertSame(Shim::jdToUnix($julian_day), jdtounix($julian_day));
		}
	}

	/**
	 * Test the implementation of Shim::jdToUnix() against jdtojunix()
	 *
	 * @return void
	 */
	public function testJdToUnixEdgeCases() {
		$this->assertSame(Shim::jdToUnix(2440587), false);
		$this->assertSame(Shim::jdToUnix(2440587), jdtounix(2440587));

		$this->assertSame(Shim::jdToUnix(2440588), 0);
		$this->assertSame(Shim::jdToUnix(2440588), jdtounix(2440588));

		$this->assertSame(Shim::jdToUnix(2465343), 2138832000);
		$this->assertSame(Shim::jdToUnix(2465343), jdtounix(2465343));

		$this->assertSame(Shim::jdToUnix(2465344), false);
		$this->assertSame(Shim::jdToUnix(2465344), jdtounix(2465344));
	}

	/**
	 * Test the implementation of Shim::jewishToJD() against JewishToJD()
	 * Test the implementation of Shim::calToJd() against cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJewishToJd() {
		$this->assertSame(Shim::jewishToJD(1, 1, 0), JewishToJD(1, 1, 0));

		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(1, 9999);
			$month = mt_rand(1, 13);
			$day = mt_rand(1, 29);

			$this->assertSame(Shim::jewishToJD($month, $day, $year), JewishToJD($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_JEWISH, $month, $day, $year), cal_to_jd(CAL_JEWISH, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::julianToJd() against JulianToJd()
	 * Test the implementation of Shim::calToJd() against cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJulianToJd() {
		$this->assertSame(Shim::julianToJd(1, 1, 0), JulianToJd(1, 1, 0));

		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(-4713, 9999);
			$month = mt_rand(1, 12);
			$day = mt_rand(1, 30);

			$this->assertSame(Shim::julianToJd($month, $day, $year), JulianToJd($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_JULIAN, $month, $day, $year), cal_to_jd(CAL_JULIAN, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::unixToJd() against unixtojd()
	 *
	 * @return void
	 */
	public function testUnixToJd() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$unix = mt_rand(1, 2147483647);
			$this->assertSame(Shim::unixToJd($unix), unixtojd($unix));
		}
	}

	/**
	 * Test the implementation of Shim::unixToJd() against unixtojd()
	 *
	 * @return void
	 */
	public function testUnixToJdEdgeCases() {
		$this->assertSame(Shim::unixToJd(-1), false);
		$this->assertSame(Shim::unixToJd(-1), unixtojd(-1));

		$this->assertSame(Shim::unixToJd(2147483647), 2465443);
		$this->assertSame(Shim::unixToJd(2147483647), unixtojd(2147483647));
	}
}
