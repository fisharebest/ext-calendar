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
	/**
	 * Test the implementation of Shim\frenchtojd() against PHP\frenchtojd()
	 *
	 * @return void
	 */
	public function testFrenchToJdEntireCalendar() {

	}

	/**
	 * Test the implementation of Shim\frenchtojd() against PHP\frenchtojd()
	 *
	 * @return void
	 */
	public function testFrenchToJdOutOfRange() {

	}

	/**
	 * Test the implementation of Shim\jdtofrench() against PHP\jdtofrench()
	 *
	 * @return void
	 */
	public function testJdToFrenchEntireCalendar() {
		$start_jd = \gregoriantojd(9, 22, 1792);
		$end_jd = \gregoriantojd(9, 22, 1806);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtofrench($jd), \jdtofrench($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtofrench() against PHP\jdtofrench()
	 *
	 * @return void
	 */
	public function testJdToFrenchOutOfRange() {
		$jd1 = \gregoriantojd(9, 21, 1792);
		$jd2 = \gregoriantojd(9, 23, 1806);

		$this->assertEquals(Shim::jdtofrench($jd1), \jdtofrench($jd1));
		$this->assertEquals(Shim::jdtofrench($jd2), \jdtofrench($jd2));
		$this->assertEquals(Shim::jdtofrench($jd1), '0/0/0');
		$this->assertEquals(Shim::jdtofrench($jd2), '0/0/0');
	}

	/**
	 * Test the implementation of Shim\jdtogregorian() against PHP\jdtogregorian()
	 *
	 * @return void
	 */
	public function testJdToGregorianEveryDayForADecade() {
		$start_jd = \gregoriantojd(1, 1, 1995);
		$end_jd = \gregoriantojd(12, 31, 2005);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtogregorian() against PHP\jdtogregorian()
	 *
	 * @return void
	 */
	public function testJdToGregorianDistantPast() {
		$start_jd = \gregoriantojd(1, 1, -4001);
		$end_jd = \gregoriantojd(12, 31, -3999);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtogregorian() against PHP\jdtogregorian()
	 *
	 * @return void
	 */
	public function testJdToGregorianBcAd() {
		$start_jd = \gregoriantojd(1, 1, -1);
		$end_jd = \gregoriantojd(12, 31, 1);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtogregorian() against PHP\jdtogregorian()
	 *
	 * @return void
	 */
	public function testJdToGregorianDistantFuture() {
		$start_jd = \gregoriantojd(1, 1, 9999);
		$end_jd = \gregoriantojd(12, 31, 10001);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtojulian() against PHP\jdtojulian()
	 *
	 * @return void
	 */
	public function testJdToJulianEveryDayForADecade() {
		$start_jd = \gregoriantojd(1, 1, 1995);
		$end_jd = \gregoriantojd(12, 31, 2005);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtogregorian() against PHP\jdtogregorian()
	 *
	 * @return void
	 */
	public function testJdToJulianDistantPast() {
		$start_jd = \gregoriantojd(1, 1, -1);
		$end_jd = \gregoriantojd(12, 31, 1);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jdtogregorian() against PHP\jdtogregorian()
	 *
	 * @return void
	 */
	public function testJdToJulianDistantFuture() {
		$start_jd = \gregoriantojd(1, 1, 9999);
		$end_jd = \gregoriantojd(12, 31, 10001);

		for ($jd = $start_jd; $jd <= $end_jd; ++$jd) {
			$this->assertEquals(Shim::jdtogregorian($jd), \jdtogregorian($jd));
		}
	}

	/**
	 * Test the implementation of Shim\jewishtojd() against PHP\jewishtojd()
	 *
	 * @return void
	 */
	public function testJewishToJd() {

	}

	/**
	 * Test the implementation of Shim\juliantojd() against PHP\juliantojd()
	 *
	 * @return void
	 */
	public function testJulianToJd() {

	}
}
