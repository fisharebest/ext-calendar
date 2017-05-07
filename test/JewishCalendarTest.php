<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit\Framework\TestCase;

/**
 * Test harness for the class JewishCalendar
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
class JewishCalendarTest extends TestCase {
	/** @var JewishCalendar */
	private $jewish;

	/**
	 * Make sure we emulate the correct version of ext/calendar.
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
		$this->assertSame('@#DHEBREW@', $this->jewish->gedcomCalendarEscape());
		$this->assertSame(347998, $this->jewish->jdStart());
		$this->assertSame(PHP_INT_MAX, $this->jewish->jdEnd());
		$this->assertSame(7, $this->jewish->daysInWeek());
		$this->assertSame(13, $this->jewish->monthsInYear());
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
		
	/**
	 * Test the conversion of calendar dates into Julian days, and vice versa, returns the same result.
	 *
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\JewishCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testJdToYmdReciprocity() {
		$calendar = new JewishCalendar;

		for ($jd = $calendar->jdStart(); $jd < min(2457755, $calendar->jdEnd()); $jd+=16) {
			list($y, $m, $d) = $calendar->jdToYmd($jd);
			$this->assertSame($jd, $calendar->ymdToJd($y, $m, $d));
		}
	}

	/**
	 * Test the conversion of a YMD date to JD when the month is not a valid number.
	 *
	 * @covers \Fisharebest\ExtCalendar\ArabicCalendar::ymdToJd
	 *
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionMessage Month 14 is invalid for this calendar
	 */
	public function testYmdToJdInvalidMonth() {
	    $calendar = new ArabicCalendar;
	    $calendar->ymdToJd(4, 14, 1);
	}

	/**
	 * Test the conversion of numbers into Hebrew numerals.
	 *
	 * @large This test can take several seconds to run.
	 *
	 * @return void
	 */
	public function testNumberToHebrewNumeralsShort() {
		$calendar = new JewishCalendar;
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(1, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(2, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(3, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(4, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(5, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(6, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(7, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(8, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(9, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(10, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(11, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(12, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(13, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(14, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(15, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(16, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(17, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(18, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(19, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(20, false));
		$this->assertSame('כ״א', $calendar->numberToHebrewNumerals(21, false));
		$this->assertSame('כ״ב', $calendar->numberToHebrewNumerals(22, false));
		$this->assertSame('כ״ג', $calendar->numberToHebrewNumerals(23, false));
		$this->assertSame('כ״ד', $calendar->numberToHebrewNumerals(24, false));
		$this->assertSame('כ״ה', $calendar->numberToHebrewNumerals(25, false));
		$this->assertSame('כ״ו', $calendar->numberToHebrewNumerals(26, false));
		$this->assertSame('כ״ז', $calendar->numberToHebrewNumerals(27, false));
		$this->assertSame('כ״ח', $calendar->numberToHebrewNumerals(28, false));
		$this->assertSame('כ״ט', $calendar->numberToHebrewNumerals(29, false));
		$this->assertSame('ל׳', $calendar->numberToHebrewNumerals(30, false));
		$this->assertSame('ל״א', $calendar->numberToHebrewNumerals(31, false));
		$this->assertSame('ל״ב', $calendar->numberToHebrewNumerals(32, false));
		$this->assertSame('ל״ג', $calendar->numberToHebrewNumerals(33, false));
		$this->assertSame('ל״ד', $calendar->numberToHebrewNumerals(34, false));
		$this->assertSame('ל״ה', $calendar->numberToHebrewNumerals(35, false));
		$this->assertSame('ל״ו', $calendar->numberToHebrewNumerals(36, false));
		$this->assertSame('ל״ז', $calendar->numberToHebrewNumerals(37, false));
		$this->assertSame('ל״ח', $calendar->numberToHebrewNumerals(38, false));
		$this->assertSame('ל״ט', $calendar->numberToHebrewNumerals(39, false));
		$this->assertSame('מ׳', $calendar->numberToHebrewNumerals(40, false));
		$this->assertSame('מ״א', $calendar->numberToHebrewNumerals(41, false));
		$this->assertSame('מ״ב', $calendar->numberToHebrewNumerals(42, false));
		$this->assertSame('מ״ג', $calendar->numberToHebrewNumerals(43, false));
		$this->assertSame('מ״ד', $calendar->numberToHebrewNumerals(44, false));
		$this->assertSame('מ״ה', $calendar->numberToHebrewNumerals(45, false));
		$this->assertSame('מ״ו', $calendar->numberToHebrewNumerals(46, false));
		$this->assertSame('מ״ז', $calendar->numberToHebrewNumerals(47, false));
		$this->assertSame('מ״ח', $calendar->numberToHebrewNumerals(48, false));
		$this->assertSame('מ״ט', $calendar->numberToHebrewNumerals(49, false));
		$this->assertSame('נ׳', $calendar->numberToHebrewNumerals(50, false));
		$this->assertSame('נ״א', $calendar->numberToHebrewNumerals(51, false));
		$this->assertSame('נ״ב', $calendar->numberToHebrewNumerals(52, false));
		$this->assertSame('נ״ג', $calendar->numberToHebrewNumerals(53, false));
		$this->assertSame('נ״ד', $calendar->numberToHebrewNumerals(54, false));
		$this->assertSame('נ״ה', $calendar->numberToHebrewNumerals(55, false));
		$this->assertSame('נ״ו', $calendar->numberToHebrewNumerals(56, false));
		$this->assertSame('נ״ז', $calendar->numberToHebrewNumerals(57, false));
		$this->assertSame('נ״ח', $calendar->numberToHebrewNumerals(58, false));
		$this->assertSame('נ״ט', $calendar->numberToHebrewNumerals(59, false));
		$this->assertSame('ס׳', $calendar->numberToHebrewNumerals(60, false));
		$this->assertSame('ס״א', $calendar->numberToHebrewNumerals(61, false));
		$this->assertSame('ס״ב', $calendar->numberToHebrewNumerals(62, false));
		$this->assertSame('ס״ג', $calendar->numberToHebrewNumerals(63, false));
		$this->assertSame('ס״ד', $calendar->numberToHebrewNumerals(64, false));
		$this->assertSame('ס״ה', $calendar->numberToHebrewNumerals(65, false));
		$this->assertSame('ס״ו', $calendar->numberToHebrewNumerals(66, false));
		$this->assertSame('ס״ז', $calendar->numberToHebrewNumerals(67, false));
		$this->assertSame('ס״ח', $calendar->numberToHebrewNumerals(68, false));
		$this->assertSame('ס״ט', $calendar->numberToHebrewNumerals(69, false));
		$this->assertSame('ע׳', $calendar->numberToHebrewNumerals(70, false));
		$this->assertSame('ע״א', $calendar->numberToHebrewNumerals(71, false));
		$this->assertSame('ע״ב', $calendar->numberToHebrewNumerals(72, false));
		$this->assertSame('ע״ג', $calendar->numberToHebrewNumerals(73, false));
		$this->assertSame('ע״ד', $calendar->numberToHebrewNumerals(74, false));
		$this->assertSame('ע״ה', $calendar->numberToHebrewNumerals(75, false));
		$this->assertSame('ע״ו', $calendar->numberToHebrewNumerals(76, false));
		$this->assertSame('ע״ז', $calendar->numberToHebrewNumerals(77, false));
		$this->assertSame('ע״ח', $calendar->numberToHebrewNumerals(78, false));
		$this->assertSame('ע״ט', $calendar->numberToHebrewNumerals(79, false));
		$this->assertSame('פ׳', $calendar->numberToHebrewNumerals(80, false));
		$this->assertSame('פ״א', $calendar->numberToHebrewNumerals(81, false));
		$this->assertSame('פ״ב', $calendar->numberToHebrewNumerals(82, false));
		$this->assertSame('פ״ג', $calendar->numberToHebrewNumerals(83, false));
		$this->assertSame('פ״ד', $calendar->numberToHebrewNumerals(84, false));
		$this->assertSame('פ״ה', $calendar->numberToHebrewNumerals(85, false));
		$this->assertSame('פ״ו', $calendar->numberToHebrewNumerals(86, false));
		$this->assertSame('פ״ז', $calendar->numberToHebrewNumerals(87, false));
		$this->assertSame('פ״ח', $calendar->numberToHebrewNumerals(88, false));
		$this->assertSame('פ״ט', $calendar->numberToHebrewNumerals(89, false));
		$this->assertSame('צ׳', $calendar->numberToHebrewNumerals(90, false));
		$this->assertSame('צ״א', $calendar->numberToHebrewNumerals(91, false));
		$this->assertSame('צ״ב', $calendar->numberToHebrewNumerals(92, false));
		$this->assertSame('צ״ג', $calendar->numberToHebrewNumerals(93, false));
		$this->assertSame('צ״ד', $calendar->numberToHebrewNumerals(94, false));
		$this->assertSame('צ״ה', $calendar->numberToHebrewNumerals(95, false));
		$this->assertSame('צ״ו', $calendar->numberToHebrewNumerals(96, false));
		$this->assertSame('צ״ז', $calendar->numberToHebrewNumerals(97, false));
		$this->assertSame('צ״ח', $calendar->numberToHebrewNumerals(98, false));
		$this->assertSame('צ״ט', $calendar->numberToHebrewNumerals(99, false));
		$this->assertSame('ק׳', $calendar->numberToHebrewNumerals(100, false));
		$this->assertSame('ק״א', $calendar->numberToHebrewNumerals(101, false));
		$this->assertSame('ק״ב', $calendar->numberToHebrewNumerals(102, false));
		$this->assertSame('ק״ג', $calendar->numberToHebrewNumerals(103, false));
		$this->assertSame('ק״ד', $calendar->numberToHebrewNumerals(104, false));
		$this->assertSame('ק״ה', $calendar->numberToHebrewNumerals(105, false));
		$this->assertSame('ק״ו', $calendar->numberToHebrewNumerals(106, false));
		$this->assertSame('ק״ז', $calendar->numberToHebrewNumerals(107, false));
		$this->assertSame('ק״ח', $calendar->numberToHebrewNumerals(108, false));
		$this->assertSame('ק״ט', $calendar->numberToHebrewNumerals(109, false));
		$this->assertSame('ק״י', $calendar->numberToHebrewNumerals(110, false));
		$this->assertSame('קי״א', $calendar->numberToHebrewNumerals(111, false));
		$this->assertSame('קי״ב', $calendar->numberToHebrewNumerals(112, false));
		$this->assertSame('קי״ג', $calendar->numberToHebrewNumerals(113, false));
		$this->assertSame('קי״ד', $calendar->numberToHebrewNumerals(114, false));
		$this->assertSame('קט״ו', $calendar->numberToHebrewNumerals(115, false));
		$this->assertSame('קט״ז', $calendar->numberToHebrewNumerals(116, false));
		$this->assertSame('קי״ז', $calendar->numberToHebrewNumerals(117, false));
		$this->assertSame('קי״ח', $calendar->numberToHebrewNumerals(118, false));
		$this->assertSame('קי״ט', $calendar->numberToHebrewNumerals(119, false));
		$this->assertSame('ק״ך', $calendar->numberToHebrewNumerals(120, false));
		$this->assertSame('קכ״א', $calendar->numberToHebrewNumerals(121, false));
		$this->assertSame('קכ״ב', $calendar->numberToHebrewNumerals(122, false));
		$this->assertSame('קכ״ג', $calendar->numberToHebrewNumerals(123, false));
		$this->assertSame('קכ״ד', $calendar->numberToHebrewNumerals(124, false));
		$this->assertSame('קכ״ה', $calendar->numberToHebrewNumerals(125, false));
		$this->assertSame('קכ״ו', $calendar->numberToHebrewNumerals(126, false));
		$this->assertSame('קכ״ז', $calendar->numberToHebrewNumerals(127, false));
		$this->assertSame('קכ״ח', $calendar->numberToHebrewNumerals(128, false));
		$this->assertSame('קכ״ט', $calendar->numberToHebrewNumerals(129, false));
		$this->assertSame('ק״ל', $calendar->numberToHebrewNumerals(130, false));
		$this->assertSame('קל״א', $calendar->numberToHebrewNumerals(131, false));
		$this->assertSame('קל״ב', $calendar->numberToHebrewNumerals(132, false));
		$this->assertSame('קל״ג', $calendar->numberToHebrewNumerals(133, false));
		$this->assertSame('קל״ד', $calendar->numberToHebrewNumerals(134, false));
		$this->assertSame('קל״ה', $calendar->numberToHebrewNumerals(135, false));
		$this->assertSame('קל״ו', $calendar->numberToHebrewNumerals(136, false));
		$this->assertSame('קל״ז', $calendar->numberToHebrewNumerals(137, false));
		$this->assertSame('קל״ח', $calendar->numberToHebrewNumerals(138, false));
		$this->assertSame('קל״ט', $calendar->numberToHebrewNumerals(139, false));
		$this->assertSame('ק״ם', $calendar->numberToHebrewNumerals(140, false));
		$this->assertSame('קמ״א', $calendar->numberToHebrewNumerals(141, false));
		$this->assertSame('קמ״ב', $calendar->numberToHebrewNumerals(142, false));
		$this->assertSame('קמ״ג', $calendar->numberToHebrewNumerals(143, false));
		$this->assertSame('קמ״ד', $calendar->numberToHebrewNumerals(144, false));
		$this->assertSame('קמ״ה', $calendar->numberToHebrewNumerals(145, false));
		$this->assertSame('קמ״ו', $calendar->numberToHebrewNumerals(146, false));
		$this->assertSame('קמ״ז', $calendar->numberToHebrewNumerals(147, false));
		$this->assertSame('קמ״ח', $calendar->numberToHebrewNumerals(148, false));
		$this->assertSame('קמ״ט', $calendar->numberToHebrewNumerals(149, false));
		$this->assertSame('ק״ן', $calendar->numberToHebrewNumerals(150, false));
		$this->assertSame('קנ״א', $calendar->numberToHebrewNumerals(151, false));
		$this->assertSame('קנ״ב', $calendar->numberToHebrewNumerals(152, false));
		$this->assertSame('קנ״ג', $calendar->numberToHebrewNumerals(153, false));
		$this->assertSame('קנ״ד', $calendar->numberToHebrewNumerals(154, false));
		$this->assertSame('קנ״ה', $calendar->numberToHebrewNumerals(155, false));
		$this->assertSame('קנ״ו', $calendar->numberToHebrewNumerals(156, false));
		$this->assertSame('קנ״ז', $calendar->numberToHebrewNumerals(157, false));
		$this->assertSame('קנ״ח', $calendar->numberToHebrewNumerals(158, false));
		$this->assertSame('קנ״ט', $calendar->numberToHebrewNumerals(159, false));
		$this->assertSame('ק״ס', $calendar->numberToHebrewNumerals(160, false));
		$this->assertSame('קס״א', $calendar->numberToHebrewNumerals(161, false));
		$this->assertSame('קס״ב', $calendar->numberToHebrewNumerals(162, false));
		$this->assertSame('קס״ג', $calendar->numberToHebrewNumerals(163, false));
		$this->assertSame('קס״ד', $calendar->numberToHebrewNumerals(164, false));
		$this->assertSame('קס״ה', $calendar->numberToHebrewNumerals(165, false));
		$this->assertSame('קס״ו', $calendar->numberToHebrewNumerals(166, false));
		$this->assertSame('קס״ז', $calendar->numberToHebrewNumerals(167, false));
		$this->assertSame('קס״ח', $calendar->numberToHebrewNumerals(168, false));
		$this->assertSame('קס״ט', $calendar->numberToHebrewNumerals(169, false));
		$this->assertSame('ק״ע', $calendar->numberToHebrewNumerals(170, false));
		$this->assertSame('קע״א', $calendar->numberToHebrewNumerals(171, false));
		$this->assertSame('קע״ב', $calendar->numberToHebrewNumerals(172, false));
		$this->assertSame('קע״ג', $calendar->numberToHebrewNumerals(173, false));
		$this->assertSame('קע״ד', $calendar->numberToHebrewNumerals(174, false));
		$this->assertSame('קע״ה', $calendar->numberToHebrewNumerals(175, false));
		$this->assertSame('קע״ו', $calendar->numberToHebrewNumerals(176, false));
		$this->assertSame('קע״ז', $calendar->numberToHebrewNumerals(177, false));
		$this->assertSame('קע״ח', $calendar->numberToHebrewNumerals(178, false));
		$this->assertSame('קע״ט', $calendar->numberToHebrewNumerals(179, false));
		$this->assertSame('ק״ף', $calendar->numberToHebrewNumerals(180, false));
		$this->assertSame('קפ״א', $calendar->numberToHebrewNumerals(181, false));
		$this->assertSame('קפ״ב', $calendar->numberToHebrewNumerals(182, false));
		$this->assertSame('קפ״ג', $calendar->numberToHebrewNumerals(183, false));
		$this->assertSame('קפ״ד', $calendar->numberToHebrewNumerals(184, false));
		$this->assertSame('קפ״ה', $calendar->numberToHebrewNumerals(185, false));
		$this->assertSame('קפ״ו', $calendar->numberToHebrewNumerals(186, false));
		$this->assertSame('קפ״ז', $calendar->numberToHebrewNumerals(187, false));
		$this->assertSame('קפ״ח', $calendar->numberToHebrewNumerals(188, false));
		$this->assertSame('קפ״ט', $calendar->numberToHebrewNumerals(189, false));
		$this->assertSame('ק״ץ', $calendar->numberToHebrewNumerals(190, false));
		$this->assertSame('קצ״א', $calendar->numberToHebrewNumerals(191, false));
		$this->assertSame('קצ״ב', $calendar->numberToHebrewNumerals(192, false));
		$this->assertSame('קצ״ג', $calendar->numberToHebrewNumerals(193, false));
		$this->assertSame('קצ״ד', $calendar->numberToHebrewNumerals(194, false));
		$this->assertSame('קצ״ה', $calendar->numberToHebrewNumerals(195, false));
		$this->assertSame('קצ״ו', $calendar->numberToHebrewNumerals(196, false));
		$this->assertSame('קצ״ז', $calendar->numberToHebrewNumerals(197, false));
		$this->assertSame('קצ״ח', $calendar->numberToHebrewNumerals(198, false));
		$this->assertSame('קצ״ט', $calendar->numberToHebrewNumerals(199, false));
		$this->assertSame('ר׳', $calendar->numberToHebrewNumerals(200, false));
		$this->assertSame('ר״א', $calendar->numberToHebrewNumerals(201, false));
		$this->assertSame('ר״ב', $calendar->numberToHebrewNumerals(202, false));
		$this->assertSame('ר״ג', $calendar->numberToHebrewNumerals(203, false));
		$this->assertSame('ר״ד', $calendar->numberToHebrewNumerals(204, false));
		$this->assertSame('ר״ה', $calendar->numberToHebrewNumerals(205, false));
		$this->assertSame('ר״ו', $calendar->numberToHebrewNumerals(206, false));
		$this->assertSame('ר״ז', $calendar->numberToHebrewNumerals(207, false));
		$this->assertSame('ר״ח', $calendar->numberToHebrewNumerals(208, false));
		$this->assertSame('ר״ט', $calendar->numberToHebrewNumerals(209, false));
		$this->assertSame('ר״י', $calendar->numberToHebrewNumerals(210, false));
		$this->assertSame('רי״א', $calendar->numberToHebrewNumerals(211, false));
		$this->assertSame('רי״ב', $calendar->numberToHebrewNumerals(212, false));
		$this->assertSame('רי״ג', $calendar->numberToHebrewNumerals(213, false));
		$this->assertSame('רי״ד', $calendar->numberToHebrewNumerals(214, false));
		$this->assertSame('רט״ו', $calendar->numberToHebrewNumerals(215, false));
		$this->assertSame('רט״ז', $calendar->numberToHebrewNumerals(216, false));
		$this->assertSame('רי״ז', $calendar->numberToHebrewNumerals(217, false));
		$this->assertSame('רי״ח', $calendar->numberToHebrewNumerals(218, false));
		$this->assertSame('רי״ט', $calendar->numberToHebrewNumerals(219, false));
		$this->assertSame('ר״ך', $calendar->numberToHebrewNumerals(220, false));
		$this->assertSame('רכ״א', $calendar->numberToHebrewNumerals(221, false));
		$this->assertSame('רכ״ב', $calendar->numberToHebrewNumerals(222, false));
		$this->assertSame('רכ״ג', $calendar->numberToHebrewNumerals(223, false));
		$this->assertSame('רכ״ד', $calendar->numberToHebrewNumerals(224, false));
		$this->assertSame('רכ״ה', $calendar->numberToHebrewNumerals(225, false));
		$this->assertSame('רכ״ו', $calendar->numberToHebrewNumerals(226, false));
		$this->assertSame('רכ״ז', $calendar->numberToHebrewNumerals(227, false));
		$this->assertSame('רכ״ח', $calendar->numberToHebrewNumerals(228, false));
		$this->assertSame('רכ״ט', $calendar->numberToHebrewNumerals(229, false));
		$this->assertSame('ר״ל', $calendar->numberToHebrewNumerals(230, false));
		$this->assertSame('רל״א', $calendar->numberToHebrewNumerals(231, false));
		$this->assertSame('רל״ב', $calendar->numberToHebrewNumerals(232, false));
		$this->assertSame('רל״ג', $calendar->numberToHebrewNumerals(233, false));
		$this->assertSame('רל״ד', $calendar->numberToHebrewNumerals(234, false));
		$this->assertSame('רל״ה', $calendar->numberToHebrewNumerals(235, false));
		$this->assertSame('רל״ו', $calendar->numberToHebrewNumerals(236, false));
		$this->assertSame('רל״ז', $calendar->numberToHebrewNumerals(237, false));
		$this->assertSame('רל״ח', $calendar->numberToHebrewNumerals(238, false));
		$this->assertSame('רל״ט', $calendar->numberToHebrewNumerals(239, false));
		$this->assertSame('ר״ם', $calendar->numberToHebrewNumerals(240, false));
		$this->assertSame('רמ״א', $calendar->numberToHebrewNumerals(241, false));
		$this->assertSame('רמ״ב', $calendar->numberToHebrewNumerals(242, false));
		$this->assertSame('רמ״ג', $calendar->numberToHebrewNumerals(243, false));
		$this->assertSame('רמ״ד', $calendar->numberToHebrewNumerals(244, false));
		$this->assertSame('רמ״ה', $calendar->numberToHebrewNumerals(245, false));
		$this->assertSame('רמ״ו', $calendar->numberToHebrewNumerals(246, false));
		$this->assertSame('רמ״ז', $calendar->numberToHebrewNumerals(247, false));
		$this->assertSame('רמ״ח', $calendar->numberToHebrewNumerals(248, false));
		$this->assertSame('רמ״ט', $calendar->numberToHebrewNumerals(249, false));
		$this->assertSame('ר״ן', $calendar->numberToHebrewNumerals(250, false));
		$this->assertSame('רנ״א', $calendar->numberToHebrewNumerals(251, false));
		$this->assertSame('רנ״ב', $calendar->numberToHebrewNumerals(252, false));
		$this->assertSame('רנ״ג', $calendar->numberToHebrewNumerals(253, false));
		$this->assertSame('רנ״ד', $calendar->numberToHebrewNumerals(254, false));
		$this->assertSame('רנ״ה', $calendar->numberToHebrewNumerals(255, false));
		$this->assertSame('רנ״ו', $calendar->numberToHebrewNumerals(256, false));
		$this->assertSame('רנ״ז', $calendar->numberToHebrewNumerals(257, false));
		$this->assertSame('רנ״ח', $calendar->numberToHebrewNumerals(258, false));
		$this->assertSame('רנ״ט', $calendar->numberToHebrewNumerals(259, false));
		$this->assertSame('ר״ס', $calendar->numberToHebrewNumerals(260, false));
		$this->assertSame('רס״א', $calendar->numberToHebrewNumerals(261, false));
		$this->assertSame('רס״ב', $calendar->numberToHebrewNumerals(262, false));
		$this->assertSame('רס״ג', $calendar->numberToHebrewNumerals(263, false));
		$this->assertSame('רס״ד', $calendar->numberToHebrewNumerals(264, false));
		$this->assertSame('רס״ה', $calendar->numberToHebrewNumerals(265, false));
		$this->assertSame('רס״ו', $calendar->numberToHebrewNumerals(266, false));
		$this->assertSame('רס״ז', $calendar->numberToHebrewNumerals(267, false));
		$this->assertSame('רס״ח', $calendar->numberToHebrewNumerals(268, false));
		$this->assertSame('רס״ט', $calendar->numberToHebrewNumerals(269, false));
		$this->assertSame('ר״ע', $calendar->numberToHebrewNumerals(270, false));
		$this->assertSame('רע״א', $calendar->numberToHebrewNumerals(271, false));
		$this->assertSame('רע״ב', $calendar->numberToHebrewNumerals(272, false));
		$this->assertSame('רע״ג', $calendar->numberToHebrewNumerals(273, false));
		$this->assertSame('רע״ד', $calendar->numberToHebrewNumerals(274, false));
		$this->assertSame('רע״ה', $calendar->numberToHebrewNumerals(275, false));
		$this->assertSame('רע״ו', $calendar->numberToHebrewNumerals(276, false));
		$this->assertSame('רע״ז', $calendar->numberToHebrewNumerals(277, false));
		$this->assertSame('רע״ח', $calendar->numberToHebrewNumerals(278, false));
		$this->assertSame('רע״ט', $calendar->numberToHebrewNumerals(279, false));
		$this->assertSame('ר״ף', $calendar->numberToHebrewNumerals(280, false));
		$this->assertSame('רפ״א', $calendar->numberToHebrewNumerals(281, false));
		$this->assertSame('רפ״ב', $calendar->numberToHebrewNumerals(282, false));
		$this->assertSame('רפ״ג', $calendar->numberToHebrewNumerals(283, false));
		$this->assertSame('רפ״ד', $calendar->numberToHebrewNumerals(284, false));
		$this->assertSame('רפ״ה', $calendar->numberToHebrewNumerals(285, false));
		$this->assertSame('רפ״ו', $calendar->numberToHebrewNumerals(286, false));
		$this->assertSame('רפ״ז', $calendar->numberToHebrewNumerals(287, false));
		$this->assertSame('רפ״ח', $calendar->numberToHebrewNumerals(288, false));
		$this->assertSame('רפ״ט', $calendar->numberToHebrewNumerals(289, false));
		$this->assertSame('ר״ץ', $calendar->numberToHebrewNumerals(290, false));
		$this->assertSame('רצ״א', $calendar->numberToHebrewNumerals(291, false));
		$this->assertSame('רצ״ב', $calendar->numberToHebrewNumerals(292, false));
		$this->assertSame('רצ״ג', $calendar->numberToHebrewNumerals(293, false));
		$this->assertSame('רצ״ד', $calendar->numberToHebrewNumerals(294, false));
		$this->assertSame('רצ״ה', $calendar->numberToHebrewNumerals(295, false));
		$this->assertSame('רצ״ו', $calendar->numberToHebrewNumerals(296, false));
		$this->assertSame('רצ״ז', $calendar->numberToHebrewNumerals(297, false));
		$this->assertSame('רצ״ח', $calendar->numberToHebrewNumerals(298, false));
		$this->assertSame('רצ״ט', $calendar->numberToHebrewNumerals(299, false));
		$this->assertSame('ש׳', $calendar->numberToHebrewNumerals(300, false));
		$this->assertSame('ש״א', $calendar->numberToHebrewNumerals(301, false));
		$this->assertSame('ש״ב', $calendar->numberToHebrewNumerals(302, false));
		$this->assertSame('ש״ג', $calendar->numberToHebrewNumerals(303, false));
		$this->assertSame('ש״ד', $calendar->numberToHebrewNumerals(304, false));
		$this->assertSame('ש״ה', $calendar->numberToHebrewNumerals(305, false));
		$this->assertSame('ש״ו', $calendar->numberToHebrewNumerals(306, false));
		$this->assertSame('ש״ז', $calendar->numberToHebrewNumerals(307, false));
		$this->assertSame('ש״ח', $calendar->numberToHebrewNumerals(308, false));
		$this->assertSame('ש״ט', $calendar->numberToHebrewNumerals(309, false));
		$this->assertSame('ש״י', $calendar->numberToHebrewNumerals(310, false));
		$this->assertSame('שי״א', $calendar->numberToHebrewNumerals(311, false));
		$this->assertSame('שי״ב', $calendar->numberToHebrewNumerals(312, false));
		$this->assertSame('שי״ג', $calendar->numberToHebrewNumerals(313, false));
		$this->assertSame('שי״ד', $calendar->numberToHebrewNumerals(314, false));
		$this->assertSame('שט״ו', $calendar->numberToHebrewNumerals(315, false));
		$this->assertSame('שט״ז', $calendar->numberToHebrewNumerals(316, false));
		$this->assertSame('שי״ז', $calendar->numberToHebrewNumerals(317, false));
		$this->assertSame('שי״ח', $calendar->numberToHebrewNumerals(318, false));
		$this->assertSame('שי״ט', $calendar->numberToHebrewNumerals(319, false));
		$this->assertSame('ש״ך', $calendar->numberToHebrewNumerals(320, false));
		$this->assertSame('שכ״א', $calendar->numberToHebrewNumerals(321, false));
		$this->assertSame('שכ״ב', $calendar->numberToHebrewNumerals(322, false));
		$this->assertSame('שכ״ג', $calendar->numberToHebrewNumerals(323, false));
		$this->assertSame('שכ״ד', $calendar->numberToHebrewNumerals(324, false));
		$this->assertSame('שכ״ה', $calendar->numberToHebrewNumerals(325, false));
		$this->assertSame('שכ״ו', $calendar->numberToHebrewNumerals(326, false));
		$this->assertSame('שכ״ז', $calendar->numberToHebrewNumerals(327, false));
		$this->assertSame('שכ״ח', $calendar->numberToHebrewNumerals(328, false));
		$this->assertSame('שכ״ט', $calendar->numberToHebrewNumerals(329, false));
		$this->assertSame('ש״ל', $calendar->numberToHebrewNumerals(330, false));
		$this->assertSame('של״א', $calendar->numberToHebrewNumerals(331, false));
		$this->assertSame('של״ב', $calendar->numberToHebrewNumerals(332, false));
		$this->assertSame('של״ג', $calendar->numberToHebrewNumerals(333, false));
		$this->assertSame('של״ד', $calendar->numberToHebrewNumerals(334, false));
		$this->assertSame('של״ה', $calendar->numberToHebrewNumerals(335, false));
		$this->assertSame('של״ו', $calendar->numberToHebrewNumerals(336, false));
		$this->assertSame('של״ז', $calendar->numberToHebrewNumerals(337, false));
		$this->assertSame('של״ח', $calendar->numberToHebrewNumerals(338, false));
		$this->assertSame('של״ט', $calendar->numberToHebrewNumerals(339, false));
		$this->assertSame('ש״ם', $calendar->numberToHebrewNumerals(340, false));
		$this->assertSame('שמ״א', $calendar->numberToHebrewNumerals(341, false));
		$this->assertSame('שמ״ב', $calendar->numberToHebrewNumerals(342, false));
		$this->assertSame('שמ״ג', $calendar->numberToHebrewNumerals(343, false));
		$this->assertSame('שמ״ד', $calendar->numberToHebrewNumerals(344, false));
		$this->assertSame('שמ״ה', $calendar->numberToHebrewNumerals(345, false));
		$this->assertSame('שמ״ו', $calendar->numberToHebrewNumerals(346, false));
		$this->assertSame('שמ״ז', $calendar->numberToHebrewNumerals(347, false));
		$this->assertSame('שמ״ח', $calendar->numberToHebrewNumerals(348, false));
		$this->assertSame('שמ״ט', $calendar->numberToHebrewNumerals(349, false));
		$this->assertSame('ש״ן', $calendar->numberToHebrewNumerals(350, false));
		$this->assertSame('שנ״א', $calendar->numberToHebrewNumerals(351, false));
		$this->assertSame('שנ״ב', $calendar->numberToHebrewNumerals(352, false));
		$this->assertSame('שנ״ג', $calendar->numberToHebrewNumerals(353, false));
		$this->assertSame('שנ״ד', $calendar->numberToHebrewNumerals(354, false));
		$this->assertSame('שנ״ה', $calendar->numberToHebrewNumerals(355, false));
		$this->assertSame('שנ״ו', $calendar->numberToHebrewNumerals(356, false));
		$this->assertSame('שנ״ז', $calendar->numberToHebrewNumerals(357, false));
		$this->assertSame('שנ״ח', $calendar->numberToHebrewNumerals(358, false));
		$this->assertSame('שנ״ט', $calendar->numberToHebrewNumerals(359, false));
		$this->assertSame('ש״ס', $calendar->numberToHebrewNumerals(360, false));
		$this->assertSame('שס״א', $calendar->numberToHebrewNumerals(361, false));
		$this->assertSame('שס״ב', $calendar->numberToHebrewNumerals(362, false));
		$this->assertSame('שס״ג', $calendar->numberToHebrewNumerals(363, false));
		$this->assertSame('שס״ד', $calendar->numberToHebrewNumerals(364, false));
		$this->assertSame('שס״ה', $calendar->numberToHebrewNumerals(365, false));
		$this->assertSame('שס״ו', $calendar->numberToHebrewNumerals(366, false));
		$this->assertSame('שס״ז', $calendar->numberToHebrewNumerals(367, false));
		$this->assertSame('שס״ח', $calendar->numberToHebrewNumerals(368, false));
		$this->assertSame('שס״ט', $calendar->numberToHebrewNumerals(369, false));
		$this->assertSame('ש״ע', $calendar->numberToHebrewNumerals(370, false));
		$this->assertSame('שע״א', $calendar->numberToHebrewNumerals(371, false));
		$this->assertSame('שע״ב', $calendar->numberToHebrewNumerals(372, false));
		$this->assertSame('שע״ג', $calendar->numberToHebrewNumerals(373, false));
		$this->assertSame('שע״ד', $calendar->numberToHebrewNumerals(374, false));
		$this->assertSame('שע״ה', $calendar->numberToHebrewNumerals(375, false));
		$this->assertSame('שע״ו', $calendar->numberToHebrewNumerals(376, false));
		$this->assertSame('שע״ז', $calendar->numberToHebrewNumerals(377, false));
		$this->assertSame('שע״ח', $calendar->numberToHebrewNumerals(378, false));
		$this->assertSame('שע״ט', $calendar->numberToHebrewNumerals(379, false));
		$this->assertSame('ש״ף', $calendar->numberToHebrewNumerals(380, false));
		$this->assertSame('שפ״א', $calendar->numberToHebrewNumerals(381, false));
		$this->assertSame('שפ״ב', $calendar->numberToHebrewNumerals(382, false));
		$this->assertSame('שפ״ג', $calendar->numberToHebrewNumerals(383, false));
		$this->assertSame('שפ״ד', $calendar->numberToHebrewNumerals(384, false));
		$this->assertSame('שפ״ה', $calendar->numberToHebrewNumerals(385, false));
		$this->assertSame('שפ״ו', $calendar->numberToHebrewNumerals(386, false));
		$this->assertSame('שפ״ז', $calendar->numberToHebrewNumerals(387, false));
		$this->assertSame('שפ״ח', $calendar->numberToHebrewNumerals(388, false));
		$this->assertSame('שפ״ט', $calendar->numberToHebrewNumerals(389, false));
		$this->assertSame('ש״ץ', $calendar->numberToHebrewNumerals(390, false));
		$this->assertSame('שצ״א', $calendar->numberToHebrewNumerals(391, false));
		$this->assertSame('שצ״ב', $calendar->numberToHebrewNumerals(392, false));
		$this->assertSame('שצ״ג', $calendar->numberToHebrewNumerals(393, false));
		$this->assertSame('שצ״ד', $calendar->numberToHebrewNumerals(394, false));
		$this->assertSame('שצ״ה', $calendar->numberToHebrewNumerals(395, false));
		$this->assertSame('שצ״ו', $calendar->numberToHebrewNumerals(396, false));
		$this->assertSame('שצ״ז', $calendar->numberToHebrewNumerals(397, false));
		$this->assertSame('שצ״ח', $calendar->numberToHebrewNumerals(398, false));
		$this->assertSame('שצ״ט', $calendar->numberToHebrewNumerals(399, false));
		$this->assertSame('ת׳', $calendar->numberToHebrewNumerals(400, false));
		$this->assertSame('ת״א', $calendar->numberToHebrewNumerals(401, false));
		$this->assertSame('ת״ב', $calendar->numberToHebrewNumerals(402, false));
		$this->assertSame('ת״ג', $calendar->numberToHebrewNumerals(403, false));
		$this->assertSame('ת״ד', $calendar->numberToHebrewNumerals(404, false));
		$this->assertSame('ת״ה', $calendar->numberToHebrewNumerals(405, false));
		$this->assertSame('ת״ו', $calendar->numberToHebrewNumerals(406, false));
		$this->assertSame('ת״ז', $calendar->numberToHebrewNumerals(407, false));
		$this->assertSame('ת״ח', $calendar->numberToHebrewNumerals(408, false));
		$this->assertSame('ת״ט', $calendar->numberToHebrewNumerals(409, false));
		$this->assertSame('ת״י', $calendar->numberToHebrewNumerals(410, false));
		$this->assertSame('תי״א', $calendar->numberToHebrewNumerals(411, false));
		$this->assertSame('תי״ב', $calendar->numberToHebrewNumerals(412, false));
		$this->assertSame('תי״ג', $calendar->numberToHebrewNumerals(413, false));
		$this->assertSame('תי״ד', $calendar->numberToHebrewNumerals(414, false));
		$this->assertSame('תט״ו', $calendar->numberToHebrewNumerals(415, false));
		$this->assertSame('תט״ז', $calendar->numberToHebrewNumerals(416, false));
		$this->assertSame('תי״ז', $calendar->numberToHebrewNumerals(417, false));
		$this->assertSame('תי״ח', $calendar->numberToHebrewNumerals(418, false));
		$this->assertSame('תי״ט', $calendar->numberToHebrewNumerals(419, false));
		$this->assertSame('ת״ך', $calendar->numberToHebrewNumerals(420, false));
		$this->assertSame('תצ״ט', $calendar->numberToHebrewNumerals(499, false));
		$this->assertSame('ת״ק', $calendar->numberToHebrewNumerals(500, false));
		$this->assertSame('תק״א', $calendar->numberToHebrewNumerals(501, false));
		$this->assertSame('תק״ב', $calendar->numberToHebrewNumerals(502, false));
		$this->assertSame('תק״ג', $calendar->numberToHebrewNumerals(503, false));
		$this->assertSame('תק״ד', $calendar->numberToHebrewNumerals(504, false));
		$this->assertSame('תק״ה', $calendar->numberToHebrewNumerals(505, false));
		$this->assertSame('תק״ו', $calendar->numberToHebrewNumerals(506, false));
		$this->assertSame('תק״ז', $calendar->numberToHebrewNumerals(507, false));
		$this->assertSame('תק״ח', $calendar->numberToHebrewNumerals(508, false));
		$this->assertSame('תק״ט', $calendar->numberToHebrewNumerals(509, false));
		$this->assertSame('תק״י', $calendar->numberToHebrewNumerals(510, false));
		$this->assertSame('תקי״א', $calendar->numberToHebrewNumerals(511, false));
		$this->assertSame('תקי״ב', $calendar->numberToHebrewNumerals(512, false));
		$this->assertSame('תקי״ג', $calendar->numberToHebrewNumerals(513, false));
		$this->assertSame('תקי״ד', $calendar->numberToHebrewNumerals(514, false));
		$this->assertSame('תקט״ו', $calendar->numberToHebrewNumerals(515, false));
		$this->assertSame('תקט״ז', $calendar->numberToHebrewNumerals(516, false));
		$this->assertSame('תקי״ז', $calendar->numberToHebrewNumerals(517, false));
		$this->assertSame('תקי״ח', $calendar->numberToHebrewNumerals(518, false));
		$this->assertSame('תקי״ט', $calendar->numberToHebrewNumerals(519, false));
		$this->assertSame('תק״ך', $calendar->numberToHebrewNumerals(520, false));
		$this->assertSame('תקצ״ט', $calendar->numberToHebrewNumerals(599, false));
		$this->assertSame('ת״ר', $calendar->numberToHebrewNumerals(600, false));
		$this->assertSame('תר״א', $calendar->numberToHebrewNumerals(601, false));
		$this->assertSame('תר״ב', $calendar->numberToHebrewNumerals(602, false));
		$this->assertSame('תר״ג', $calendar->numberToHebrewNumerals(603, false));
		$this->assertSame('תר״ד', $calendar->numberToHebrewNumerals(604, false));
		$this->assertSame('תר״ה', $calendar->numberToHebrewNumerals(605, false));
		$this->assertSame('תר״ו', $calendar->numberToHebrewNumerals(606, false));
		$this->assertSame('תר״ז', $calendar->numberToHebrewNumerals(607, false));
		$this->assertSame('תר״ח', $calendar->numberToHebrewNumerals(608, false));
		$this->assertSame('תר״ט', $calendar->numberToHebrewNumerals(609, false));
		$this->assertSame('תר״י', $calendar->numberToHebrewNumerals(610, false));
		$this->assertSame('תרי״א', $calendar->numberToHebrewNumerals(611, false));
		$this->assertSame('תרי״ב', $calendar->numberToHebrewNumerals(612, false));
		$this->assertSame('תרי״ג', $calendar->numberToHebrewNumerals(613, false));
		$this->assertSame('תרי״ד', $calendar->numberToHebrewNumerals(614, false));
		$this->assertSame('תרט״ו', $calendar->numberToHebrewNumerals(615, false));
		$this->assertSame('תרט״ז', $calendar->numberToHebrewNumerals(616, false));
		$this->assertSame('תרי״ז', $calendar->numberToHebrewNumerals(617, false));
		$this->assertSame('תרי״ח', $calendar->numberToHebrewNumerals(618, false));
		$this->assertSame('תרי״ט', $calendar->numberToHebrewNumerals(619, false));
		$this->assertSame('תר״ך', $calendar->numberToHebrewNumerals(620, false));
		$this->assertSame('תרצ״ט', $calendar->numberToHebrewNumerals(699, false));
		$this->assertSame('ת״ש', $calendar->numberToHebrewNumerals(700, false));
		$this->assertSame('תש״א', $calendar->numberToHebrewNumerals(701, false));
		$this->assertSame('תש״ב', $calendar->numberToHebrewNumerals(702, false));
		$this->assertSame('תש״ג', $calendar->numberToHebrewNumerals(703, false));
		$this->assertSame('תש״ד', $calendar->numberToHebrewNumerals(704, false));
		$this->assertSame('תש״ה', $calendar->numberToHebrewNumerals(705, false));
		$this->assertSame('תש״ו', $calendar->numberToHebrewNumerals(706, false));
		$this->assertSame('תש״ז', $calendar->numberToHebrewNumerals(707, false));
		$this->assertSame('תש״ח', $calendar->numberToHebrewNumerals(708, false));
		$this->assertSame('תש״ט', $calendar->numberToHebrewNumerals(709, false));
		$this->assertSame('תש״י', $calendar->numberToHebrewNumerals(710, false));
		$this->assertSame('תשי״א', $calendar->numberToHebrewNumerals(711, false));
		$this->assertSame('תשי״ב', $calendar->numberToHebrewNumerals(712, false));
		$this->assertSame('תשי״ג', $calendar->numberToHebrewNumerals(713, false));
		$this->assertSame('תשי״ד', $calendar->numberToHebrewNumerals(714, false));
		$this->assertSame('תשט״ו', $calendar->numberToHebrewNumerals(715, false));
		$this->assertSame('תשט״ז', $calendar->numberToHebrewNumerals(716, false));
		$this->assertSame('תשי״ז', $calendar->numberToHebrewNumerals(717, false));
		$this->assertSame('תשי״ח', $calendar->numberToHebrewNumerals(718, false));
		$this->assertSame('תשי״ט', $calendar->numberToHebrewNumerals(719, false));
		$this->assertSame('תש״ך', $calendar->numberToHebrewNumerals(720, false));
		$this->assertSame('תשצ״ט', $calendar->numberToHebrewNumerals(799, false));
		$this->assertSame('ת״ת', $calendar->numberToHebrewNumerals(800, false));
		$this->assertSame('תת״א', $calendar->numberToHebrewNumerals(801, false));
		$this->assertSame('תת״ב', $calendar->numberToHebrewNumerals(802, false));
		$this->assertSame('תת״ג', $calendar->numberToHebrewNumerals(803, false));
		$this->assertSame('תת״ד', $calendar->numberToHebrewNumerals(804, false));
		$this->assertSame('תת״ה', $calendar->numberToHebrewNumerals(805, false));
		$this->assertSame('תת״ו', $calendar->numberToHebrewNumerals(806, false));
		$this->assertSame('תת״ז', $calendar->numberToHebrewNumerals(807, false));
		$this->assertSame('תת״ח', $calendar->numberToHebrewNumerals(808, false));
		$this->assertSame('תת״ט', $calendar->numberToHebrewNumerals(809, false));
		$this->assertSame('תת״י', $calendar->numberToHebrewNumerals(810, false));
		$this->assertSame('תתי״א', $calendar->numberToHebrewNumerals(811, false));
		$this->assertSame('תתי״ב', $calendar->numberToHebrewNumerals(812, false));
		$this->assertSame('תתי״ג', $calendar->numberToHebrewNumerals(813, false));
		$this->assertSame('תתי״ד', $calendar->numberToHebrewNumerals(814, false));
		$this->assertSame('תתט״ו', $calendar->numberToHebrewNumerals(815, false));
		$this->assertSame('תתט״ז', $calendar->numberToHebrewNumerals(816, false));
		$this->assertSame('תתי״ז', $calendar->numberToHebrewNumerals(817, false));
		$this->assertSame('תתי״ח', $calendar->numberToHebrewNumerals(818, false));
		$this->assertSame('תתי״ט', $calendar->numberToHebrewNumerals(819, false));
		$this->assertSame('תת״ך', $calendar->numberToHebrewNumerals(820, false));
		$this->assertSame('תתצ״ט', $calendar->numberToHebrewNumerals(899, false));
		$this->assertSame('תת״ק', $calendar->numberToHebrewNumerals(900, false));
		$this->assertSame('תתק״א', $calendar->numberToHebrewNumerals(901, false));
		$this->assertSame('תתק״ב', $calendar->numberToHebrewNumerals(902, false));
		$this->assertSame('תתק״ג', $calendar->numberToHebrewNumerals(903, false));
		$this->assertSame('תתק״ד', $calendar->numberToHebrewNumerals(904, false));
		$this->assertSame('תתק״ה', $calendar->numberToHebrewNumerals(905, false));
		$this->assertSame('תתק״ו', $calendar->numberToHebrewNumerals(906, false));
		$this->assertSame('תתק״ז', $calendar->numberToHebrewNumerals(907, false));
		$this->assertSame('תתק״ח', $calendar->numberToHebrewNumerals(908, false));
		$this->assertSame('תתק״ט', $calendar->numberToHebrewNumerals(909, false));
		$this->assertSame('תתק״י', $calendar->numberToHebrewNumerals(910, false));
		$this->assertSame('תתקי״א', $calendar->numberToHebrewNumerals(911, false));
		$this->assertSame('תתקי״ב', $calendar->numberToHebrewNumerals(912, false));
		$this->assertSame('תתקי״ג', $calendar->numberToHebrewNumerals(913, false));
		$this->assertSame('תתקי״ד', $calendar->numberToHebrewNumerals(914, false));
		$this->assertSame('תתקט״ו', $calendar->numberToHebrewNumerals(915, false));
		$this->assertSame('תתקט״ז', $calendar->numberToHebrewNumerals(916, false));
		$this->assertSame('תתקי״ז', $calendar->numberToHebrewNumerals(917, false));
		$this->assertSame('תתקי״ח', $calendar->numberToHebrewNumerals(918, false));
		$this->assertSame('תתקי״ט', $calendar->numberToHebrewNumerals(919, false));
		$this->assertSame('תתק״ך', $calendar->numberToHebrewNumerals(920, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(999, false));
		$this->assertSame('א׳ אלפים', $calendar->numberToHebrewNumerals(1000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(1001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(1002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(1003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(1004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(1005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(1006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(1007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(1008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(1009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(1010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(1011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(1012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(1013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(1014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(1015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(1016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(1017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(1018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(1019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(1020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(1999, false));
		$this->assertSame('ב׳ אלפים', $calendar->numberToHebrewNumerals(2000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(2001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(2002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(2003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(2004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(2005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(2006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(2007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(2008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(2009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(2010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(2011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(2012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(2013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(2014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(2015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(2016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(2017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(2018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(2019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(2020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(2999, false));
		$this->assertSame('ג׳ אלפים', $calendar->numberToHebrewNumerals(3000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(3001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(3002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(3003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(3004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(3005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(3006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(3007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(3008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(3009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(3010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(3011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(3012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(3013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(3014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(3015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(3016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(3017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(3018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(3019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(3020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(3999, false));
		$this->assertSame('ד׳ אלפים', $calendar->numberToHebrewNumerals(4000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(4001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(4002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(4003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(4004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(4005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(4006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(4007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(4008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(4009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(4010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(4011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(4012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(4013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(4014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(4015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(4016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(4017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(4018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(4019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(4020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(4999, false));
		$this->assertSame('ה׳ אלפים', $calendar->numberToHebrewNumerals(5000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(5001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(5002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(5003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(5004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(5005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(5006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(5007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(5008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(5009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(5010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(5011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(5012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(5013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(5014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(5015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(5016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(5017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(5018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(5019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(5020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(5999, false));
		$this->assertSame('ו׳ אלפים', $calendar->numberToHebrewNumerals(6000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(6001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(6002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(6003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(6004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(6005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(6006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(6007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(6008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(6009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(6010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(6011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(6012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(6013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(6014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(6015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(6016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(6017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(6018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(6019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(6020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(6999, false));
		$this->assertSame('ז׳ אלפים', $calendar->numberToHebrewNumerals(7000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(7001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(7002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(7003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(7004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(7005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(7006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(7007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(7008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(7009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(7010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(7011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(7012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(7013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(7014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(7015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(7016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(7017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(7018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(7019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(7020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(7999, false));
		$this->assertSame('ח׳ אלפים', $calendar->numberToHebrewNumerals(8000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(8001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(8002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(8003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(8004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(8005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(8006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(8007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(8008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(8009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(8010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(8011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(8012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(8013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(8014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(8015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(8016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(8017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(8018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(8019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(8020, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(8999, false));
		$this->assertSame('ט׳ אלפים', $calendar->numberToHebrewNumerals(9000, false));
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(9001, false));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(9002, false));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(9003, false));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(9004, false));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(9005, false));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(9006, false));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(9007, false));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(9008, false));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(9009, false));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(9010, false));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(9011, false));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(9012, false));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(9013, false));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(9014, false));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(9015, false));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(9016, false));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(9017, false));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(9018, false));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(9019, false));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(9020, false));
		$this->assertSame('תתק״ץ', $calendar->numberToHebrewNumerals(9990, false));
		$this->assertSame('תתקצ״א', $calendar->numberToHebrewNumerals(9991, false));
		$this->assertSame('תתקצ״ב', $calendar->numberToHebrewNumerals(9992, false));
		$this->assertSame('תתקצ״ג', $calendar->numberToHebrewNumerals(9993, false));
		$this->assertSame('תתקצ״ד', $calendar->numberToHebrewNumerals(9994, false));
		$this->assertSame('תתקצ״ה', $calendar->numberToHebrewNumerals(9995, false));
		$this->assertSame('תתקצ״ו', $calendar->numberToHebrewNumerals(9996, false));
		$this->assertSame('תתקצ״ז', $calendar->numberToHebrewNumerals(9997, false));
		$this->assertSame('תתקצ״ח', $calendar->numberToHebrewNumerals(9998, false));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(9999, false));
	}

	/**
	 * Test the conversion of numbers into Hebrew numerals.
	 *
	 * @large This test can take several seconds to run.
	 *
	 * @return void
	 */
	public function testNumberToHebrewNumeralsLong() {
		$calendar = new JewishCalendar;
		$this->assertSame('א׳', $calendar->numberToHebrewNumerals(1, true));
		$this->assertSame('ב׳', $calendar->numberToHebrewNumerals(2, true));
		$this->assertSame('ג׳', $calendar->numberToHebrewNumerals(3, true));
		$this->assertSame('ד׳', $calendar->numberToHebrewNumerals(4, true));
		$this->assertSame('ה׳', $calendar->numberToHebrewNumerals(5, true));
		$this->assertSame('ו׳', $calendar->numberToHebrewNumerals(6, true));
		$this->assertSame('ז׳', $calendar->numberToHebrewNumerals(7, true));
		$this->assertSame('ח׳', $calendar->numberToHebrewNumerals(8, true));
		$this->assertSame('ט׳', $calendar->numberToHebrewNumerals(9, true));
		$this->assertSame('י׳', $calendar->numberToHebrewNumerals(10, true));
		$this->assertSame('י״א', $calendar->numberToHebrewNumerals(11, true));
		$this->assertSame('י״ב', $calendar->numberToHebrewNumerals(12, true));
		$this->assertSame('י״ג', $calendar->numberToHebrewNumerals(13, true));
		$this->assertSame('י״ד', $calendar->numberToHebrewNumerals(14, true));
		$this->assertSame('ט״ו', $calendar->numberToHebrewNumerals(15, true));
		$this->assertSame('ט״ז', $calendar->numberToHebrewNumerals(16, true));
		$this->assertSame('י״ז', $calendar->numberToHebrewNumerals(17, true));
		$this->assertSame('י״ח', $calendar->numberToHebrewNumerals(18, true));
		$this->assertSame('י״ט', $calendar->numberToHebrewNumerals(19, true));
		$this->assertSame('כ׳', $calendar->numberToHebrewNumerals(20, true));
		$this->assertSame('כ״א', $calendar->numberToHebrewNumerals(21, true));
		$this->assertSame('כ״ב', $calendar->numberToHebrewNumerals(22, true));
		$this->assertSame('כ״ג', $calendar->numberToHebrewNumerals(23, true));
		$this->assertSame('כ״ד', $calendar->numberToHebrewNumerals(24, true));
		$this->assertSame('כ״ה', $calendar->numberToHebrewNumerals(25, true));
		$this->assertSame('כ״ו', $calendar->numberToHebrewNumerals(26, true));
		$this->assertSame('כ״ז', $calendar->numberToHebrewNumerals(27, true));
		$this->assertSame('כ״ח', $calendar->numberToHebrewNumerals(28, true));
		$this->assertSame('כ״ט', $calendar->numberToHebrewNumerals(29, true));
		$this->assertSame('ל׳', $calendar->numberToHebrewNumerals(30, true));
		$this->assertSame('ל״א', $calendar->numberToHebrewNumerals(31, true));
		$this->assertSame('ל״ב', $calendar->numberToHebrewNumerals(32, true));
		$this->assertSame('ל״ג', $calendar->numberToHebrewNumerals(33, true));
		$this->assertSame('ל״ד', $calendar->numberToHebrewNumerals(34, true));
		$this->assertSame('ל״ה', $calendar->numberToHebrewNumerals(35, true));
		$this->assertSame('ל״ו', $calendar->numberToHebrewNumerals(36, true));
		$this->assertSame('ל״ז', $calendar->numberToHebrewNumerals(37, true));
		$this->assertSame('ל״ח', $calendar->numberToHebrewNumerals(38, true));
		$this->assertSame('ל״ט', $calendar->numberToHebrewNumerals(39, true));
		$this->assertSame('מ׳', $calendar->numberToHebrewNumerals(40, true));
		$this->assertSame('מ״א', $calendar->numberToHebrewNumerals(41, true));
		$this->assertSame('מ״ב', $calendar->numberToHebrewNumerals(42, true));
		$this->assertSame('מ״ג', $calendar->numberToHebrewNumerals(43, true));
		$this->assertSame('מ״ד', $calendar->numberToHebrewNumerals(44, true));
		$this->assertSame('מ״ה', $calendar->numberToHebrewNumerals(45, true));
		$this->assertSame('מ״ו', $calendar->numberToHebrewNumerals(46, true));
		$this->assertSame('מ״ז', $calendar->numberToHebrewNumerals(47, true));
		$this->assertSame('מ״ח', $calendar->numberToHebrewNumerals(48, true));
		$this->assertSame('מ״ט', $calendar->numberToHebrewNumerals(49, true));
		$this->assertSame('נ׳', $calendar->numberToHebrewNumerals(50, true));
		$this->assertSame('נ״א', $calendar->numberToHebrewNumerals(51, true));
		$this->assertSame('נ״ב', $calendar->numberToHebrewNumerals(52, true));
		$this->assertSame('נ״ג', $calendar->numberToHebrewNumerals(53, true));
		$this->assertSame('נ״ד', $calendar->numberToHebrewNumerals(54, true));
		$this->assertSame('נ״ה', $calendar->numberToHebrewNumerals(55, true));
		$this->assertSame('נ״ו', $calendar->numberToHebrewNumerals(56, true));
		$this->assertSame('נ״ז', $calendar->numberToHebrewNumerals(57, true));
		$this->assertSame('נ״ח', $calendar->numberToHebrewNumerals(58, true));
		$this->assertSame('נ״ט', $calendar->numberToHebrewNumerals(59, true));
		$this->assertSame('ס׳', $calendar->numberToHebrewNumerals(60, true));
		$this->assertSame('ס״א', $calendar->numberToHebrewNumerals(61, true));
		$this->assertSame('ס״ב', $calendar->numberToHebrewNumerals(62, true));
		$this->assertSame('ס״ג', $calendar->numberToHebrewNumerals(63, true));
		$this->assertSame('ס״ד', $calendar->numberToHebrewNumerals(64, true));
		$this->assertSame('ס״ה', $calendar->numberToHebrewNumerals(65, true));
		$this->assertSame('ס״ו', $calendar->numberToHebrewNumerals(66, true));
		$this->assertSame('ס״ז', $calendar->numberToHebrewNumerals(67, true));
		$this->assertSame('ס״ח', $calendar->numberToHebrewNumerals(68, true));
		$this->assertSame('ס״ט', $calendar->numberToHebrewNumerals(69, true));
		$this->assertSame('ע׳', $calendar->numberToHebrewNumerals(70, true));
		$this->assertSame('ע״א', $calendar->numberToHebrewNumerals(71, true));
		$this->assertSame('ע״ב', $calendar->numberToHebrewNumerals(72, true));
		$this->assertSame('ע״ג', $calendar->numberToHebrewNumerals(73, true));
		$this->assertSame('ע״ד', $calendar->numberToHebrewNumerals(74, true));
		$this->assertSame('ע״ה', $calendar->numberToHebrewNumerals(75, true));
		$this->assertSame('ע״ו', $calendar->numberToHebrewNumerals(76, true));
		$this->assertSame('ע״ז', $calendar->numberToHebrewNumerals(77, true));
		$this->assertSame('ע״ח', $calendar->numberToHebrewNumerals(78, true));
		$this->assertSame('ע״ט', $calendar->numberToHebrewNumerals(79, true));
		$this->assertSame('פ׳', $calendar->numberToHebrewNumerals(80, true));
		$this->assertSame('פ״א', $calendar->numberToHebrewNumerals(81, true));
		$this->assertSame('פ״ב', $calendar->numberToHebrewNumerals(82, true));
		$this->assertSame('פ״ג', $calendar->numberToHebrewNumerals(83, true));
		$this->assertSame('פ״ד', $calendar->numberToHebrewNumerals(84, true));
		$this->assertSame('פ״ה', $calendar->numberToHebrewNumerals(85, true));
		$this->assertSame('פ״ו', $calendar->numberToHebrewNumerals(86, true));
		$this->assertSame('פ״ז', $calendar->numberToHebrewNumerals(87, true));
		$this->assertSame('פ״ח', $calendar->numberToHebrewNumerals(88, true));
		$this->assertSame('פ״ט', $calendar->numberToHebrewNumerals(89, true));
		$this->assertSame('צ׳', $calendar->numberToHebrewNumerals(90, true));
		$this->assertSame('צ״א', $calendar->numberToHebrewNumerals(91, true));
		$this->assertSame('צ״ב', $calendar->numberToHebrewNumerals(92, true));
		$this->assertSame('צ״ג', $calendar->numberToHebrewNumerals(93, true));
		$this->assertSame('צ״ד', $calendar->numberToHebrewNumerals(94, true));
		$this->assertSame('צ״ה', $calendar->numberToHebrewNumerals(95, true));
		$this->assertSame('צ״ו', $calendar->numberToHebrewNumerals(96, true));
		$this->assertSame('צ״ז', $calendar->numberToHebrewNumerals(97, true));
		$this->assertSame('צ״ח', $calendar->numberToHebrewNumerals(98, true));
		$this->assertSame('צ״ט', $calendar->numberToHebrewNumerals(99, true));
		$this->assertSame('ק׳', $calendar->numberToHebrewNumerals(100, true));
		$this->assertSame('ק״א', $calendar->numberToHebrewNumerals(101, true));
		$this->assertSame('ק״ב', $calendar->numberToHebrewNumerals(102, true));
		$this->assertSame('ק״ג', $calendar->numberToHebrewNumerals(103, true));
		$this->assertSame('ק״ד', $calendar->numberToHebrewNumerals(104, true));
		$this->assertSame('ק״ה', $calendar->numberToHebrewNumerals(105, true));
		$this->assertSame('ק״ו', $calendar->numberToHebrewNumerals(106, true));
		$this->assertSame('ק״ז', $calendar->numberToHebrewNumerals(107, true));
		$this->assertSame('ק״ח', $calendar->numberToHebrewNumerals(108, true));
		$this->assertSame('ק״ט', $calendar->numberToHebrewNumerals(109, true));
		$this->assertSame('ק״י', $calendar->numberToHebrewNumerals(110, true));
		$this->assertSame('קי״א', $calendar->numberToHebrewNumerals(111, true));
		$this->assertSame('קי״ב', $calendar->numberToHebrewNumerals(112, true));
		$this->assertSame('קי״ג', $calendar->numberToHebrewNumerals(113, true));
		$this->assertSame('קי״ד', $calendar->numberToHebrewNumerals(114, true));
		$this->assertSame('קט״ו', $calendar->numberToHebrewNumerals(115, true));
		$this->assertSame('קט״ז', $calendar->numberToHebrewNumerals(116, true));
		$this->assertSame('קי״ז', $calendar->numberToHebrewNumerals(117, true));
		$this->assertSame('קי״ח', $calendar->numberToHebrewNumerals(118, true));
		$this->assertSame('קי״ט', $calendar->numberToHebrewNumerals(119, true));
		$this->assertSame('ק״ך', $calendar->numberToHebrewNumerals(120, true));
		$this->assertSame('קכ״א', $calendar->numberToHebrewNumerals(121, true));
		$this->assertSame('קכ״ב', $calendar->numberToHebrewNumerals(122, true));
		$this->assertSame('קכ״ג', $calendar->numberToHebrewNumerals(123, true));
		$this->assertSame('קכ״ד', $calendar->numberToHebrewNumerals(124, true));
		$this->assertSame('קכ״ה', $calendar->numberToHebrewNumerals(125, true));
		$this->assertSame('קכ״ו', $calendar->numberToHebrewNumerals(126, true));
		$this->assertSame('קכ״ז', $calendar->numberToHebrewNumerals(127, true));
		$this->assertSame('קכ״ח', $calendar->numberToHebrewNumerals(128, true));
		$this->assertSame('קכ״ט', $calendar->numberToHebrewNumerals(129, true));
		$this->assertSame('ק״ל', $calendar->numberToHebrewNumerals(130, true));
		$this->assertSame('קל״א', $calendar->numberToHebrewNumerals(131, true));
		$this->assertSame('קל״ב', $calendar->numberToHebrewNumerals(132, true));
		$this->assertSame('קל״ג', $calendar->numberToHebrewNumerals(133, true));
		$this->assertSame('קל״ד', $calendar->numberToHebrewNumerals(134, true));
		$this->assertSame('קל״ה', $calendar->numberToHebrewNumerals(135, true));
		$this->assertSame('קל״ו', $calendar->numberToHebrewNumerals(136, true));
		$this->assertSame('קל״ז', $calendar->numberToHebrewNumerals(137, true));
		$this->assertSame('קל״ח', $calendar->numberToHebrewNumerals(138, true));
		$this->assertSame('קל״ט', $calendar->numberToHebrewNumerals(139, true));
		$this->assertSame('ק״ם', $calendar->numberToHebrewNumerals(140, true));
		$this->assertSame('קמ״א', $calendar->numberToHebrewNumerals(141, true));
		$this->assertSame('קמ״ב', $calendar->numberToHebrewNumerals(142, true));
		$this->assertSame('קמ״ג', $calendar->numberToHebrewNumerals(143, true));
		$this->assertSame('קמ״ד', $calendar->numberToHebrewNumerals(144, true));
		$this->assertSame('קמ״ה', $calendar->numberToHebrewNumerals(145, true));
		$this->assertSame('קמ״ו', $calendar->numberToHebrewNumerals(146, true));
		$this->assertSame('קמ״ז', $calendar->numberToHebrewNumerals(147, true));
		$this->assertSame('קמ״ח', $calendar->numberToHebrewNumerals(148, true));
		$this->assertSame('קמ״ט', $calendar->numberToHebrewNumerals(149, true));
		$this->assertSame('ק״ן', $calendar->numberToHebrewNumerals(150, true));
		$this->assertSame('קנ״א', $calendar->numberToHebrewNumerals(151, true));
		$this->assertSame('קנ״ב', $calendar->numberToHebrewNumerals(152, true));
		$this->assertSame('קנ״ג', $calendar->numberToHebrewNumerals(153, true));
		$this->assertSame('קנ״ד', $calendar->numberToHebrewNumerals(154, true));
		$this->assertSame('קנ״ה', $calendar->numberToHebrewNumerals(155, true));
		$this->assertSame('קנ״ו', $calendar->numberToHebrewNumerals(156, true));
		$this->assertSame('קנ״ז', $calendar->numberToHebrewNumerals(157, true));
		$this->assertSame('קנ״ח', $calendar->numberToHebrewNumerals(158, true));
		$this->assertSame('קנ״ט', $calendar->numberToHebrewNumerals(159, true));
		$this->assertSame('ק״ס', $calendar->numberToHebrewNumerals(160, true));
		$this->assertSame('קס״א', $calendar->numberToHebrewNumerals(161, true));
		$this->assertSame('קס״ב', $calendar->numberToHebrewNumerals(162, true));
		$this->assertSame('קס״ג', $calendar->numberToHebrewNumerals(163, true));
		$this->assertSame('קס״ד', $calendar->numberToHebrewNumerals(164, true));
		$this->assertSame('קס״ה', $calendar->numberToHebrewNumerals(165, true));
		$this->assertSame('קס״ו', $calendar->numberToHebrewNumerals(166, true));
		$this->assertSame('קס״ז', $calendar->numberToHebrewNumerals(167, true));
		$this->assertSame('קס״ח', $calendar->numberToHebrewNumerals(168, true));
		$this->assertSame('קס״ט', $calendar->numberToHebrewNumerals(169, true));
		$this->assertSame('ק״ע', $calendar->numberToHebrewNumerals(170, true));
		$this->assertSame('קע״א', $calendar->numberToHebrewNumerals(171, true));
		$this->assertSame('קע״ב', $calendar->numberToHebrewNumerals(172, true));
		$this->assertSame('קע״ג', $calendar->numberToHebrewNumerals(173, true));
		$this->assertSame('קע״ד', $calendar->numberToHebrewNumerals(174, true));
		$this->assertSame('קע״ה', $calendar->numberToHebrewNumerals(175, true));
		$this->assertSame('קע״ו', $calendar->numberToHebrewNumerals(176, true));
		$this->assertSame('קע״ז', $calendar->numberToHebrewNumerals(177, true));
		$this->assertSame('קע״ח', $calendar->numberToHebrewNumerals(178, true));
		$this->assertSame('קע״ט', $calendar->numberToHebrewNumerals(179, true));
		$this->assertSame('ק״ף', $calendar->numberToHebrewNumerals(180, true));
		$this->assertSame('קפ״א', $calendar->numberToHebrewNumerals(181, true));
		$this->assertSame('קפ״ב', $calendar->numberToHebrewNumerals(182, true));
		$this->assertSame('קפ״ג', $calendar->numberToHebrewNumerals(183, true));
		$this->assertSame('קפ״ד', $calendar->numberToHebrewNumerals(184, true));
		$this->assertSame('קפ״ה', $calendar->numberToHebrewNumerals(185, true));
		$this->assertSame('קפ״ו', $calendar->numberToHebrewNumerals(186, true));
		$this->assertSame('קפ״ז', $calendar->numberToHebrewNumerals(187, true));
		$this->assertSame('קפ״ח', $calendar->numberToHebrewNumerals(188, true));
		$this->assertSame('קפ״ט', $calendar->numberToHebrewNumerals(189, true));
		$this->assertSame('ק״ץ', $calendar->numberToHebrewNumerals(190, true));
		$this->assertSame('קצ״א', $calendar->numberToHebrewNumerals(191, true));
		$this->assertSame('קצ״ב', $calendar->numberToHebrewNumerals(192, true));
		$this->assertSame('קצ״ג', $calendar->numberToHebrewNumerals(193, true));
		$this->assertSame('קצ״ד', $calendar->numberToHebrewNumerals(194, true));
		$this->assertSame('קצ״ה', $calendar->numberToHebrewNumerals(195, true));
		$this->assertSame('קצ״ו', $calendar->numberToHebrewNumerals(196, true));
		$this->assertSame('קצ״ז', $calendar->numberToHebrewNumerals(197, true));
		$this->assertSame('קצ״ח', $calendar->numberToHebrewNumerals(198, true));
		$this->assertSame('קצ״ט', $calendar->numberToHebrewNumerals(199, true));
		$this->assertSame('ר׳', $calendar->numberToHebrewNumerals(200, true));
		$this->assertSame('ר״א', $calendar->numberToHebrewNumerals(201, true));
		$this->assertSame('ר״ב', $calendar->numberToHebrewNumerals(202, true));
		$this->assertSame('ר״ג', $calendar->numberToHebrewNumerals(203, true));
		$this->assertSame('ר״ד', $calendar->numberToHebrewNumerals(204, true));
		$this->assertSame('ר״ה', $calendar->numberToHebrewNumerals(205, true));
		$this->assertSame('ר״ו', $calendar->numberToHebrewNumerals(206, true));
		$this->assertSame('ר״ז', $calendar->numberToHebrewNumerals(207, true));
		$this->assertSame('ר״ח', $calendar->numberToHebrewNumerals(208, true));
		$this->assertSame('ר״ט', $calendar->numberToHebrewNumerals(209, true));
		$this->assertSame('ר״י', $calendar->numberToHebrewNumerals(210, true));
		$this->assertSame('רי״א', $calendar->numberToHebrewNumerals(211, true));
		$this->assertSame('רי״ב', $calendar->numberToHebrewNumerals(212, true));
		$this->assertSame('רי״ג', $calendar->numberToHebrewNumerals(213, true));
		$this->assertSame('רי״ד', $calendar->numberToHebrewNumerals(214, true));
		$this->assertSame('רט״ו', $calendar->numberToHebrewNumerals(215, true));
		$this->assertSame('רט״ז', $calendar->numberToHebrewNumerals(216, true));
		$this->assertSame('רי״ז', $calendar->numberToHebrewNumerals(217, true));
		$this->assertSame('רי״ח', $calendar->numberToHebrewNumerals(218, true));
		$this->assertSame('רי״ט', $calendar->numberToHebrewNumerals(219, true));
		$this->assertSame('ר״ך', $calendar->numberToHebrewNumerals(220, true));
		$this->assertSame('רכ״א', $calendar->numberToHebrewNumerals(221, true));
		$this->assertSame('רכ״ב', $calendar->numberToHebrewNumerals(222, true));
		$this->assertSame('רכ״ג', $calendar->numberToHebrewNumerals(223, true));
		$this->assertSame('רכ״ד', $calendar->numberToHebrewNumerals(224, true));
		$this->assertSame('רכ״ה', $calendar->numberToHebrewNumerals(225, true));
		$this->assertSame('רכ״ו', $calendar->numberToHebrewNumerals(226, true));
		$this->assertSame('רכ״ז', $calendar->numberToHebrewNumerals(227, true));
		$this->assertSame('רכ״ח', $calendar->numberToHebrewNumerals(228, true));
		$this->assertSame('רכ״ט', $calendar->numberToHebrewNumerals(229, true));
		$this->assertSame('ר״ל', $calendar->numberToHebrewNumerals(230, true));
		$this->assertSame('רל״א', $calendar->numberToHebrewNumerals(231, true));
		$this->assertSame('רל״ב', $calendar->numberToHebrewNumerals(232, true));
		$this->assertSame('רל״ג', $calendar->numberToHebrewNumerals(233, true));
		$this->assertSame('רל״ד', $calendar->numberToHebrewNumerals(234, true));
		$this->assertSame('רל״ה', $calendar->numberToHebrewNumerals(235, true));
		$this->assertSame('רל״ו', $calendar->numberToHebrewNumerals(236, true));
		$this->assertSame('רל״ז', $calendar->numberToHebrewNumerals(237, true));
		$this->assertSame('רל״ח', $calendar->numberToHebrewNumerals(238, true));
		$this->assertSame('רל״ט', $calendar->numberToHebrewNumerals(239, true));
		$this->assertSame('ר״ם', $calendar->numberToHebrewNumerals(240, true));
		$this->assertSame('רמ״א', $calendar->numberToHebrewNumerals(241, true));
		$this->assertSame('רמ״ב', $calendar->numberToHebrewNumerals(242, true));
		$this->assertSame('רמ״ג', $calendar->numberToHebrewNumerals(243, true));
		$this->assertSame('רמ״ד', $calendar->numberToHebrewNumerals(244, true));
		$this->assertSame('רמ״ה', $calendar->numberToHebrewNumerals(245, true));
		$this->assertSame('רמ״ו', $calendar->numberToHebrewNumerals(246, true));
		$this->assertSame('רמ״ז', $calendar->numberToHebrewNumerals(247, true));
		$this->assertSame('רמ״ח', $calendar->numberToHebrewNumerals(248, true));
		$this->assertSame('רמ״ט', $calendar->numberToHebrewNumerals(249, true));
		$this->assertSame('ר״ן', $calendar->numberToHebrewNumerals(250, true));
		$this->assertSame('רנ״א', $calendar->numberToHebrewNumerals(251, true));
		$this->assertSame('רנ״ב', $calendar->numberToHebrewNumerals(252, true));
		$this->assertSame('רנ״ג', $calendar->numberToHebrewNumerals(253, true));
		$this->assertSame('רנ״ד', $calendar->numberToHebrewNumerals(254, true));
		$this->assertSame('רנ״ה', $calendar->numberToHebrewNumerals(255, true));
		$this->assertSame('רנ״ו', $calendar->numberToHebrewNumerals(256, true));
		$this->assertSame('רנ״ז', $calendar->numberToHebrewNumerals(257, true));
		$this->assertSame('רנ״ח', $calendar->numberToHebrewNumerals(258, true));
		$this->assertSame('רנ״ט', $calendar->numberToHebrewNumerals(259, true));
		$this->assertSame('ר״ס', $calendar->numberToHebrewNumerals(260, true));
		$this->assertSame('רס״א', $calendar->numberToHebrewNumerals(261, true));
		$this->assertSame('רס״ב', $calendar->numberToHebrewNumerals(262, true));
		$this->assertSame('רס״ג', $calendar->numberToHebrewNumerals(263, true));
		$this->assertSame('רס״ד', $calendar->numberToHebrewNumerals(264, true));
		$this->assertSame('רס״ה', $calendar->numberToHebrewNumerals(265, true));
		$this->assertSame('רס״ו', $calendar->numberToHebrewNumerals(266, true));
		$this->assertSame('רס״ז', $calendar->numberToHebrewNumerals(267, true));
		$this->assertSame('רס״ח', $calendar->numberToHebrewNumerals(268, true));
		$this->assertSame('רס״ט', $calendar->numberToHebrewNumerals(269, true));
		$this->assertSame('ר״ע', $calendar->numberToHebrewNumerals(270, true));
		$this->assertSame('רע״א', $calendar->numberToHebrewNumerals(271, true));
		$this->assertSame('רע״ב', $calendar->numberToHebrewNumerals(272, true));
		$this->assertSame('רע״ג', $calendar->numberToHebrewNumerals(273, true));
		$this->assertSame('רע״ד', $calendar->numberToHebrewNumerals(274, true));
		$this->assertSame('רע״ה', $calendar->numberToHebrewNumerals(275, true));
		$this->assertSame('רע״ו', $calendar->numberToHebrewNumerals(276, true));
		$this->assertSame('רע״ז', $calendar->numberToHebrewNumerals(277, true));
		$this->assertSame('רע״ח', $calendar->numberToHebrewNumerals(278, true));
		$this->assertSame('רע״ט', $calendar->numberToHebrewNumerals(279, true));
		$this->assertSame('ר״ף', $calendar->numberToHebrewNumerals(280, true));
		$this->assertSame('רפ״א', $calendar->numberToHebrewNumerals(281, true));
		$this->assertSame('רפ״ב', $calendar->numberToHebrewNumerals(282, true));
		$this->assertSame('רפ״ג', $calendar->numberToHebrewNumerals(283, true));
		$this->assertSame('רפ״ד', $calendar->numberToHebrewNumerals(284, true));
		$this->assertSame('רפ״ה', $calendar->numberToHebrewNumerals(285, true));
		$this->assertSame('רפ״ו', $calendar->numberToHebrewNumerals(286, true));
		$this->assertSame('רפ״ז', $calendar->numberToHebrewNumerals(287, true));
		$this->assertSame('רפ״ח', $calendar->numberToHebrewNumerals(288, true));
		$this->assertSame('רפ״ט', $calendar->numberToHebrewNumerals(289, true));
		$this->assertSame('ר״ץ', $calendar->numberToHebrewNumerals(290, true));
		$this->assertSame('רצ״א', $calendar->numberToHebrewNumerals(291, true));
		$this->assertSame('רצ״ב', $calendar->numberToHebrewNumerals(292, true));
		$this->assertSame('רצ״ג', $calendar->numberToHebrewNumerals(293, true));
		$this->assertSame('רצ״ד', $calendar->numberToHebrewNumerals(294, true));
		$this->assertSame('רצ״ה', $calendar->numberToHebrewNumerals(295, true));
		$this->assertSame('רצ״ו', $calendar->numberToHebrewNumerals(296, true));
		$this->assertSame('רצ״ז', $calendar->numberToHebrewNumerals(297, true));
		$this->assertSame('רצ״ח', $calendar->numberToHebrewNumerals(298, true));
		$this->assertSame('רצ״ט', $calendar->numberToHebrewNumerals(299, true));
		$this->assertSame('ש׳', $calendar->numberToHebrewNumerals(300, true));
		$this->assertSame('ש״א', $calendar->numberToHebrewNumerals(301, true));
		$this->assertSame('ש״ב', $calendar->numberToHebrewNumerals(302, true));
		$this->assertSame('ש״ג', $calendar->numberToHebrewNumerals(303, true));
		$this->assertSame('ש״ד', $calendar->numberToHebrewNumerals(304, true));
		$this->assertSame('ש״ה', $calendar->numberToHebrewNumerals(305, true));
		$this->assertSame('ש״ו', $calendar->numberToHebrewNumerals(306, true));
		$this->assertSame('ש״ז', $calendar->numberToHebrewNumerals(307, true));
		$this->assertSame('ש״ח', $calendar->numberToHebrewNumerals(308, true));
		$this->assertSame('ש״ט', $calendar->numberToHebrewNumerals(309, true));
		$this->assertSame('ש״י', $calendar->numberToHebrewNumerals(310, true));
		$this->assertSame('שי״א', $calendar->numberToHebrewNumerals(311, true));
		$this->assertSame('שי״ב', $calendar->numberToHebrewNumerals(312, true));
		$this->assertSame('שי״ג', $calendar->numberToHebrewNumerals(313, true));
		$this->assertSame('שי״ד', $calendar->numberToHebrewNumerals(314, true));
		$this->assertSame('שט״ו', $calendar->numberToHebrewNumerals(315, true));
		$this->assertSame('שט״ז', $calendar->numberToHebrewNumerals(316, true));
		$this->assertSame('שי״ז', $calendar->numberToHebrewNumerals(317, true));
		$this->assertSame('שי״ח', $calendar->numberToHebrewNumerals(318, true));
		$this->assertSame('שי״ט', $calendar->numberToHebrewNumerals(319, true));
		$this->assertSame('ש״ך', $calendar->numberToHebrewNumerals(320, true));
		$this->assertSame('שכ״א', $calendar->numberToHebrewNumerals(321, true));
		$this->assertSame('שכ״ב', $calendar->numberToHebrewNumerals(322, true));
		$this->assertSame('שכ״ג', $calendar->numberToHebrewNumerals(323, true));
		$this->assertSame('שכ״ד', $calendar->numberToHebrewNumerals(324, true));
		$this->assertSame('שכ״ה', $calendar->numberToHebrewNumerals(325, true));
		$this->assertSame('שכ״ו', $calendar->numberToHebrewNumerals(326, true));
		$this->assertSame('שכ״ז', $calendar->numberToHebrewNumerals(327, true));
		$this->assertSame('שכ״ח', $calendar->numberToHebrewNumerals(328, true));
		$this->assertSame('שכ״ט', $calendar->numberToHebrewNumerals(329, true));
		$this->assertSame('ש״ל', $calendar->numberToHebrewNumerals(330, true));
		$this->assertSame('של״א', $calendar->numberToHebrewNumerals(331, true));
		$this->assertSame('של״ב', $calendar->numberToHebrewNumerals(332, true));
		$this->assertSame('של״ג', $calendar->numberToHebrewNumerals(333, true));
		$this->assertSame('של״ד', $calendar->numberToHebrewNumerals(334, true));
		$this->assertSame('של״ה', $calendar->numberToHebrewNumerals(335, true));
		$this->assertSame('של״ו', $calendar->numberToHebrewNumerals(336, true));
		$this->assertSame('של״ז', $calendar->numberToHebrewNumerals(337, true));
		$this->assertSame('של״ח', $calendar->numberToHebrewNumerals(338, true));
		$this->assertSame('של״ט', $calendar->numberToHebrewNumerals(339, true));
		$this->assertSame('ש״ם', $calendar->numberToHebrewNumerals(340, true));
		$this->assertSame('שמ״א', $calendar->numberToHebrewNumerals(341, true));
		$this->assertSame('שמ״ב', $calendar->numberToHebrewNumerals(342, true));
		$this->assertSame('שמ״ג', $calendar->numberToHebrewNumerals(343, true));
		$this->assertSame('שמ״ד', $calendar->numberToHebrewNumerals(344, true));
		$this->assertSame('שמ״ה', $calendar->numberToHebrewNumerals(345, true));
		$this->assertSame('שמ״ו', $calendar->numberToHebrewNumerals(346, true));
		$this->assertSame('שמ״ז', $calendar->numberToHebrewNumerals(347, true));
		$this->assertSame('שמ״ח', $calendar->numberToHebrewNumerals(348, true));
		$this->assertSame('שמ״ט', $calendar->numberToHebrewNumerals(349, true));
		$this->assertSame('ש״ן', $calendar->numberToHebrewNumerals(350, true));
		$this->assertSame('שנ״א', $calendar->numberToHebrewNumerals(351, true));
		$this->assertSame('שנ״ב', $calendar->numberToHebrewNumerals(352, true));
		$this->assertSame('שנ״ג', $calendar->numberToHebrewNumerals(353, true));
		$this->assertSame('שנ״ד', $calendar->numberToHebrewNumerals(354, true));
		$this->assertSame('שנ״ה', $calendar->numberToHebrewNumerals(355, true));
		$this->assertSame('שנ״ו', $calendar->numberToHebrewNumerals(356, true));
		$this->assertSame('שנ״ז', $calendar->numberToHebrewNumerals(357, true));
		$this->assertSame('שנ״ח', $calendar->numberToHebrewNumerals(358, true));
		$this->assertSame('שנ״ט', $calendar->numberToHebrewNumerals(359, true));
		$this->assertSame('ש״ס', $calendar->numberToHebrewNumerals(360, true));
		$this->assertSame('שס״א', $calendar->numberToHebrewNumerals(361, true));
		$this->assertSame('שס״ב', $calendar->numberToHebrewNumerals(362, true));
		$this->assertSame('שס״ג', $calendar->numberToHebrewNumerals(363, true));
		$this->assertSame('שס״ד', $calendar->numberToHebrewNumerals(364, true));
		$this->assertSame('שס״ה', $calendar->numberToHebrewNumerals(365, true));
		$this->assertSame('שס״ו', $calendar->numberToHebrewNumerals(366, true));
		$this->assertSame('שס״ז', $calendar->numberToHebrewNumerals(367, true));
		$this->assertSame('שס״ח', $calendar->numberToHebrewNumerals(368, true));
		$this->assertSame('שס״ט', $calendar->numberToHebrewNumerals(369, true));
		$this->assertSame('ש״ע', $calendar->numberToHebrewNumerals(370, true));
		$this->assertSame('שע״א', $calendar->numberToHebrewNumerals(371, true));
		$this->assertSame('שע״ב', $calendar->numberToHebrewNumerals(372, true));
		$this->assertSame('שע״ג', $calendar->numberToHebrewNumerals(373, true));
		$this->assertSame('שע״ד', $calendar->numberToHebrewNumerals(374, true));
		$this->assertSame('שע״ה', $calendar->numberToHebrewNumerals(375, true));
		$this->assertSame('שע״ו', $calendar->numberToHebrewNumerals(376, true));
		$this->assertSame('שע״ז', $calendar->numberToHebrewNumerals(377, true));
		$this->assertSame('שע״ח', $calendar->numberToHebrewNumerals(378, true));
		$this->assertSame('שע״ט', $calendar->numberToHebrewNumerals(379, true));
		$this->assertSame('ש״ף', $calendar->numberToHebrewNumerals(380, true));
		$this->assertSame('שפ״א', $calendar->numberToHebrewNumerals(381, true));
		$this->assertSame('שפ״ב', $calendar->numberToHebrewNumerals(382, true));
		$this->assertSame('שפ״ג', $calendar->numberToHebrewNumerals(383, true));
		$this->assertSame('שפ״ד', $calendar->numberToHebrewNumerals(384, true));
		$this->assertSame('שפ״ה', $calendar->numberToHebrewNumerals(385, true));
		$this->assertSame('שפ״ו', $calendar->numberToHebrewNumerals(386, true));
		$this->assertSame('שפ״ז', $calendar->numberToHebrewNumerals(387, true));
		$this->assertSame('שפ״ח', $calendar->numberToHebrewNumerals(388, true));
		$this->assertSame('שפ״ט', $calendar->numberToHebrewNumerals(389, true));
		$this->assertSame('ש״ץ', $calendar->numberToHebrewNumerals(390, true));
		$this->assertSame('שצ״א', $calendar->numberToHebrewNumerals(391, true));
		$this->assertSame('שצ״ב', $calendar->numberToHebrewNumerals(392, true));
		$this->assertSame('שצ״ג', $calendar->numberToHebrewNumerals(393, true));
		$this->assertSame('שצ״ד', $calendar->numberToHebrewNumerals(394, true));
		$this->assertSame('שצ״ה', $calendar->numberToHebrewNumerals(395, true));
		$this->assertSame('שצ״ו', $calendar->numberToHebrewNumerals(396, true));
		$this->assertSame('שצ״ז', $calendar->numberToHebrewNumerals(397, true));
		$this->assertSame('שצ״ח', $calendar->numberToHebrewNumerals(398, true));
		$this->assertSame('שצ״ט', $calendar->numberToHebrewNumerals(399, true));
		$this->assertSame('ת׳', $calendar->numberToHebrewNumerals(400, true));
		$this->assertSame('ת״א', $calendar->numberToHebrewNumerals(401, true));
		$this->assertSame('ת״ב', $calendar->numberToHebrewNumerals(402, true));
		$this->assertSame('ת״ג', $calendar->numberToHebrewNumerals(403, true));
		$this->assertSame('ת״ד', $calendar->numberToHebrewNumerals(404, true));
		$this->assertSame('ת״ה', $calendar->numberToHebrewNumerals(405, true));
		$this->assertSame('ת״ו', $calendar->numberToHebrewNumerals(406, true));
		$this->assertSame('ת״ז', $calendar->numberToHebrewNumerals(407, true));
		$this->assertSame('ת״ח', $calendar->numberToHebrewNumerals(408, true));
		$this->assertSame('ת״ט', $calendar->numberToHebrewNumerals(409, true));
		$this->assertSame('ת״י', $calendar->numberToHebrewNumerals(410, true));
		$this->assertSame('תי״א', $calendar->numberToHebrewNumerals(411, true));
		$this->assertSame('תי״ב', $calendar->numberToHebrewNumerals(412, true));
		$this->assertSame('תי״ג', $calendar->numberToHebrewNumerals(413, true));
		$this->assertSame('תי״ד', $calendar->numberToHebrewNumerals(414, true));
		$this->assertSame('תט״ו', $calendar->numberToHebrewNumerals(415, true));
		$this->assertSame('תט״ז', $calendar->numberToHebrewNumerals(416, true));
		$this->assertSame('תי״ז', $calendar->numberToHebrewNumerals(417, true));
		$this->assertSame('תי״ח', $calendar->numberToHebrewNumerals(418, true));
		$this->assertSame('תי״ט', $calendar->numberToHebrewNumerals(419, true));
		$this->assertSame('ת״ך', $calendar->numberToHebrewNumerals(420, true));
		$this->assertSame('תצ״ט', $calendar->numberToHebrewNumerals(499, true));
		$this->assertSame('ת״ק', $calendar->numberToHebrewNumerals(500, true));
		$this->assertSame('תק״א', $calendar->numberToHebrewNumerals(501, true));
		$this->assertSame('תק״ב', $calendar->numberToHebrewNumerals(502, true));
		$this->assertSame('תק״ג', $calendar->numberToHebrewNumerals(503, true));
		$this->assertSame('תק״ד', $calendar->numberToHebrewNumerals(504, true));
		$this->assertSame('תק״ה', $calendar->numberToHebrewNumerals(505, true));
		$this->assertSame('תק״ו', $calendar->numberToHebrewNumerals(506, true));
		$this->assertSame('תק״ז', $calendar->numberToHebrewNumerals(507, true));
		$this->assertSame('תק״ח', $calendar->numberToHebrewNumerals(508, true));
		$this->assertSame('תק״ט', $calendar->numberToHebrewNumerals(509, true));
		$this->assertSame('תק״י', $calendar->numberToHebrewNumerals(510, true));
		$this->assertSame('תקי״א', $calendar->numberToHebrewNumerals(511, true));
		$this->assertSame('תקי״ב', $calendar->numberToHebrewNumerals(512, true));
		$this->assertSame('תקי״ג', $calendar->numberToHebrewNumerals(513, true));
		$this->assertSame('תקי״ד', $calendar->numberToHebrewNumerals(514, true));
		$this->assertSame('תקט״ו', $calendar->numberToHebrewNumerals(515, true));
		$this->assertSame('תקט״ז', $calendar->numberToHebrewNumerals(516, true));
		$this->assertSame('תקי״ז', $calendar->numberToHebrewNumerals(517, true));
		$this->assertSame('תקי״ח', $calendar->numberToHebrewNumerals(518, true));
		$this->assertSame('תקי״ט', $calendar->numberToHebrewNumerals(519, true));
		$this->assertSame('תק״ך', $calendar->numberToHebrewNumerals(520, true));
		$this->assertSame('תקצ״ט', $calendar->numberToHebrewNumerals(599, true));
		$this->assertSame('ת״ר', $calendar->numberToHebrewNumerals(600, true));
		$this->assertSame('תר״א', $calendar->numberToHebrewNumerals(601, true));
		$this->assertSame('תר״ב', $calendar->numberToHebrewNumerals(602, true));
		$this->assertSame('תר״ג', $calendar->numberToHebrewNumerals(603, true));
		$this->assertSame('תר״ד', $calendar->numberToHebrewNumerals(604, true));
		$this->assertSame('תר״ה', $calendar->numberToHebrewNumerals(605, true));
		$this->assertSame('תר״ו', $calendar->numberToHebrewNumerals(606, true));
		$this->assertSame('תר״ז', $calendar->numberToHebrewNumerals(607, true));
		$this->assertSame('תר״ח', $calendar->numberToHebrewNumerals(608, true));
		$this->assertSame('תר״ט', $calendar->numberToHebrewNumerals(609, true));
		$this->assertSame('תר״י', $calendar->numberToHebrewNumerals(610, true));
		$this->assertSame('תרי״א', $calendar->numberToHebrewNumerals(611, true));
		$this->assertSame('תרי״ב', $calendar->numberToHebrewNumerals(612, true));
		$this->assertSame('תרי״ג', $calendar->numberToHebrewNumerals(613, true));
		$this->assertSame('תרי״ד', $calendar->numberToHebrewNumerals(614, true));
		$this->assertSame('תרט״ו', $calendar->numberToHebrewNumerals(615, true));
		$this->assertSame('תרט״ז', $calendar->numberToHebrewNumerals(616, true));
		$this->assertSame('תרי״ז', $calendar->numberToHebrewNumerals(617, true));
		$this->assertSame('תרי״ח', $calendar->numberToHebrewNumerals(618, true));
		$this->assertSame('תרי״ט', $calendar->numberToHebrewNumerals(619, true));
		$this->assertSame('תר״ך', $calendar->numberToHebrewNumerals(620, true));
		$this->assertSame('תרצ״ט', $calendar->numberToHebrewNumerals(699, true));
		$this->assertSame('ת״ש', $calendar->numberToHebrewNumerals(700, true));
		$this->assertSame('תש״א', $calendar->numberToHebrewNumerals(701, true));
		$this->assertSame('תש״ב', $calendar->numberToHebrewNumerals(702, true));
		$this->assertSame('תש״ג', $calendar->numberToHebrewNumerals(703, true));
		$this->assertSame('תש״ד', $calendar->numberToHebrewNumerals(704, true));
		$this->assertSame('תש״ה', $calendar->numberToHebrewNumerals(705, true));
		$this->assertSame('תש״ו', $calendar->numberToHebrewNumerals(706, true));
		$this->assertSame('תש״ז', $calendar->numberToHebrewNumerals(707, true));
		$this->assertSame('תש״ח', $calendar->numberToHebrewNumerals(708, true));
		$this->assertSame('תש״ט', $calendar->numberToHebrewNumerals(709, true));
		$this->assertSame('תש״י', $calendar->numberToHebrewNumerals(710, true));
		$this->assertSame('תשי״א', $calendar->numberToHebrewNumerals(711, true));
		$this->assertSame('תשי״ב', $calendar->numberToHebrewNumerals(712, true));
		$this->assertSame('תשי״ג', $calendar->numberToHebrewNumerals(713, true));
		$this->assertSame('תשי״ד', $calendar->numberToHebrewNumerals(714, true));
		$this->assertSame('תשט״ו', $calendar->numberToHebrewNumerals(715, true));
		$this->assertSame('תשט״ז', $calendar->numberToHebrewNumerals(716, true));
		$this->assertSame('תשי״ז', $calendar->numberToHebrewNumerals(717, true));
		$this->assertSame('תשי״ח', $calendar->numberToHebrewNumerals(718, true));
		$this->assertSame('תשי״ט', $calendar->numberToHebrewNumerals(719, true));
		$this->assertSame('תש״ך', $calendar->numberToHebrewNumerals(720, true));
		$this->assertSame('תשצ״ט', $calendar->numberToHebrewNumerals(799, true));
		$this->assertSame('ת״ת', $calendar->numberToHebrewNumerals(800, true));
		$this->assertSame('תת״א', $calendar->numberToHebrewNumerals(801, true));
		$this->assertSame('תת״ב', $calendar->numberToHebrewNumerals(802, true));
		$this->assertSame('תת״ג', $calendar->numberToHebrewNumerals(803, true));
		$this->assertSame('תת״ד', $calendar->numberToHebrewNumerals(804, true));
		$this->assertSame('תת״ה', $calendar->numberToHebrewNumerals(805, true));
		$this->assertSame('תת״ו', $calendar->numberToHebrewNumerals(806, true));
		$this->assertSame('תת״ז', $calendar->numberToHebrewNumerals(807, true));
		$this->assertSame('תת״ח', $calendar->numberToHebrewNumerals(808, true));
		$this->assertSame('תת״ט', $calendar->numberToHebrewNumerals(809, true));
		$this->assertSame('תת״י', $calendar->numberToHebrewNumerals(810, true));
		$this->assertSame('תתי״א', $calendar->numberToHebrewNumerals(811, true));
		$this->assertSame('תתי״ב', $calendar->numberToHebrewNumerals(812, true));
		$this->assertSame('תתי״ג', $calendar->numberToHebrewNumerals(813, true));
		$this->assertSame('תתי״ד', $calendar->numberToHebrewNumerals(814, true));
		$this->assertSame('תתט״ו', $calendar->numberToHebrewNumerals(815, true));
		$this->assertSame('תתט״ז', $calendar->numberToHebrewNumerals(816, true));
		$this->assertSame('תתי״ז', $calendar->numberToHebrewNumerals(817, true));
		$this->assertSame('תתי״ח', $calendar->numberToHebrewNumerals(818, true));
		$this->assertSame('תתי״ט', $calendar->numberToHebrewNumerals(819, true));
		$this->assertSame('תת״ך', $calendar->numberToHebrewNumerals(820, true));
		$this->assertSame('תתצ״ט', $calendar->numberToHebrewNumerals(899, true));
		$this->assertSame('תת״ק', $calendar->numberToHebrewNumerals(900, true));
		$this->assertSame('תתק״א', $calendar->numberToHebrewNumerals(901, true));
		$this->assertSame('תתק״ב', $calendar->numberToHebrewNumerals(902, true));
		$this->assertSame('תתק״ג', $calendar->numberToHebrewNumerals(903, true));
		$this->assertSame('תתק״ד', $calendar->numberToHebrewNumerals(904, true));
		$this->assertSame('תתק״ה', $calendar->numberToHebrewNumerals(905, true));
		$this->assertSame('תתק״ו', $calendar->numberToHebrewNumerals(906, true));
		$this->assertSame('תתק״ז', $calendar->numberToHebrewNumerals(907, true));
		$this->assertSame('תתק״ח', $calendar->numberToHebrewNumerals(908, true));
		$this->assertSame('תתק״ט', $calendar->numberToHebrewNumerals(909, true));
		$this->assertSame('תתק״י', $calendar->numberToHebrewNumerals(910, true));
		$this->assertSame('תתקי״א', $calendar->numberToHebrewNumerals(911, true));
		$this->assertSame('תתקי״ב', $calendar->numberToHebrewNumerals(912, true));
		$this->assertSame('תתקי״ג', $calendar->numberToHebrewNumerals(913, true));
		$this->assertSame('תתקי״ד', $calendar->numberToHebrewNumerals(914, true));
		$this->assertSame('תתקט״ו', $calendar->numberToHebrewNumerals(915, true));
		$this->assertSame('תתקט״ז', $calendar->numberToHebrewNumerals(916, true));
		$this->assertSame('תתקי״ז', $calendar->numberToHebrewNumerals(917, true));
		$this->assertSame('תתקי״ח', $calendar->numberToHebrewNumerals(918, true));
		$this->assertSame('תתקי״ט', $calendar->numberToHebrewNumerals(919, true));
		$this->assertSame('תתק״ך', $calendar->numberToHebrewNumerals(920, true));
		$this->assertSame('תתקצ״ט', $calendar->numberToHebrewNumerals(999, true));
		$this->assertSame('א׳ אלפים', $calendar->numberToHebrewNumerals(1000, true));
		$this->assertSame('א׳א׳', $calendar->numberToHebrewNumerals(1001, true));
		$this->assertSame('א׳ב׳', $calendar->numberToHebrewNumerals(1002, true));
		$this->assertSame('א׳ג׳', $calendar->numberToHebrewNumerals(1003, true));
		$this->assertSame('א׳ד׳', $calendar->numberToHebrewNumerals(1004, true));
		$this->assertSame('א׳ה׳', $calendar->numberToHebrewNumerals(1005, true));
		$this->assertSame('א׳ו׳', $calendar->numberToHebrewNumerals(1006, true));
		$this->assertSame('א׳ז׳', $calendar->numberToHebrewNumerals(1007, true));
		$this->assertSame('א׳ח׳', $calendar->numberToHebrewNumerals(1008, true));
		$this->assertSame('א׳ט׳', $calendar->numberToHebrewNumerals(1009, true));
		$this->assertSame('א׳י׳', $calendar->numberToHebrewNumerals(1010, true));
		$this->assertSame('א׳י״א', $calendar->numberToHebrewNumerals(1011, true));
		$this->assertSame('א׳י״ב', $calendar->numberToHebrewNumerals(1012, true));
		$this->assertSame('א׳י״ג', $calendar->numberToHebrewNumerals(1013, true));
		$this->assertSame('א׳י״ד', $calendar->numberToHebrewNumerals(1014, true));
		$this->assertSame('א׳ט״ו', $calendar->numberToHebrewNumerals(1015, true));
		$this->assertSame('א׳ט״ז', $calendar->numberToHebrewNumerals(1016, true));
		$this->assertSame('א׳י״ז', $calendar->numberToHebrewNumerals(1017, true));
		$this->assertSame('א׳י״ח', $calendar->numberToHebrewNumerals(1018, true));
		$this->assertSame('א׳י״ט', $calendar->numberToHebrewNumerals(1019, true));
		$this->assertSame('א׳כ׳', $calendar->numberToHebrewNumerals(1020, true));
		$this->assertSame('א׳תתקצ״ט', $calendar->numberToHebrewNumerals(1999, true));
		$this->assertSame('ב׳ אלפים', $calendar->numberToHebrewNumerals(2000, true));
		$this->assertSame('ב׳א׳', $calendar->numberToHebrewNumerals(2001, true));
		$this->assertSame('ב׳ב׳', $calendar->numberToHebrewNumerals(2002, true));
		$this->assertSame('ב׳ג׳', $calendar->numberToHebrewNumerals(2003, true));
		$this->assertSame('ב׳ד׳', $calendar->numberToHebrewNumerals(2004, true));
		$this->assertSame('ב׳ה׳', $calendar->numberToHebrewNumerals(2005, true));
		$this->assertSame('ב׳ו׳', $calendar->numberToHebrewNumerals(2006, true));
		$this->assertSame('ב׳ז׳', $calendar->numberToHebrewNumerals(2007, true));
		$this->assertSame('ב׳ח׳', $calendar->numberToHebrewNumerals(2008, true));
		$this->assertSame('ב׳ט׳', $calendar->numberToHebrewNumerals(2009, true));
		$this->assertSame('ב׳י׳', $calendar->numberToHebrewNumerals(2010, true));
		$this->assertSame('ב׳י״א', $calendar->numberToHebrewNumerals(2011, true));
		$this->assertSame('ב׳י״ב', $calendar->numberToHebrewNumerals(2012, true));
		$this->assertSame('ב׳י״ג', $calendar->numberToHebrewNumerals(2013, true));
		$this->assertSame('ב׳י״ד', $calendar->numberToHebrewNumerals(2014, true));
		$this->assertSame('ב׳ט״ו', $calendar->numberToHebrewNumerals(2015, true));
		$this->assertSame('ב׳ט״ז', $calendar->numberToHebrewNumerals(2016, true));
		$this->assertSame('ב׳י״ז', $calendar->numberToHebrewNumerals(2017, true));
		$this->assertSame('ב׳י״ח', $calendar->numberToHebrewNumerals(2018, true));
		$this->assertSame('ב׳י״ט', $calendar->numberToHebrewNumerals(2019, true));
		$this->assertSame('ב׳כ׳', $calendar->numberToHebrewNumerals(2020, true));
		$this->assertSame('ב׳תתקצ״ט', $calendar->numberToHebrewNumerals(2999, true));
		$this->assertSame('ג׳ אלפים', $calendar->numberToHebrewNumerals(3000, true));
		$this->assertSame('ג׳א׳', $calendar->numberToHebrewNumerals(3001, true));
		$this->assertSame('ג׳ב׳', $calendar->numberToHebrewNumerals(3002, true));
		$this->assertSame('ג׳ג׳', $calendar->numberToHebrewNumerals(3003, true));
		$this->assertSame('ג׳ד׳', $calendar->numberToHebrewNumerals(3004, true));
		$this->assertSame('ג׳ה׳', $calendar->numberToHebrewNumerals(3005, true));
		$this->assertSame('ג׳ו׳', $calendar->numberToHebrewNumerals(3006, true));
		$this->assertSame('ג׳ז׳', $calendar->numberToHebrewNumerals(3007, true));
		$this->assertSame('ג׳ח׳', $calendar->numberToHebrewNumerals(3008, true));
		$this->assertSame('ג׳ט׳', $calendar->numberToHebrewNumerals(3009, true));
		$this->assertSame('ג׳י׳', $calendar->numberToHebrewNumerals(3010, true));
		$this->assertSame('ג׳י״א', $calendar->numberToHebrewNumerals(3011, true));
		$this->assertSame('ג׳י״ב', $calendar->numberToHebrewNumerals(3012, true));
		$this->assertSame('ג׳י״ג', $calendar->numberToHebrewNumerals(3013, true));
		$this->assertSame('ג׳י״ד', $calendar->numberToHebrewNumerals(3014, true));
		$this->assertSame('ג׳ט״ו', $calendar->numberToHebrewNumerals(3015, true));
		$this->assertSame('ג׳ט״ז', $calendar->numberToHebrewNumerals(3016, true));
		$this->assertSame('ג׳י״ז', $calendar->numberToHebrewNumerals(3017, true));
		$this->assertSame('ג׳י״ח', $calendar->numberToHebrewNumerals(3018, true));
		$this->assertSame('ג׳י״ט', $calendar->numberToHebrewNumerals(3019, true));
		$this->assertSame('ג׳כ׳', $calendar->numberToHebrewNumerals(3020, true));
		$this->assertSame('ג׳תתקצ״ט', $calendar->numberToHebrewNumerals(3999, true));
		$this->assertSame('ד׳ אלפים', $calendar->numberToHebrewNumerals(4000, true));
		$this->assertSame('ד׳א׳', $calendar->numberToHebrewNumerals(4001, true));
		$this->assertSame('ד׳ב׳', $calendar->numberToHebrewNumerals(4002, true));
		$this->assertSame('ד׳ג׳', $calendar->numberToHebrewNumerals(4003, true));
		$this->assertSame('ד׳ד׳', $calendar->numberToHebrewNumerals(4004, true));
		$this->assertSame('ד׳ה׳', $calendar->numberToHebrewNumerals(4005, true));
		$this->assertSame('ד׳ו׳', $calendar->numberToHebrewNumerals(4006, true));
		$this->assertSame('ד׳ז׳', $calendar->numberToHebrewNumerals(4007, true));
		$this->assertSame('ד׳ח׳', $calendar->numberToHebrewNumerals(4008, true));
		$this->assertSame('ד׳ט׳', $calendar->numberToHebrewNumerals(4009, true));
		$this->assertSame('ד׳י׳', $calendar->numberToHebrewNumerals(4010, true));
		$this->assertSame('ד׳י״א', $calendar->numberToHebrewNumerals(4011, true));
		$this->assertSame('ד׳י״ב', $calendar->numberToHebrewNumerals(4012, true));
		$this->assertSame('ד׳י״ג', $calendar->numberToHebrewNumerals(4013, true));
		$this->assertSame('ד׳י״ד', $calendar->numberToHebrewNumerals(4014, true));
		$this->assertSame('ד׳ט״ו', $calendar->numberToHebrewNumerals(4015, true));
		$this->assertSame('ד׳ט״ז', $calendar->numberToHebrewNumerals(4016, true));
		$this->assertSame('ד׳י״ז', $calendar->numberToHebrewNumerals(4017, true));
		$this->assertSame('ד׳י״ח', $calendar->numberToHebrewNumerals(4018, true));
		$this->assertSame('ד׳י״ט', $calendar->numberToHebrewNumerals(4019, true));
		$this->assertSame('ד׳כ׳', $calendar->numberToHebrewNumerals(4020, true));
		$this->assertSame('ד׳תתקצ״ט', $calendar->numberToHebrewNumerals(4999, true));
		$this->assertSame('ה׳ אלפים', $calendar->numberToHebrewNumerals(5000, true));
		$this->assertSame('ה׳א׳', $calendar->numberToHebrewNumerals(5001, true));
		$this->assertSame('ה׳ב׳', $calendar->numberToHebrewNumerals(5002, true));
		$this->assertSame('ה׳ג׳', $calendar->numberToHebrewNumerals(5003, true));
		$this->assertSame('ה׳ד׳', $calendar->numberToHebrewNumerals(5004, true));
		$this->assertSame('ה׳ה׳', $calendar->numberToHebrewNumerals(5005, true));
		$this->assertSame('ה׳ו׳', $calendar->numberToHebrewNumerals(5006, true));
		$this->assertSame('ה׳ז׳', $calendar->numberToHebrewNumerals(5007, true));
		$this->assertSame('ה׳ח׳', $calendar->numberToHebrewNumerals(5008, true));
		$this->assertSame('ה׳ט׳', $calendar->numberToHebrewNumerals(5009, true));
		$this->assertSame('ה׳י׳', $calendar->numberToHebrewNumerals(5010, true));
		$this->assertSame('ה׳י״א', $calendar->numberToHebrewNumerals(5011, true));
		$this->assertSame('ה׳י״ב', $calendar->numberToHebrewNumerals(5012, true));
		$this->assertSame('ה׳י״ג', $calendar->numberToHebrewNumerals(5013, true));
		$this->assertSame('ה׳י״ד', $calendar->numberToHebrewNumerals(5014, true));
		$this->assertSame('ה׳ט״ו', $calendar->numberToHebrewNumerals(5015, true));
		$this->assertSame('ה׳ט״ז', $calendar->numberToHebrewNumerals(5016, true));
		$this->assertSame('ה׳י״ז', $calendar->numberToHebrewNumerals(5017, true));
		$this->assertSame('ה׳י״ח', $calendar->numberToHebrewNumerals(5018, true));
		$this->assertSame('ה׳י״ט', $calendar->numberToHebrewNumerals(5019, true));
		$this->assertSame('ה׳כ׳', $calendar->numberToHebrewNumerals(5020, true));
		$this->assertSame('ה׳תתקצ״ט', $calendar->numberToHebrewNumerals(5999, true));
		$this->assertSame('ו׳ אלפים', $calendar->numberToHebrewNumerals(6000, true));
		$this->assertSame('ו׳א׳', $calendar->numberToHebrewNumerals(6001, true));
		$this->assertSame('ו׳ב׳', $calendar->numberToHebrewNumerals(6002, true));
		$this->assertSame('ו׳ג׳', $calendar->numberToHebrewNumerals(6003, true));
		$this->assertSame('ו׳ד׳', $calendar->numberToHebrewNumerals(6004, true));
		$this->assertSame('ו׳ה׳', $calendar->numberToHebrewNumerals(6005, true));
		$this->assertSame('ו׳ו׳', $calendar->numberToHebrewNumerals(6006, true));
		$this->assertSame('ו׳ז׳', $calendar->numberToHebrewNumerals(6007, true));
		$this->assertSame('ו׳ח׳', $calendar->numberToHebrewNumerals(6008, true));
		$this->assertSame('ו׳ט׳', $calendar->numberToHebrewNumerals(6009, true));
		$this->assertSame('ו׳י׳', $calendar->numberToHebrewNumerals(6010, true));
		$this->assertSame('ו׳י״א', $calendar->numberToHebrewNumerals(6011, true));
		$this->assertSame('ו׳י״ב', $calendar->numberToHebrewNumerals(6012, true));
		$this->assertSame('ו׳י״ג', $calendar->numberToHebrewNumerals(6013, true));
		$this->assertSame('ו׳י״ד', $calendar->numberToHebrewNumerals(6014, true));
		$this->assertSame('ו׳ט״ו', $calendar->numberToHebrewNumerals(6015, true));
		$this->assertSame('ו׳ט״ז', $calendar->numberToHebrewNumerals(6016, true));
		$this->assertSame('ו׳י״ז', $calendar->numberToHebrewNumerals(6017, true));
		$this->assertSame('ו׳י״ח', $calendar->numberToHebrewNumerals(6018, true));
		$this->assertSame('ו׳י״ט', $calendar->numberToHebrewNumerals(6019, true));
		$this->assertSame('ו׳כ׳', $calendar->numberToHebrewNumerals(6020, true));
		$this->assertSame('ו׳תתקצ״ט', $calendar->numberToHebrewNumerals(6999, true));
		$this->assertSame('ז׳ אלפים', $calendar->numberToHebrewNumerals(7000, true));
		$this->assertSame('ז׳א׳', $calendar->numberToHebrewNumerals(7001, true));
		$this->assertSame('ז׳ב׳', $calendar->numberToHebrewNumerals(7002, true));
		$this->assertSame('ז׳ג׳', $calendar->numberToHebrewNumerals(7003, true));
		$this->assertSame('ז׳ד׳', $calendar->numberToHebrewNumerals(7004, true));
		$this->assertSame('ז׳ה׳', $calendar->numberToHebrewNumerals(7005, true));
		$this->assertSame('ז׳ו׳', $calendar->numberToHebrewNumerals(7006, true));
		$this->assertSame('ז׳ז׳', $calendar->numberToHebrewNumerals(7007, true));
		$this->assertSame('ז׳ח׳', $calendar->numberToHebrewNumerals(7008, true));
		$this->assertSame('ז׳ט׳', $calendar->numberToHebrewNumerals(7009, true));
		$this->assertSame('ז׳י׳', $calendar->numberToHebrewNumerals(7010, true));
		$this->assertSame('ז׳י״א', $calendar->numberToHebrewNumerals(7011, true));
		$this->assertSame('ז׳י״ב', $calendar->numberToHebrewNumerals(7012, true));
		$this->assertSame('ז׳י״ג', $calendar->numberToHebrewNumerals(7013, true));
		$this->assertSame('ז׳י״ד', $calendar->numberToHebrewNumerals(7014, true));
		$this->assertSame('ז׳ט״ו', $calendar->numberToHebrewNumerals(7015, true));
		$this->assertSame('ז׳ט״ז', $calendar->numberToHebrewNumerals(7016, true));
		$this->assertSame('ז׳י״ז', $calendar->numberToHebrewNumerals(7017, true));
		$this->assertSame('ז׳י״ח', $calendar->numberToHebrewNumerals(7018, true));
		$this->assertSame('ז׳י״ט', $calendar->numberToHebrewNumerals(7019, true));
		$this->assertSame('ז׳כ׳', $calendar->numberToHebrewNumerals(7020, true));
		$this->assertSame('ז׳תתקצ״ט', $calendar->numberToHebrewNumerals(7999, true));
		$this->assertSame('ח׳ אלפים', $calendar->numberToHebrewNumerals(8000, true));
		$this->assertSame('ח׳א׳', $calendar->numberToHebrewNumerals(8001, true));
		$this->assertSame('ח׳ב׳', $calendar->numberToHebrewNumerals(8002, true));
		$this->assertSame('ח׳ג׳', $calendar->numberToHebrewNumerals(8003, true));
		$this->assertSame('ח׳ד׳', $calendar->numberToHebrewNumerals(8004, true));
		$this->assertSame('ח׳ה׳', $calendar->numberToHebrewNumerals(8005, true));
		$this->assertSame('ח׳ו׳', $calendar->numberToHebrewNumerals(8006, true));
		$this->assertSame('ח׳ז׳', $calendar->numberToHebrewNumerals(8007, true));
		$this->assertSame('ח׳ח׳', $calendar->numberToHebrewNumerals(8008, true));
		$this->assertSame('ח׳ט׳', $calendar->numberToHebrewNumerals(8009, true));
		$this->assertSame('ח׳י׳', $calendar->numberToHebrewNumerals(8010, true));
		$this->assertSame('ח׳י״א', $calendar->numberToHebrewNumerals(8011, true));
		$this->assertSame('ח׳י״ב', $calendar->numberToHebrewNumerals(8012, true));
		$this->assertSame('ח׳י״ג', $calendar->numberToHebrewNumerals(8013, true));
		$this->assertSame('ח׳י״ד', $calendar->numberToHebrewNumerals(8014, true));
		$this->assertSame('ח׳ט״ו', $calendar->numberToHebrewNumerals(8015, true));
		$this->assertSame('ח׳ט״ז', $calendar->numberToHebrewNumerals(8016, true));
		$this->assertSame('ח׳י״ז', $calendar->numberToHebrewNumerals(8017, true));
		$this->assertSame('ח׳י״ח', $calendar->numberToHebrewNumerals(8018, true));
		$this->assertSame('ח׳י״ט', $calendar->numberToHebrewNumerals(8019, true));
		$this->assertSame('ח׳כ׳', $calendar->numberToHebrewNumerals(8020, true));
		$this->assertSame('ח׳תתקצ״ט', $calendar->numberToHebrewNumerals(8999, true));
		$this->assertSame('ט׳ אלפים', $calendar->numberToHebrewNumerals(9000, true));
		$this->assertSame('ט׳א׳', $calendar->numberToHebrewNumerals(9001, true));
		$this->assertSame('ט׳ב׳', $calendar->numberToHebrewNumerals(9002, true));
		$this->assertSame('ט׳ג׳', $calendar->numberToHebrewNumerals(9003, true));
		$this->assertSame('ט׳ד׳', $calendar->numberToHebrewNumerals(9004, true));
		$this->assertSame('ט׳ה׳', $calendar->numberToHebrewNumerals(9005, true));
		$this->assertSame('ט׳ו׳', $calendar->numberToHebrewNumerals(9006, true));
		$this->assertSame('ט׳ז׳', $calendar->numberToHebrewNumerals(9007, true));
		$this->assertSame('ט׳ח׳', $calendar->numberToHebrewNumerals(9008, true));
		$this->assertSame('ט׳ט׳', $calendar->numberToHebrewNumerals(9009, true));
		$this->assertSame('ט׳י׳', $calendar->numberToHebrewNumerals(9010, true));
		$this->assertSame('ט׳י״א', $calendar->numberToHebrewNumerals(9011, true));
		$this->assertSame('ט׳י״ב', $calendar->numberToHebrewNumerals(9012, true));
		$this->assertSame('ט׳י״ג', $calendar->numberToHebrewNumerals(9013, true));
		$this->assertSame('ט׳י״ד', $calendar->numberToHebrewNumerals(9014, true));
		$this->assertSame('ט׳ט״ו', $calendar->numberToHebrewNumerals(9015, true));
		$this->assertSame('ט׳ט״ז', $calendar->numberToHebrewNumerals(9016, true));
		$this->assertSame('ט׳י״ז', $calendar->numberToHebrewNumerals(9017, true));
		$this->assertSame('ט׳י״ח', $calendar->numberToHebrewNumerals(9018, true));
		$this->assertSame('ט׳י״ט', $calendar->numberToHebrewNumerals(9019, true));
		$this->assertSame('ט׳כ׳', $calendar->numberToHebrewNumerals(9020, true));
		$this->assertSame('ט׳תתק״ץ', $calendar->numberToHebrewNumerals(9990, true));
		$this->assertSame('ט׳תתקצ״א', $calendar->numberToHebrewNumerals(9991, true));
		$this->assertSame('ט׳תתקצ״ב', $calendar->numberToHebrewNumerals(9992, true));
		$this->assertSame('ט׳תתקצ״ג', $calendar->numberToHebrewNumerals(9993, true));
		$this->assertSame('ט׳תתקצ״ד', $calendar->numberToHebrewNumerals(9994, true));
		$this->assertSame('ט׳תתקצ״ה', $calendar->numberToHebrewNumerals(9995, true));
		$this->assertSame('ט׳תתקצ״ו', $calendar->numberToHebrewNumerals(9996, true));
		$this->assertSame('ט׳תתקצ״ז', $calendar->numberToHebrewNumerals(9997, true));
		$this->assertSame('ט׳תתקצ״ח', $calendar->numberToHebrewNumerals(9998, true));
		$this->assertSame('ט׳תתקצ״ט', $calendar->numberToHebrewNumerals(9999, true));
	}
}
