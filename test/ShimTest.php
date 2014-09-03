<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class Shim
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

class ScriptTest extends TestCase {
	// Use this many random dates to test date conversion functions.
	const ITERATIONS = 512;
	/**
	 * To iterate over large ranges of test data, use a prime-number interval to
	 * avoid any synchronisation problems.
	 */
	const LARGE_PRIME = 235741;

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testCalDaysInMonthFrench() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(1, 14);
			$month = mt_rand(1, 13);
			$this->assertEquals(Shim::calDaysInMonth(CAL_FRENCH, $month, $year), \cal_days_in_month(CAL_FRENCH, $month, $year));
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchInvalidMonth1() {
		Shim::calDaysInMonth(CAL_FRENCH, 14, 10);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchInvalidMonth2() {
		\cal_days_in_month(CAL_FRENCH, 14, 10);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchLowYear1() {
		Shim::calDaysInMonth(CAL_FRENCH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchLowYear2() {
		\cal_days_in_month(CAL_FRENCH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchHighYear1() {
		Shim::calDaysInMonth(CAL_FRENCH, 1, 15);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthFrenchHighYear2() {
		\cal_days_in_month(CAL_FRENCH, 1, 15);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
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
				$this->assertEquals(Shim::calDaysInMonth(CAL_GREGORIAN, $month, $year), \cal_days_in_month(CAL_GREGORIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidMonth1() {
		Shim::calDaysInMonth(CAL_GREGORIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidMonth2() {
		\cal_days_in_month(CAL_GREGORIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidYear1() {
		Shim::calDaysInMonth(CAL_GREGORIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthGregorianInvalidYear2() {
		\cal_days_in_month(CAL_GREGORIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
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
				$this->assertEquals(Shim::calDaysInMonth(CAL_GREGORIAN, $month, $year), \cal_days_in_month(CAL_GREGORIAN, $month, $year));
			}
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testCalDaysInMonthJewish() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(1, 6000);
			$month = mt_rand(1, 13);
			$this->assertEquals(Shim::calDaysInMonth(CAL_JEWISH, $month, $year), \cal_days_in_month(CAL_JEWISH, $month, $year));
		}
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidMonth1() {
		Shim::calDaysInMonth(CAL_JEWISH, 14, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidMonth2() {
		\cal_days_in_month(CAL_JEWISH, 14, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidYear1() {
		Shim::calDaysInMonth(CAL_JEWISH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJewishInvalidYear2() {
		\cal_days_in_month(CAL_JEWISH, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidMonth1() {
		Shim::calDaysInMonth(CAL_JULIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidMonth2() {
		\cal_days_in_month(CAL_JULIAN, 13, 2014);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidYear1() {
		Shim::calDaysInMonth(CAL_JULIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid date.
	 * @return                   void
	 */
	public function testCalDaysInMonthJulianInvalidYear2() {
		\cal_days_in_month(CAL_JULIAN, 1, 0);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999.
	 * @return                   void
	 */
	public function testCalDaysInMonthInvalidCalendar1() {
		Shim::calDaysInMonth(999, 1, 1);
	}

	/**
	 * Test the implementation of Shim::calDaysInMonth() against \cal_days_in_month()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999.
	 * @return                   void
	 */
	public function testCalDaysInMonthInvalidCalendar2() {
		\cal_days_in_month(999, 1, 1);
	}

	/**
	 * Test the implementation of Shim::calFromJd() against \cal_from_jd()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalFromJdInvalidCalendar1() {
		Shim::calFromJd(2345678, 999);
	}

	/**
	 * Test the implementation of Shim::calFromJd() against \cal_from_jd()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalFromJdInvalidCalendar2() {
		\cal_from_jd(2345678, 999);
	}

	/**
	 * Test the implementation of Shim::calInfo() against \cal_info()
	 *
	 * @return void
	 */
	public function testCalInfo() {
		$this->assertSame(Shim::calInfo(CAL_FRENCH), \cal_info(CAL_FRENCH));
		$this->assertSame(Shim::calInfo(CAL_GREGORIAN), \cal_info(CAL_GREGORIAN));
		$this->assertSame(Shim::calInfo(CAL_JEWISH), \cal_info(CAL_JEWISH));
		$this->assertSame(Shim::calInfo(CAL_JULIAN), \cal_info(CAL_JULIAN));
	}

	/**
	 * Test the implementation of Shim::calInfo() against \cal_info()
	 *
	 * @return void
	 */
	public function testCalInfoAll() {
		$this->assertSame(Shim::calInfo(), \cal_info());
	}

	/**
	 * Test the implementation of Shim::calInfo() against \cal_info()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalInfoInvalid1() {
		Shim::calInfo(999);
	}

	/**
	 * Test the implementation of Shim::calInfo() against \cal_info()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalInfoInvalid2() {
		\cal_info(999);
	}

	/**
	 * Test the implementation of Shim::calToJd() against \cal_to_jd()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_USER_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalToJdInvalidCalendar1() {
		Shim::calToJd(999, 1, 1, 1);
	}

	/**
	 * Test the implementation of Shim::calToJd() against \cal_to_jd()
	 *
	 * @expectedException        PHPUnit_Framework_Error_Warning
	 * @expectedExceptionCode    E_WARNING
	 * @expectedExceptionMessage invalid calendar ID 999
	 * @return                   void
	 */
	public function testCalToJdInvalidCalendar2() {
		\cal_to_jd(999, 1, 1, 1);
	}

	/**
	 * Test the implementation of Shim::easterDate() against \easter_date()
	 *
	 * @return void
	 */
	public function testEasterDate() {
		$this->assertSame(Shim::easterDate(2014), \easter_date(2014));
	}

	/**
	 * Test the implementation of Shim::easterDate() against \easter_date()
	 *
	 * @expectedException PHPUnit_Framework_Error_Warning
	 *
	 * @return void
	 */
	public function testEasterDateHighYear1() {
		Shim::easterDate(2038);
	}

	/**
	 * Test the implementation of Shim::easterDate() against \easter_date()
	 *
	 * @expectedException PHPUnit_Framework_Error_Warning
	 *
	 * @return void
	 */
	public function testEasterDateHighYear2() {
		\easter_date(2038);
	}

	/**
	 * Test the implementation of Shim::easterDate() against \easter_date()
	 *
	 * @expectedException PHPUnit_Framework_Error_Warning
	 *
	 * @return void
	 */
	public function testEasterDateLowYear1() {
		Shim::easterDate(1969);
	}

	/**
	 * Test the implementation of Shim::easterDate() against \easter_date()
	 *
	 * @expectedException PHPUnit_Framework_Error_Warning
	 *
	 * @return void
	 */
	public function testEasterDateLowYear2() {
		\easter_date(1969);
	}

	/**
	 * Test the implementation of Shim::easterDays() against \easter_days()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testEasterDays() {
		$this->assertSame(Shim::easterDays(-4, CAL_EASTER_ALWAYS_GREGORIAN), \easter_days(-4, CAL_EASTER_ALWAYS_GREGORIAN));
		$this->assertSame(Shim::easterDays(-4, CAL_EASTER_ALWAYS_JULIAN), \easter_days(-4, CAL_EASTER_ALWAYS_JULIAN));

		for ($year = 1295; $year <= 2500; ++$year) {
			$this->assertSame(Shim::easterDays(), \easter_days());
			$this->assertSame(Shim::easterDays($year), \easter_days($year));
			$this->assertSame(Shim::easterDays($year, 999), \easter_days($year, 999));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_DEFAULT), \easter_days($year, CAL_EASTER_DEFAULT));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_ROMAN), \easter_days($year, CAL_EASTER_ROMAN));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_ALWAYS_GREGORIAN), \easter_days($year, CAL_EASTER_ALWAYS_GREGORIAN));
			$this->assertSame(Shim::easterDays($year, CAL_EASTER_ALWAYS_JULIAN), \easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
		}
	}

	/**
	 * Test the implementation of Shim::frenchToJd() against \FrenchToJd()
	 * Test the implementation of Shim::calToJd() against \cal_to_jd()
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

			$this->assertSame(Shim::frenchToJd($month, $day, $year), \FrenchToJd($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_FRENCH, $month, $day, $year), \cal_to_jd(CAL_FRENCH, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::frenchToJd() against \FrenchToJd()
	 *
	 * @return void
	 */
	public function testFrenchToJdOutOfRange() {
		$this->assertSame(Shim::frenchToJd(1, 1, 0), \FrenchToJd(1, 1, 0));
	}

	/**
	 * Test the implementation of Shim::gregorianToJd() against \GregorianToJD()
	 * Test the implementation of Shim::calToJd() against \cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testGregorianToJD() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(-4713, 9999);
			$month = mt_rand(1, 12);
			$day = mt_rand(1, 30);

			$this->assertSame(Shim::gregorianToJd($month, $day, $year), \GregorianToJD($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_GREGORIAN, $month, $day, $year), \cal_to_jd(CAL_GREGORIAN, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekSunday() {
		$jd = \GregorianToJD(8, 31, 2014);

		$this->assertEquals(Shim::jdDayOfWeek($jd), 0);
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), 'Sunday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), 'Sun');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 0);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Sun' : 'Sunday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Sunday' : 'Sun');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekMonday() {
		$jd = \GregorianToJD(9, 1, 2014); // 2456902

		$this->assertEquals(Shim::jdDayOfWeek($jd), 1);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 1);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Mon' : 'Monday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Monday' : 'Mon');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekTuesday() {
		$jd = \GregorianToJD(9, 2, 2014); // 2456903

		$this->assertEquals(Shim::jdDayOfWeek($jd), 2);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 2);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Tue' : 'Tuesday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Tuesday' : 'Tue');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekWednesday() {
		$jd = \GregorianToJD(9, 3, 2014); // 2456904

		$this->assertEquals(Shim::jdDayOfWeek($jd), 3);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 3);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Wed' : 'Wednesday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Wednesday' : 'Wed');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekThursday() {
		$jd = \GregorianToJD(9, 4, 2014); // 2456905

		$this->assertEquals(Shim::jdDayOfWeek($jd), 4);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 4);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Thu' : 'Thursday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Thursday' : 'Thu');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekFriday() {
		$jd = \GregorianToJD(9, 5, 2014); // 2456906

		$this->assertEquals(Shim::jdDayOfWeek($jd), 5);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 5);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Fri' : 'Friday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Friday' : 'Fri');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @link https://bugs.php.net/bug.php?id=67960
	 *
	 * @return void
	 */
	public function testJdDayOfWeekSaturday() {
		$jd = \GregorianToJD(9, 6, 2014); // 2456907

		$this->assertEquals(Shim::jdDayOfWeek($jd), 6);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_DAYNO), 6);
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_LONG), Shim::emulateBug67960() ? 'Sat' : 'Saturday');
		$this->assertEquals(Shim::jdDayOfWeek($jd, CAL_DOW_SHORT), Shim::emulateBug67960() ? 'Saturday' : 'Sat');

		$this->assertEquals(Shim::jdDayOfWeek($jd), \JDDayOfWeek($jd));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 0), \JDDayOfWeek($jd, 0));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 1), \JDDayOfWeek($jd, 1));
		$this->assertEquals(Shim::jdDayOfWeek($jd, 2), \JDDayOfWeek($jd, 2));
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @return void
	 */
	public function testJdDayOfWeekNegative() {
		$this->assertEquals(Shim::jdDayOfWeek(-2), 6);
	}

	/**
	 * Test the implementation of Shim::jdDayOfWeek() against \JDDayOfWeek()
	 *
	 * @return void
	 */
	public function testJdDayOfWeekInvalidMode() {
		$jd = \GregorianToJD(8, 31, 2014); // 2456901

		$this->assertEquals(Shim::jdDayOfWeek($jd, 999), 0);
		$this->assertEquals(Shim::jdDayOfWeek($jd, 999), \JDDayOfWeek($jd, 999));
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameGregorian() {
		for ($month=1; $month <= 12; ++$month) {
			$jd = \GregorianToJD($month, 1, 2014);
			$this->assertEquals(Shim::jdMonthName($jd, CAL_MONTH_GREGORIAN_LONG), \JDMonthName($jd, CAL_MONTH_GREGORIAN_LONG));
			$this->assertEquals(Shim::jdMonthName($jd, CAL_MONTH_GREGORIAN_SHORT), \JDMonthName($jd, CAL_MONTH_GREGORIAN_SHORT));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameJulian() {
		for ($month=1; $month <= 12; ++$month) {
			$jd = \JulianToJD($month, 1, 2014);
			$this->assertEquals(Shim::jdMonthName($jd, CAL_MONTH_JULIAN_LONG), \JDMonthName($jd, CAL_MONTH_JULIAN_LONG));
			$this->assertEquals(Shim::jdMonthName($jd, CAL_MONTH_JULIAN_SHORT), \JDMonthName($jd, CAL_MONTH_JULIAN_SHORT));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameFrench() {
		for ($month=1; $month <= 13; ++$month) {
			$jd = \FrenchToJD($month, 1, 10);
			$this->assertEquals(Shim::jdMonthName($jd, CAL_MONTH_FRENCH), \JDMonthName($jd, CAL_MONTH_FRENCH));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameJewish() {
		for ($month=1; $month <= 13; ++$month) {
			$jd = \JewishToJD($month, 1, 5000);
			$this->assertEquals(Shim::jdMonthName($jd, CAL_MONTH_JEWISH), \JDMonthName($jd, CAL_MONTH_JEWISH));
		}
	}

	/**
	 * Test the implementation of Shim::jdMonthName() against \JDMonthName()
	 *
	 * @return void
	 */
	public function testJdMonthNameInvalidMode() {
		$jd = \JulianToJD(1, 1, 2014);

		$this->assertEquals(Shim::jdMonthName($jd, 999), 'Jan');
		$this->assertEquals(Shim::jdMonthName($jd, 999), \JDMonthName($jd, 999));
	}

	/**
	 * Test the implementation of Shim::jdToFrench() against \JDToFrench()
	 * Test the implementation of Shim::calFromJd() against \cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToFrench() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$jd = mt_rand(\GregorianToJD(9, 22, 1792), \GregorianToJD(9, 22, 1806));
			$this->assertEquals(Shim::jdToFrench($jd), \JDToFrench($jd));
			$this->assertEquals(Shim::calFromJd($jd, CAL_FRENCH), \cal_from_jd($jd, CAL_FRENCH));


		}
	}

	/**
	 * Test the implementation of Shim::jdToFrench() against \JDToFrench()
	 * Test the implementation of Shim::calFromJd() against \cal_from_jd()
	 *
	 * @return void
	 */
	public function testJdToFrenchOutOfRange() {
		$jd1 = 2375840 - 1;
		$jd2 = 2380953 + 2;

		$this->assertEquals(Shim::jdToFrench($jd1), \JDToFrench($jd1));
		$this->assertEquals(Shim::jdToFrench($jd2), \JDToFrench($jd2));
		$this->assertEquals(Shim::calFromJd($jd1, CAL_FRENCH), \cal_from_jd($jd1, CAL_FRENCH));
		$this->assertEquals(Shim::calFromJd($jd2, CAL_FRENCH), \cal_from_jd($jd2, CAL_FRENCH));
	}

	/**
	 * Test the implementation of Shim::jdToGregorian() against \JDToGregorian()
	 * Test the implementation of Shim::calFromJd() against \cal_from_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJdToGregorian() {
		for ($n = 0; $n < static::ITERATIONS; ++$n) {
			$jd = mt_rand(1, \GregorianToJD(12, 31, 9999));

			$this->assertEquals(Shim::jdToGregorian($jd), \JDToGregorian($jd));
			$this->assertEquals(Shim::calFromJd($jd, CAL_GREGORIAN), \cal_from_jd($jd, CAL_GREGORIAN));
		}
	}

	/**
	 * Test the implementation of Shim::calFromJd() against \cal_from_jd()
	 * Test the implementation of Shim::jdToJulian() against \JDToJulian()
	 *
	 * @return void
	 */
	public function testJdToJulian() {
		$start_jd = JulianToJD(1, 1, -2500);
		$end_jd = JulianToJD(1, 1, 2500);

		for ($jd = $start_jd; $jd <= $end_jd; $jd += static::LARGE_PRIME) {
			$this->assertEquals(Shim::calFromJd($jd, CAL_JULIAN), \cal_from_jd($jd, CAL_JULIAN));
			$this->assertEquals(Shim::jdToJulian($jd), \JDToJulian($jd));
		}
	}

	/**
	 * Test the implementation of Shim::jdToUnix() against \jdtojunix()
	 *
	 * @return void
	 */
	public function testJdToUnix() {
		$jd_start = \GregorianToJD(1, 1, 1980);
		$jd_end = \GregorianToJD(12, 31, 2030);

		for ($jd = $jd_start; $jd <= $jd_end; $jd += 23) {
			$this->assertSame(Shim::jdToUnix($jd), \jdtounix($jd));
		}
	}

	/**
	 * Test the implementation of Shim::jdToUnix() against \jdtojunix()
	 *
	 * @return void
	 */
	public function testJdToUnixEdgeCases() {
		$this->assertSame(Shim::jdToUnix(2440587), false);
		$this->assertSame(Shim::jdToUnix(2440587), \jdtounix(2440587));

		$this->assertSame(Shim::jdToUnix(2440588), 0);
		$this->assertSame(Shim::jdToUnix(2440588), \jdtounix(2440588));

		$this->assertSame(Shim::jdToUnix(2465343), 2138832000);
		$this->assertSame(Shim::jdToUnix(2465343), \jdtounix(2465343));

		$this->assertSame(Shim::jdToUnix(2465344), false);
		$this->assertSame(Shim::jdToUnix(2465344), \jdtounix(2465344));

	}

	/**
	 * Test the implementation of Shim::jewishToJD() against \JewishToJD()
	 * Test the implementation of Shim::calToJd() against \cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJewishToJd() {
		for ($n=0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(1, 9999);
			$month = mt_rand(1, 13);
			$day = mt_rand(1, 29);

			$this->assertSame(Shim::jewishToJD($month, $day, $year), \JewishToJD($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_JEWISH, $month, $day, $year), \cal_to_jd(CAL_JEWISH, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::julianToJd() against \julianToJd()
	 * Test the implementation of Shim::calToJd() against \cal_to_jd()
	 *
	 * @large
	 *
	 * @return void
	 */
	public function testJulianToJd() {
		for ($n=0; $n < static::ITERATIONS; ++$n) {
			$year = mt_rand(-4713, 9999);
			$month = mt_rand(1, 12);
			$day = mt_rand(1, 30);

			$this->assertSame(Shim::julianToJd($month, $day, $year), \julianToJd($month, $day, $year));
			$this->assertSame(Shim::calToJd(CAL_JULIAN, $month, $day, $year), \cal_to_jd(CAL_JULIAN, $month, $day, $year));
		}
	}

	/**
	 * Test the implementation of Shim::unixToJd() against \unixtojd()
	 *
	 * @return void
	 */
	public function testUnixToJd() {
		$this->assertSame(Shim::unixToJd(), \unixtojd());

		for ($unix = 0; $unix > 0 && $unix <= 2147483647; $unix += 232323) {
			$this->assertSame(Shim::unixToJd($unix), \unixtojd($unix));
		}
	}

	/**
	 * Test the implementation of Shim::unixToJd() against \unixtojd()
	 *
	 * @return void
	 */
	public function testUnixToJdEdgeCases() {
		$this->assertSame(Shim::unixToJd(-1), false);
		$this->assertSame(Shim::unixToJd(-1), \unixtojd(-1));

		$this->assertSame(Shim::unixToJd(0), Shim::unixToJd(time()));
		$this->assertSame(Shim::unixToJd(0), \unixtojd(0));

		$this->assertSame(Shim::unixToJd(2147483647), 2465443);
		$this->assertSame(Shim::unixToJd(2147483647), \unixtojd(2147483647));
	}
}
