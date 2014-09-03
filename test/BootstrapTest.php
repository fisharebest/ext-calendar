<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class French
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

class BootstrapTest extends TestCase {
	public function testInit() {
		Bootstrap::init();
			$this->assertTrue(defined('CAL_JEWISH'));
	}
}
