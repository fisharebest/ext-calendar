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
	/**
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$jewish = new JewishCalendar;

		$this->assertSame($jewish::PHP_CALENDAR_NAME, 'Jewish');
		$this->assertSame($jewish::PHP_CALENDAR_NUMBER, CAL_JEWISH);
		$this->assertSame($jewish::GEDCOM_CALENDAR_ESCAPE, '@#DHEBREW@');
	}

	/**
	 * Test the PHP calendar information function.
	 *
	 * @covers Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 * @covers Fisharebest\ExtCalendar\JewishCalendar::monthNames
	 * @covers Fisharebest\ExtCalendar\Calendar::monthNamesAbbreviated
	 *
	 * @return void
	 */
	public function testPhpCalInfo() {
		$jewish = new JewishCalendar;

		$this->assertSame($jewish->phpCalInfo(), \cal_info($jewish::PHP_CALENDAR_NUMBER));
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::leapYear
	 *
	 * @return void
	 */
	public function testLeapYear() {
		$jewish = new JewishCalendar;

		$this->assertSame($jewish->leapYear(5767), false);
		$this->assertSame($jewish->leapYear(5768), true);
		$this->assertSame($jewish->leapYear(5769), false);
		$this->assertSame($jewish->leapYear(5770), false);
		$this->assertSame($jewish->leapYear(5771), true);
		$this->assertSame($jewish->leapYear(5772), false);
		$this->assertSame($jewish->leapYear(5773), false);
		$this->assertSame($jewish->leapYear(5774), true);
		$this->assertSame($jewish->leapYear(5775), false);
		$this->assertSame($jewish->leapYear(5776), true);
		$this->assertSame($jewish->leapYear(5777), false);
		$this->assertSame($jewish->leapYear(5778), false);
		$this->assertSame($jewish->leapYear(5779), true);
		$this->assertSame($jewish->leapYear(5780), false);
		$this->assertSame($jewish->leapYear(5781), false);
		$this->assertSame($jewish->leapYear(5782), true);
		$this->assertSame($jewish->leapYear(5783), false);
		$this->assertSame($jewish->leapYear(5784), true);
		$this->assertSame($jewish->leapYear(5785), false);
	}

	/**
	 * Test the calculation of month lengths against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonth() {
		$jewish = new JewishCalendar;

		for ($year = 5730; $year <= 5798; ++$year) {
			for ($month = 1; $month <= 13; ++$month) {
				$this->assertSame($jewish->daysInMonth($year, $month), \cal_days_in_month(CAL_JEWISH, $month, $year));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdDays() {
		$jewish = new JewishCalendar;

		foreach (array(5776, 5777) as $year) {
			for ($day = 1; $day <= 30; ++$day) {
				$jd = \JewishToJD(8, $day, $year);
				$ymd = $jewish->jdToYmd($jd);

				$this->assertSame($jewish->ymdToJd($year, 8, $day), $jd);
				$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \jdtojewish($jd));
				$this->assertSame($jewish->calFromJd($jd, CAL_JEWISH), \cal_from_jd($jd, CAL_JEWISH));
			}
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdMonths() {
		$jewish = new JewishCalendar;

		for ($month=1; $month<=13; ++$month) {
			$jd = \JewishToJD($month, 27, 5776);
			$ymd = $jewish->jdToYmd($jd);

			$this->assertSame($jewish->ymdToJd(5776, $month, 27), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \jdtojewish($jd));
			$this->assertSame($jewish->calFromJd($jd), \cal_from_jd($jd, CAL_JEWISH));

			$jd = \JewishToJD($month, 27, 5777);
			$ymd = $jewish->jdToYmd($jd);

			$this->assertSame($jewish->ymdToJd(5777, $month, 27), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \jdtojewish($jd));
			$this->assertSame($jewish->calFromJd($jd), \cal_from_jd($jd, CAL_JEWISH));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
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
		$jewish = new JewishCalendar;

		for ($year=5730; $year<=5798; ++$year) {
			$jd = \JewishToJD(8, 9, $year);
			$ymd = $jewish->jdToYmd($jd);

			$this->assertSame($jewish->ymdToJd($year, 8, 9), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \jdtojewish($jd));
			$this->assertSame($jewish->calFromJd($jd), \cal_from_jd($jd, CAL_JEWISH));
		}
	}

	/**
	 * Test the conversion of calendar dates into Julian days against the reference implementation.
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::calFromJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToY
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::yToJd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdToJdYearsHistoric() {
		$jewish = new JewishCalendar;

		for ($year=100; $year<=200; ++$year) {
			$jd = \JewishToJD(1, 1, $year);
			$ymd = $jewish->jdToYmd($jd);

			$this->assertSame($jewish->ymdToJd($year, 1, 1), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \jdtojewish($jd));
			$this->assertSame($jewish->calFromJd($jd), \cal_from_jd($jd, CAL_JEWISH));

			$jd = \JewishToJD(13, 30, $year);
			$ymd = $jewish->jdToYmd($jd);

			$this->assertSame($jewish->ymdToJd($year, 13, 30), $jd);
			$this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], \jdtojewish($jd));
			$this->assertSame($jewish->calFromJd($jd), \cal_from_jd($jd, CAL_JEWISH));
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
		$jewish = new JewishCalendar;

		foreach (array(
			1, 15, 16, 17, 234, 987,
			4010, 4020, 4030, 4040, 4050, 4060, 4070, 4080, 4090,
			5000, 5100, 5150, 5110, 5776, 5777, 9999
		) as $year) {
			$jd = \JewishToJD(13, 15, $year);
			foreach (array(0, CAL_JEWISH_ADD_ALAFIM_GERESH) as $alafim_geresh) {
				foreach (array(0, CAL_JEWISH_ADD_ALAFIM) as $alafim) {
					foreach (array(0, CAL_JEWISH_ADD_GERESHAYIM) as $gereshayim) {
						$this->assertSame(
							$jewish->jdToHebrew($jd, $alafim_geresh, $alafim, $gereshayim),
							\jdtojewish($jd, true, $alafim_geresh + $alafim + $gereshayim)
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
		$jewish = new JewishCalendar;

		foreach (array(4, 15, 16, 27) as $day) {
			$jd = \JewishToJD(8, $day, 5776);
			foreach (array(0, CAL_JEWISH_ADD_ALAFIM_GERESH) as $alafim_geresh) {
				foreach (array(0, CAL_JEWISH_ADD_ALAFIM) as $alafim) {
					foreach (array(0, CAL_JEWISH_ADD_GERESHAYIM) as $gereshayim) {
						$this->assertSame(
							$jewish->jdToHebrew($jd, $alafim_geresh, $alafim, $gereshayim),
							\jdtojewish($jd, true, $alafim_geresh + $alafim + $gereshayim)
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
		$jewish = new JewishCalendar;

		foreach (array(5776, 5777) as $year) {
			for ($month = 1; $month <= 13; ++$month) {
				$jd = \JewishToJD($month, 23, $year);
				foreach (array(0, CAL_JEWISH_ADD_ALAFIM_GERESH) as $alafim_geresh) {
					foreach (array(0, CAL_JEWISH_ADD_ALAFIM) as $alafim) {
						foreach (array(0, CAL_JEWISH_ADD_GERESHAYIM) as $gereshayim) {
							$this->assertSame(
								bin2hex($jewish->jdToHebrew($jd, $alafim_geresh, $alafim, $gereshayim)),
								bin2hex(\jdtojewish($jd, true, $alafim_geresh + $alafim + $gereshayim))
							);
						}
					}
				}
			}
		}
	}

	/**
	 * Test the implementation of Jewish::calInfo() against \cal_info()
	 *
	 * @covers \Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 *
	 * @return void
	 */
	public function testCalInfo() {
		$jewish = new JewishCalendar;

		$this->assertSame($jewish->phpCalInfo(), cal_info(CAL_JEWISH));
	}
}
