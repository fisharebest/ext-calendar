<?php
namespace Fisharebest\ExtCalendar;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class PersianCalendar
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

class PersianCalendarTest extends TestCase {
	/**
	 * Test the class constants.
	 *
	 * @coversNone
	 *
	 * @return void
	 */
	public function testConstants() {
		$persian = new PersianCalendar;

		$this->assertSame($persian::PHP_CALENDAR_NAME, 'Persian');
		$this->assertSame($persian::PHP_CALENDAR_NUMBER, 5);
		$this->assertSame($persian::GEDCOM_CALENDAR_ESCAPE, '@#DJALALI@');
	}

	/**
	 * Test the PHP calendar information function (if php_info() supported this calendar)!
	 *
	 * @covers Fisharebest\ExtCalendar\Calendar::phpCalInfo
	 * @covers Fisharebest\ExtCalendar\PersianCalendar::monthNames
	 * @covers Fisharebest\ExtCalendar\Calendar::monthNamesAbbreviated
	 *
	 * @return void
	 */
	public function testPhpCalInfo() {
		$persian = new PersianCalendar;

		$cal_info = array(
			'months' => array(
				1 => 'Farvardin', 'Ordibehesht', 'Khordad', 'Tir', 'Mordad', 'Shahrivar',
				'Mehr', 'Aban', 'Azar', 'Dey', 'Bahman', 'Esfand',
			),
			'abbrevmonths' => array(
				1 => 'Farvardin', 'Ordibehesht', 'Khordad', 'Tir', 'Mordad', 'Shahrivar',
				'Mehr', 'Aban', 'Azar', 'Dey', 'Bahman', 'Esfand',
			),
			'maxdaysinmonth' => 31,
			'calname' => 'Persian',
			'calsymbol' => 'CAL_PERSIAN',
		);


		$this->assertSame($persian->phpCalInfo(), $cal_info);
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers Fisharebest\ExtCalendar\PersianCalendar::leapYear
	 *
	 * @return void
	 */
	public function testLeapYear() {
		$persian = new PersianCalendar;

		$this->assertSame($persian->leapYear(1201), true);
		$this->assertSame($persian->leapYear(1202), false);
		$this->assertSame($persian->leapYear(1203), false);
		$this->assertSame($persian->leapYear(1204), false);
		$this->assertSame($persian->leapYear(1205), true);
		$this->assertSame($persian->leapYear(1206), false);
		$this->assertSame($persian->leapYear(1207), false);
		$this->assertSame($persian->leapYear(1208), false);
		$this->assertSame($persian->leapYear(1209), true);
		$this->assertSame($persian->leapYear(1210), false);
		$this->assertSame($persian->leapYear(1211), false);
		$this->assertSame($persian->leapYear(1212), false);
		$this->assertSame($persian->leapYear(1213), false);
		$this->assertSame($persian->leapYear(1214), true);
		$this->assertSame($persian->leapYear(1215), false);
		$this->assertSame($persian->leapYear(1216), false);
		$this->assertSame($persian->leapYear(1217), false);
		$this->assertSame($persian->leapYear(1218), true);
		$this->assertSame($persian->leapYear(1219), false);
		$this->assertSame($persian->leapYear(1220), false);
		$this->assertSame($persian->leapYear(1221), false);
		$this->assertSame($persian->leapYear(1222), true);
		$this->assertSame($persian->leapYear(1223), false);
		$this->assertSame($persian->leapYear(1224), false);
		$this->assertSame($persian->leapYear(1225), false);
		$this->assertSame($persian->leapYear(1226), true);
		$this->assertSame($persian->leapYear(1227), false);
		$this->assertSame($persian->leapYear(1228), false);
		$this->assertSame($persian->leapYear(1229), false);
		$this->assertSame($persian->leapYear(1230), true);
		$this->assertSame($persian->leapYear(1231), false);
		$this->assertSame($persian->leapYear(1232), false);
		$this->assertSame($persian->leapYear(1233), false);
		$this->assertSame($persian->leapYear(1234), true);
		$this->assertSame($persian->leapYear(1235), false);
		$this->assertSame($persian->leapYear(1236), false);
		$this->assertSame($persian->leapYear(1237), false);
		$this->assertSame($persian->leapYear(1238), true);
		$this->assertSame($persian->leapYear(1239), false);
		$this->assertSame($persian->leapYear(1240), false);
		$this->assertSame($persian->leapYear(1241), false);
		$this->assertSame($persian->leapYear(1242), true);
		$this->assertSame($persian->leapYear(1243), false);
		$this->assertSame($persian->leapYear(1244), false);
		$this->assertSame($persian->leapYear(1245), false);
		$this->assertSame($persian->leapYear(1246), false);
		$this->assertSame($persian->leapYear(1247), true);
		$this->assertSame($persian->leapYear(1248), false);
		$this->assertSame($persian->leapYear(1249), false);
		$this->assertSame($persian->leapYear(1250), false);
		$this->assertSame($persian->leapYear(1251), true);
		$this->assertSame($persian->leapYear(1252), false);
		$this->assertSame($persian->leapYear(1253), false);
		$this->assertSame($persian->leapYear(1254), false);
		$this->assertSame($persian->leapYear(1255), true);
		$this->assertSame($persian->leapYear(1256), false);
		$this->assertSame($persian->leapYear(1257), false);
		$this->assertSame($persian->leapYear(1258), false);
		$this->assertSame($persian->leapYear(1259), true);
		$this->assertSame($persian->leapYear(1260), false);
		$this->assertSame($persian->leapYear(1261), false);
		$this->assertSame($persian->leapYear(1262), false);
		$this->assertSame($persian->leapYear(1263), true);
		$this->assertSame($persian->leapYear(1264), false);
		$this->assertSame($persian->leapYear(1265), false);
		$this->assertSame($persian->leapYear(1266), false);
		$this->assertSame($persian->leapYear(1267), true);
		$this->assertSame($persian->leapYear(1268), false);
		$this->assertSame($persian->leapYear(1269), false);
		$this->assertSame($persian->leapYear(1270), false);
		$this->assertSame($persian->leapYear(1271), true);
		$this->assertSame($persian->leapYear(1272), false);
		$this->assertSame($persian->leapYear(1273), false);
		$this->assertSame($persian->leapYear(1274), false);
		$this->assertSame($persian->leapYear(1275), false);
		$this->assertSame($persian->leapYear(1276), true);
		$this->assertSame($persian->leapYear(1277), false);
		$this->assertSame($persian->leapYear(1278), false);
		$this->assertSame($persian->leapYear(1279), false);
		$this->assertSame($persian->leapYear(1280), true);
		$this->assertSame($persian->leapYear(1281), false);
		$this->assertSame($persian->leapYear(1282), false);
		$this->assertSame($persian->leapYear(1283), false);
		$this->assertSame($persian->leapYear(1284), true);
		$this->assertSame($persian->leapYear(1285), false);
		$this->assertSame($persian->leapYear(1286), false);
		$this->assertSame($persian->leapYear(1287), false);
		$this->assertSame($persian->leapYear(1288), true);
		$this->assertSame($persian->leapYear(1289), false);
		$this->assertSame($persian->leapYear(1290), false);
		$this->assertSame($persian->leapYear(1291), false);
		$this->assertSame($persian->leapYear(1292), true);
		$this->assertSame($persian->leapYear(1293), false);
		$this->assertSame($persian->leapYear(1294), false);
		$this->assertSame($persian->leapYear(1295), false);
		$this->assertSame($persian->leapYear(1296), true);
		$this->assertSame($persian->leapYear(1297), false);
		$this->assertSame($persian->leapYear(1298), false);
		$this->assertSame($persian->leapYear(1299), false);
		$this->assertSame($persian->leapYear(1300), true);
		$this->assertSame($persian->leapYear(1301), false);
		$this->assertSame($persian->leapYear(1302), false);
		$this->assertSame($persian->leapYear(1303), false);
		$this->assertSame($persian->leapYear(1304), true);
		$this->assertSame($persian->leapYear(1305), false);
		$this->assertSame($persian->leapYear(1306), false);
		$this->assertSame($persian->leapYear(1307), false);
		$this->assertSame($persian->leapYear(1308), false);
		$this->assertSame($persian->leapYear(1309), true);
		$this->assertSame($persian->leapYear(1310), false);
		$this->assertSame($persian->leapYear(1311), false);
		$this->assertSame($persian->leapYear(1312), false);
		$this->assertSame($persian->leapYear(1313), true);
		$this->assertSame($persian->leapYear(1314), false);
		$this->assertSame($persian->leapYear(1315), false);
		$this->assertSame($persian->leapYear(1316), false);
		$this->assertSame($persian->leapYear(1317), true);
		$this->assertSame($persian->leapYear(1318), false);
		$this->assertSame($persian->leapYear(1319), false);
		$this->assertSame($persian->leapYear(1320), false);
		$this->assertSame($persian->leapYear(1321), true);
		$this->assertSame($persian->leapYear(1322), false);
		$this->assertSame($persian->leapYear(1323), false);
		$this->assertSame($persian->leapYear(1324), false);
		$this->assertSame($persian->leapYear(1325), true);
		$this->assertSame($persian->leapYear(1326), false);
		$this->assertSame($persian->leapYear(1327), false);
		$this->assertSame($persian->leapYear(1328), false);
	}

	/**
	 * Test the calculation of the number of days in each month.
	 *
	 * @covers \Fisharebest\ExtCalendar\PersianCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonth() {
		$persian = new PersianCalendar;

		$this->assertSame($persian->daysInMonth(1201, 1), 31);
		$this->assertSame($persian->daysInMonth(1201, 2), 31);
		$this->assertSame($persian->daysInMonth(1201, 3), 31);
		$this->assertSame($persian->daysInMonth(1201, 4), 31);
		$this->assertSame($persian->daysInMonth(1201, 5), 31);
		$this->assertSame($persian->daysInMonth(1201, 6), 31);
		$this->assertSame($persian->daysInMonth(1201, 7), 30);
		$this->assertSame($persian->daysInMonth(1201, 8), 30);
		$this->assertSame($persian->daysInMonth(1201, 9), 30);
		$this->assertSame($persian->daysInMonth(1201, 10), 30);
		$this->assertSame($persian->daysInMonth(1201, 11), 30);
		$this->assertSame($persian->daysInMonth(1201, 12), 30);
		$this->assertSame($persian->daysInMonth(1202, 1), 31);
		$this->assertSame($persian->daysInMonth(1202, 2), 31);
		$this->assertSame($persian->daysInMonth(1202, 3), 31);
		$this->assertSame($persian->daysInMonth(1202, 4), 31);
		$this->assertSame($persian->daysInMonth(1202, 5), 31);
		$this->assertSame($persian->daysInMonth(1202, 6), 31);
		$this->assertSame($persian->daysInMonth(1202, 7), 30);
		$this->assertSame($persian->daysInMonth(1202, 8), 30);
		$this->assertSame($persian->daysInMonth(1202, 9), 30);
		$this->assertSame($persian->daysInMonth(1202, 10), 30);
		$this->assertSame($persian->daysInMonth(1202, 11), 30);
		$this->assertSame($persian->daysInMonth(1202, 12), 29);
	}

	/**
	 * Test the calculation of the number of days in each month.
	 *
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionMessage Month 13 is invalid for this calendar
	 *
	 * @covers \Fisharebest\ExtCalendar\PersianCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonthInvalidMonth() {
		$persian = new PersianCalendar;

		$persian->daysInMonth(1234, 13);
	}

	/**
	 * Test the calculation of the number of days in each month.
	 *
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionMessage Year 0 is invalid for this calendar
	 *
	 * @covers \Fisharebest\ExtCalendar\PersianCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonthZeroYear() {
		$persian = new PersianCalendar;

		$persian->daysInMonth(0, 1);
	}

	/**
	 * Test the calculation of the number of days in each month.
	 *
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionMessage Year -1 is invalid for this calendar
	 *
	 * @covers \Fisharebest\ExtCalendar\PersianCalendar::daysInMonth
	 *
	 * @return void
	 */
	public function testDaysInMonthNegativeYear() {
		$persian = new PersianCalendar;

		$persian->daysInMonth(-1, 1);
	}

	/**
	 * Test the conversion of calendar dates into Julian days.
	 *
	 * @covers \Fisharebest\ExtCalendar\PersianCalendar::jdToYmd
	 * @covers \Fisharebest\ExtCalendar\PersianCalendar::ymdToJd
	 *
	 * @return void
	 */
	public function testYmdTojd() {
		$persian = new PersianCalendar;

		// The reverse calculation does not appear to work.
		$this->assertSame($persian->ymdToJd(1, 1, 1), 1948321);

		$this->assertSame($persian->ymdToJd(1201, 1, 31), 2386641);
		$this->assertSame($persian->jdToYmd(2386641), array(1201, 1, 31));
		$this->assertSame($persian->ymdToJd(1201, 2, 31), 2386672);
		$this->assertSame($persian->jdToYmd(2386672), array(1201, 2, 31));
		$this->assertSame($persian->ymdToJd(1201, 3, 31), 2386703);
		$this->assertSame($persian->jdToYmd(2386703), array(1201, 3, 31));
		$this->assertSame($persian->ymdToJd(1201, 4, 31), 2386734);
		$this->assertSame($persian->jdToYmd(2386734), array(1201, 4, 31));
		$this->assertSame($persian->ymdToJd(1201, 5, 31), 2386765);
		$this->assertSame($persian->jdToYmd(2386765), array(1201, 5, 31));
		$this->assertSame($persian->ymdToJd(1201, 6, 31), 2386796);
		$this->assertSame($persian->jdToYmd(2386796), array(1201, 6, 31));
		$this->assertSame($persian->ymdToJd(1201, 7, 30), 2386826);
		$this->assertSame($persian->jdToYmd(2386826), array(1201, 7, 30));
		$this->assertSame($persian->ymdToJd(1201, 8, 30), 2386856);
		$this->assertSame($persian->jdToYmd(2386856), array(1201, 8, 30));
		$this->assertSame($persian->ymdToJd(1201, 9, 30), 2386886);
		$this->assertSame($persian->jdToYmd(2386886), array(1201, 9, 30));
		$this->assertSame($persian->ymdToJd(1201, 10, 30), 2386916);
		$this->assertSame($persian->jdToYmd(2386916), array(1201, 10, 30));
		$this->assertSame($persian->ymdToJd(1201, 11, 30), 2386946);
		$this->assertSame($persian->jdToYmd(2386946), array(1201, 11, 30));
		$this->assertSame($persian->ymdToJd(1201, 12, 30), 2386976);
		$this->assertSame($persian->jdToYmd(2386976), array(1201, 12, 30));
		$this->assertSame($persian->ymdToJd(1202, 1, 31), 2387007);
		$this->assertSame($persian->jdToYmd(2387007), array(1202, 1, 31));
		$this->assertSame($persian->ymdToJd(1202, 2, 31), 2387038);
		$this->assertSame($persian->jdToYmd(2387038), array(1202, 2, 31));
		$this->assertSame($persian->ymdToJd(1202, 3, 31), 2387069);
		$this->assertSame($persian->jdToYmd(2387069), array(1202, 3, 31));
		$this->assertSame($persian->ymdToJd(1202, 4, 31), 2387100);
		$this->assertSame($persian->jdToYmd(2387100), array(1202, 4, 31));
		$this->assertSame($persian->ymdToJd(1202, 5, 31), 2387131);
		$this->assertSame($persian->jdToYmd(2387131), array(1202, 5, 31));
		$this->assertSame($persian->ymdToJd(1202, 6, 31), 2387162);
		$this->assertSame($persian->jdToYmd(2387162), array(1202, 6, 31));
		$this->assertSame($persian->ymdToJd(1202, 7, 30), 2387192);
		$this->assertSame($persian->jdToYmd(2387192), array(1202, 7, 30));
		$this->assertSame($persian->ymdToJd(1202, 8, 30), 2387222);
		$this->assertSame($persian->jdToYmd(2387222), array(1202, 8, 30));
		$this->assertSame($persian->ymdToJd(1202, 9, 30), 2387252);
		$this->assertSame($persian->jdToYmd(2387252), array(1202, 9, 30));
		$this->assertSame($persian->ymdToJd(1202, 10, 30), 2387282);
		$this->assertSame($persian->jdToYmd(2387282), array(1202, 10, 30));
		$this->assertSame($persian->ymdToJd(1202, 11, 30), 2387312);
		$this->assertSame($persian->jdToYmd(2387312), array(1202, 11, 30));
		$this->assertSame($persian->ymdToJd(1202, 12, 29), 2387341);
		$this->assertSame($persian->jdToYmd(2387341), array(1202, 12, 29));

		// Cover a special-case branch in the code, even though the data is not quite right...
		$this->assertSame($persian->jdToYmd(3151429), array(3294, 13, 1));
		$this->assertSame($persian->ymdToJd(3294, 12, 31), 3151429);
		$this->assertSame($persian->ymdToJd(3295, 1, 1), 3151429);
	}
}
