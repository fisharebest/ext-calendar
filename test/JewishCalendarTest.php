<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class JewishCalendar
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
class JewishCalendarTest extends TestCase {
	/** @var CalendarJewish */
	private $jewish;

	/**
	 * Create the shim functions, so we can run tests on servers which do
	 * not have the ext/calendar library installed.  For example HHVM.
	 *
	 * @return void
	 */
	public function setUp() {
		Shim::create();
		$this->jewish = new JewishCalendar(array(
			JewishCalendar::EMULATE_BUG_54254 => Shim::shouldEmulateBug54254(),
		));
	}

	/**
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$this->assertSame(JewishCalendar::GEDCOM_CALENDAR_ESCAPE, '@#DHEBREW@');
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::isLeapYear
	 *
	 * @return void
	 */
	public function testIsLeapYear() {
		$this->assertSame($this->jewish->isLeapYear(5767), false);
		$this->assertSame($this->jewish->isLeapYear(5768), true);
		$this->assertSame($this->jewish->isLeapYear(5769), false);
		$this->assertSame($this->jewish->isLeapYear(5770), false);
		$this->assertSame($this->jewish->isLeapYear(5771), true);
		$this->assertSame($this->jewish->isLeapYear(5772), false);
		$this->assertSame($this->jewish->isLeapYear(5773), false);
		$this->assertSame($this->jewish->isLeapYear(5774), true);
		$this->assertSame($this->jewish->isLeapYear(5775), false);
		$this->assertSame($this->jewish->isLeapYear(5776), true);
		$this->assertSame($this->jewish->isLeapYear(5777), false);
		$this->assertSame($this->jewish->isLeapYear(5778), false);
		$this->assertSame($this->jewish->isLeapYear(5779), true);
		$this->assertSame($this->jewish->isLeapYear(5780), false);
		$this->assertSame($this->jewish->isLeapYear(5781), false);
		$this->assertSame($this->jewish->isLeapYear(5782), true);
		$this->assertSame($this->jewish->isLeapYear(5783), false);
		$this->assertSame($this->jewish->isLeapYear(5784), true);
		$this->assertSame($this->jewish->isLeapYear(5785), false);
	}

	/**
	 * Test the calculation of month lengths against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonth() {
		for ($year = 5730; $year <= 5798; ++$year) {
			for ($month = 1; $month <= 13; ++$month) {
				$this->assertSame($this->jewish->daysInMonth($year, $month), cal_days_in_month(CAL_JEWISH, $month, $year));
			}
		}
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Month 0 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthMonthZero() {
		$this->jewish->daysInMonth(5001, 0);
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Month 14 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthMonthFourteen() {
		$this->jewish->daysInMonth(5001, 14);
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Year 0 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthYearZero() {
		$this->jewish->daysInMonth(0, 6);
	}

	/**
	 * Test the calculation of the number of days in each month against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::daysInMonth
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Year -1 is invalid for this calendar
	 *
	 * @return void
	 */
	public function testDaysInMonthYearMinusOne() {
		$this->jewish->daysInMonth(-1, 6);
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		foreach (array(5776, 5777) as $year) {
			for ($day = 1; $day <= 30; ++$day) {
				$julian_day = JewishToJD(8, $day, $year);
				$ymd = $this->jewish->jdToYmd($julian_day);

				$this->assertSame($this->jewish->ymdToJd($year, 8, $day), $julian_day);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], jdtojewish($julian_day));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		for ($month=1; $month<=13; ++$month) {
			$julian_day = JewishToJD($month, 27, 5776);
			$ymd = $this->jewish->jdToYmd($julian_day);

			$this->assertSame($this->jewish->ymdToJd(5776, $month, 27), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], jdtojewish($julian_day));

			$julian_day = JewishToJD($month, 27, 5777);
			$ymd = $this->jewish->jdToYmd($julian_day);

			$this->assertSame($this->jewish->ymdToJd(5777, $month, 27), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], jdtojewish($julian_day));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @medium This test may take several seconds to run.
	 *
	 * @return void
	 */
	public function testYmdToJdYears() {
		for ($year=5730; $year<=5798; ++$year) {
			$julian_day = JewishToJD(8, 9, $year);
			$ymd = $this->jewish->jdToYmd($julian_day);

			$this->assertSame($this->jewish->ymdToJd($year, 8, 9), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], jdtojewish($julian_day));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYearsHistoric() {
		for ($year=100; $year<=200; ++$year) {
			$julian_day = JewishToJD(1, 1, $year);
			$ymd = $this->jewish->jdToYmd($julian_day);

			$this->assertSame($this->jewish->ymdToJd($year, 1, 1), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], jdtojewish($julian_day));

			$julian_day = JewishToJD(13, 30, $year);
			$ymd = $this->jewish->jdToYmd($julian_day);

			$this->assertSame($this->jewish->ymdToJd($year, 13, 30), $julian_day);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], jdtojewish($julian_day));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @large This test can take several seconds to run.
	 *
	 * @return void
	 */
	public function testJdToHebrewYear() {
		foreach (array(
			1, 15, 16, 17, 234, 987,
			4010, 4020, 4030, 4040, 4050, 4060, 4070, 4080, 4090,
			5000, 5100, 5150, 5110, 5776, 5777, 9999
		) as $year) {
			$julian_day = JewishToJD(13, 15, $year);
			foreach (array(0, CAL_JEWISH_ADD_ALAFIM_GERESH) as $alafim_geresh) {
				foreach (array(0, CAL_JEWISH_ADD_ALAFIM) as $alafim) {
					foreach (array(0, CAL_JEWISH_ADD_GERESHAYIM) as $gereshayim) {
						$this->assertSame(
							$this->jewish->jdToHebrew($julian_day, $alafim_geresh, $alafim, $gereshayim),
							jdtojewish($julian_day, true, $alafim_geresh + $alafim + $gereshayim)
						);
					}
				}
			}
		}
	}


	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @large This test can take several seconds to run.
	 *
	 * @return void
	 */
	public function testJdToHebrewDay() {
		foreach (array(4, 15, 16, 27) as $day) {
			$julian_day = JewishToJD(8, $day, 5776);
			foreach (array(0, CAL_JEWISH_ADD_ALAFIM_GERESH) as $alafim_geresh) {
				foreach (array(0, CAL_JEWISH_ADD_ALAFIM) as $alafim) {
					foreach (array(0, CAL_JEWISH_ADD_GERESHAYIM) as $gereshayim) {
						$this->assertSame(
							$this->jewish->jdToHebrew($julian_day, $alafim_geresh, $alafim, $gereshayim),
							jdtojewish($julian_day, true, $alafim_geresh + $alafim + $gereshayim)
						);
					}
				}
			}
		}
	}


	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @large This test can take several seconds to run.
	 *
	 * @return void
	 */
	public function testJdToHebrewMonth() {
		foreach (array(5776, 5777) as $year) {
			for ($month = 1; $month <= 13; ++$month) {
				$julian_day = JewishToJD($month, 23, $year);
				foreach (array(0, CAL_JEWISH_ADD_ALAFIM_GERESH) as $alafim_geresh) {
					foreach (array(0, CAL_JEWISH_ADD_ALAFIM) as $alafim) {
						foreach (array(0, CAL_JEWISH_ADD_GERESHAYIM) as $gereshayim) {
							$this->assertSame(
								bin2hex($this->jewish->jdToHebrew($julian_day, $alafim_geresh, $alafim, $gereshayim)),
								bin2hex(jdtojewish($julian_day, true, $alafim_geresh + $alafim + $gereshayim))
							);
						}
					}
				}
			}
		}
	}
}
