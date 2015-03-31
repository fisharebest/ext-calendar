<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test harness for the class PersianCalendar
 *
 * @package   fisharebest/ExtCalendar
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

class PersianCalendarTest extends TestCase {
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
		$calendar = new PersianCalendar;

		$this->assertSame('@#DJALALI@', $calendar->gedcomCalendarEscape());
		$this->assertSame(1948320, $calendar->jdStart());
		$this->assertSame(PHP_INT_MAX, $calendar->jdEnd());
		$this->assertSame(7, $calendar->daysInWeek());
		$this->assertSame(12, $calendar->monthsInYear());
	}

	/**
	 * Test the leap year calculations.
	 *
	 * @covers Fisharebest\ExtCalendar\PersianCalendar::isLeapYear
	 *
	 * @return void
	 */
	public function testIsLeapYear() {
		$persian = new PersianCalendar;

		$this->assertSame($persian->isLeapYear(1201), true);
		$this->assertSame($persian->isLeapYear(1202), false);
		$this->assertSame($persian->isLeapYear(1203), false);
		$this->assertSame($persian->isLeapYear(1204), false);
		$this->assertSame($persian->isLeapYear(1205), true);
		$this->assertSame($persian->isLeapYear(1206), false);
		$this->assertSame($persian->isLeapYear(1207), false);
		$this->assertSame($persian->isLeapYear(1208), false);
		$this->assertSame($persian->isLeapYear(1209), true);
		$this->assertSame($persian->isLeapYear(1210), false);
		$this->assertSame($persian->isLeapYear(1211), false);
		$this->assertSame($persian->isLeapYear(1212), false);
		$this->assertSame($persian->isLeapYear(1213), false);
		$this->assertSame($persian->isLeapYear(1214), true);
		$this->assertSame($persian->isLeapYear(1215), false);
		$this->assertSame($persian->isLeapYear(1216), false);
		$this->assertSame($persian->isLeapYear(1217), false);
		$this->assertSame($persian->isLeapYear(1218), true);
		$this->assertSame($persian->isLeapYear(1219), false);
		$this->assertSame($persian->isLeapYear(1220), false);
		$this->assertSame($persian->isLeapYear(1221), false);
		$this->assertSame($persian->isLeapYear(1222), true);
		$this->assertSame($persian->isLeapYear(1223), false);
		$this->assertSame($persian->isLeapYear(1224), false);
		$this->assertSame($persian->isLeapYear(1225), false);
		$this->assertSame($persian->isLeapYear(1226), true);
		$this->assertSame($persian->isLeapYear(1227), false);
		$this->assertSame($persian->isLeapYear(1228), false);
		$this->assertSame($persian->isLeapYear(1229), false);
		$this->assertSame($persian->isLeapYear(1230), true);
		$this->assertSame($persian->isLeapYear(1231), false);
		$this->assertSame($persian->isLeapYear(1232), false);
		$this->assertSame($persian->isLeapYear(1233), false);
		$this->assertSame($persian->isLeapYear(1234), true);
		$this->assertSame($persian->isLeapYear(1235), false);
		$this->assertSame($persian->isLeapYear(1236), false);
		$this->assertSame($persian->isLeapYear(1237), false);
		$this->assertSame($persian->isLeapYear(1238), true);
		$this->assertSame($persian->isLeapYear(1239), false);
		$this->assertSame($persian->isLeapYear(1240), false);
		$this->assertSame($persian->isLeapYear(1241), false);
		$this->assertSame($persian->isLeapYear(1242), true);
		$this->assertSame($persian->isLeapYear(1243), false);
		$this->assertSame($persian->isLeapYear(1244), false);
		$this->assertSame($persian->isLeapYear(1245), false);
		$this->assertSame($persian->isLeapYear(1246), false);
		$this->assertSame($persian->isLeapYear(1247), true);
		$this->assertSame($persian->isLeapYear(1248), false);
		$this->assertSame($persian->isLeapYear(1249), false);
		$this->assertSame($persian->isLeapYear(1250), false);
		$this->assertSame($persian->isLeapYear(1251), true);
		$this->assertSame($persian->isLeapYear(1252), false);
		$this->assertSame($persian->isLeapYear(1253), false);
		$this->assertSame($persian->isLeapYear(1254), false);
		$this->assertSame($persian->isLeapYear(1255), true);
		$this->assertSame($persian->isLeapYear(1256), false);
		$this->assertSame($persian->isLeapYear(1257), false);
		$this->assertSame($persian->isLeapYear(1258), false);
		$this->assertSame($persian->isLeapYear(1259), true);
		$this->assertSame($persian->isLeapYear(1260), false);
		$this->assertSame($persian->isLeapYear(1261), false);
		$this->assertSame($persian->isLeapYear(1262), false);
		$this->assertSame($persian->isLeapYear(1263), true);
		$this->assertSame($persian->isLeapYear(1264), false);
		$this->assertSame($persian->isLeapYear(1265), false);
		$this->assertSame($persian->isLeapYear(1266), false);
		$this->assertSame($persian->isLeapYear(1267), true);
		$this->assertSame($persian->isLeapYear(1268), false);
		$this->assertSame($persian->isLeapYear(1269), false);
		$this->assertSame($persian->isLeapYear(1270), false);
		$this->assertSame($persian->isLeapYear(1271), true);
		$this->assertSame($persian->isLeapYear(1272), false);
		$this->assertSame($persian->isLeapYear(1273), false);
		$this->assertSame($persian->isLeapYear(1274), false);
		$this->assertSame($persian->isLeapYear(1275), false);
		$this->assertSame($persian->isLeapYear(1276), true);
		$this->assertSame($persian->isLeapYear(1277), false);
		$this->assertSame($persian->isLeapYear(1278), false);
		$this->assertSame($persian->isLeapYear(1279), false);
		$this->assertSame($persian->isLeapYear(1280), true);
		$this->assertSame($persian->isLeapYear(1281), false);
		$this->assertSame($persian->isLeapYear(1282), false);
		$this->assertSame($persian->isLeapYear(1283), false);
		$this->assertSame($persian->isLeapYear(1284), true);
		$this->assertSame($persian->isLeapYear(1285), false);
		$this->assertSame($persian->isLeapYear(1286), false);
		$this->assertSame($persian->isLeapYear(1287), false);
		$this->assertSame($persian->isLeapYear(1288), true);
		$this->assertSame($persian->isLeapYear(1289), false);
		$this->assertSame($persian->isLeapYear(1290), false);
		$this->assertSame($persian->isLeapYear(1291), false);
		$this->assertSame($persian->isLeapYear(1292), true);
		$this->assertSame($persian->isLeapYear(1293), false);
		$this->assertSame($persian->isLeapYear(1294), false);
		$this->assertSame($persian->isLeapYear(1295), false);
		$this->assertSame($persian->isLeapYear(1296), true);
		$this->assertSame($persian->isLeapYear(1297), false);
		$this->assertSame($persian->isLeapYear(1298), false);
		$this->assertSame($persian->isLeapYear(1299), false);
		$this->assertSame($persian->isLeapYear(1300), true);
		$this->assertSame($persian->isLeapYear(1301), false);
		$this->assertSame($persian->isLeapYear(1302), false);
		$this->assertSame($persian->isLeapYear(1303), false);
		$this->assertSame($persian->isLeapYear(1304), true);
		$this->assertSame($persian->isLeapYear(1305), false);
		$this->assertSame($persian->isLeapYear(1306), false);
		$this->assertSame($persian->isLeapYear(1307), false);
		$this->assertSame($persian->isLeapYear(1308), false);
		$this->assertSame($persian->isLeapYear(1309), true);
		$this->assertSame($persian->isLeapYear(1310), false);
		$this->assertSame($persian->isLeapYear(1311), false);
		$this->assertSame($persian->isLeapYear(1312), false);
		$this->assertSame($persian->isLeapYear(1313), true);
		$this->assertSame($persian->isLeapYear(1314), false);
		$this->assertSame($persian->isLeapYear(1315), false);
		$this->assertSame($persian->isLeapYear(1316), false);
		$this->assertSame($persian->isLeapYear(1317), true);
		$this->assertSame($persian->isLeapYear(1318), false);
		$this->assertSame($persian->isLeapYear(1319), false);
		$this->assertSame($persian->isLeapYear(1320), false);
		$this->assertSame($persian->isLeapYear(1321), true);
		$this->assertSame($persian->isLeapYear(1322), false);
		$this->assertSame($persian->isLeapYear(1323), false);
		$this->assertSame($persian->isLeapYear(1324), false);
		$this->assertSame($persian->isLeapYear(1325), true);
		$this->assertSame($persian->isLeapYear(1326), false);
		$this->assertSame($persian->isLeapYear(1327), false);
		$this->assertSame($persian->isLeapYear(1328), false);
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
