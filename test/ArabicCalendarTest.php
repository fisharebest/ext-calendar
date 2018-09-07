<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit\Framework\TestCase;

/**
 * Test harness for the class ArabicCalendar
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
class ArabicCalendarTest extends TestCase
{
    /**
     * Create the shim functions, so we can run tests on servers which do
     * not have the ext/calendar library installed.  For example HHVM.
     *
     * @return void
     */
    public function setUp()
    {
        Shim::create();
    }

    /**
     * Test the class constants.
     *
     * @coversNone
     *
     * @return void
     */
    public function testConstants()
    {
        $calendar = new ArabicCalendar();

        $this->assertSame('@#DHIJRI@', $calendar->gedcomCalendarEscape());
        $this->assertSame(1948440, $calendar->jdStart());
        $this->assertSame(PHP_INT_MAX, $calendar->jdEnd());
        $this->assertSame(7, $calendar->daysInWeek());
        $this->assertSame(12, $calendar->monthsInYear());
    }

    /**
     * Test the leap year calculations.
     *
     * @covers \Fisharebest\ExtCalendar\ArabicCalendar::isLeapYear
     *
     * @return void
     */
    public function testIsLeapYear()
    {
        $arabic = new ArabicCalendar();

        $this->assertSame($arabic->isLeapYear(1201), false);
        $this->assertSame($arabic->isLeapYear(1202), true);
        $this->assertSame($arabic->isLeapYear(1203), false);
        $this->assertSame($arabic->isLeapYear(1204), false);
        $this->assertSame($arabic->isLeapYear(1205), true);
        $this->assertSame($arabic->isLeapYear(1206), false);
        $this->assertSame($arabic->isLeapYear(1207), true);
        $this->assertSame($arabic->isLeapYear(1208), false);
        $this->assertSame($arabic->isLeapYear(1209), false);
        $this->assertSame($arabic->isLeapYear(1210), true);
        $this->assertSame($arabic->isLeapYear(1211), false);
        $this->assertSame($arabic->isLeapYear(1212), false);
        $this->assertSame($arabic->isLeapYear(1213), true);
        $this->assertSame($arabic->isLeapYear(1214), false);
        $this->assertSame($arabic->isLeapYear(1215), false);
        $this->assertSame($arabic->isLeapYear(1216), true);
        $this->assertSame($arabic->isLeapYear(1217), false);
        $this->assertSame($arabic->isLeapYear(1218), true);
        $this->assertSame($arabic->isLeapYear(1219), false);
        $this->assertSame($arabic->isLeapYear(1220), false);
        $this->assertSame($arabic->isLeapYear(1221), true);
        $this->assertSame($arabic->isLeapYear(1222), false);
        $this->assertSame($arabic->isLeapYear(1223), false);
        $this->assertSame($arabic->isLeapYear(1224), true);
        $this->assertSame($arabic->isLeapYear(1225), false);
        $this->assertSame($arabic->isLeapYear(1226), true);
        $this->assertSame($arabic->isLeapYear(1227), false);
        $this->assertSame($arabic->isLeapYear(1228), false);
        $this->assertSame($arabic->isLeapYear(1229), true);
        $this->assertSame($arabic->isLeapYear(1230), false);
    }

    /**
     * Test the calculation of the number of days in each month.
     *
     * @covers \Fisharebest\ExtCalendar\ArabicCalendar::daysInMonth
     *
     * @return void
     */
    public function testDaysInMonth()
    {
        $arabic = new ArabicCalendar();

        $this->assertSame($arabic->daysInMonth(1201, 1), 30);
        $this->assertSame($arabic->daysInMonth(1201, 2), 28);
        $this->assertSame($arabic->daysInMonth(1201, 3), 30);
        $this->assertSame($arabic->daysInMonth(1201, 4), 29);
        $this->assertSame($arabic->daysInMonth(1201, 5), 30);
        $this->assertSame($arabic->daysInMonth(1201, 6), 29);
        $this->assertSame($arabic->daysInMonth(1201, 7), 30);
        $this->assertSame($arabic->daysInMonth(1201, 8), 29);
        $this->assertSame($arabic->daysInMonth(1201, 9), 30);
        $this->assertSame($arabic->daysInMonth(1201, 10), 29);
        $this->assertSame($arabic->daysInMonth(1201, 11), 30);
        $this->assertSame($arabic->daysInMonth(1201, 12), 29);
        $this->assertSame($arabic->daysInMonth(1202, 1), 30);
        $this->assertSame($arabic->daysInMonth(1202, 2), 28);
        $this->assertSame($arabic->daysInMonth(1202, 3), 30);
        $this->assertSame($arabic->daysInMonth(1202, 4), 29);
        $this->assertSame($arabic->daysInMonth(1202, 5), 30);
        $this->assertSame($arabic->daysInMonth(1202, 6), 29);
        $this->assertSame($arabic->daysInMonth(1202, 7), 30);
        $this->assertSame($arabic->daysInMonth(1202, 8), 29);
        $this->assertSame($arabic->daysInMonth(1202, 9), 30);
        $this->assertSame($arabic->daysInMonth(1202, 10), 29);
        $this->assertSame($arabic->daysInMonth(1202, 11), 30);
        $this->assertSame($arabic->daysInMonth(1202, 12), 30);
    }

    /**
     * Test the conversion of calendar dates into Julian days.
     *
     * @covers \Fisharebest\ExtCalendar\ArabicCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\ArabicCalendar::ymdToJd
     *
     * @return void
     */
    public function testYmdTojd()
    {
        $arabic = new ArabicCalendar();

        $this->assertSame($arabic->ymdToJd(1, 1, 1), 1948440);  // 19 JUL 622 (Gregorian)
        $this->assertSame($arabic->jdToYmd(1948440), array(1, 1, 1));
        $this->assertSame($arabic->ymdToJd(1201, 1, 30), 2373709);
        $this->assertSame($arabic->jdToYmd(2373709), array(1201,1,30));
        $this->assertSame($arabic->ymdToJd(1201, 2, 28), 2373737);
        $this->assertSame($arabic->jdToYmd(2373737), array(1201,2,28));
        $this->assertSame($arabic->ymdToJd(1201, 3, 30), 2373768);
        $this->assertSame($arabic->jdToYmd(2373768), array(1201,3,30));
        $this->assertSame($arabic->ymdToJd(1201, 4, 29), 2373797);
        $this->assertSame($arabic->jdToYmd(2373797), array(1201,4,29));
        $this->assertSame($arabic->ymdToJd(1201, 5, 30), 2373827);
        $this->assertSame($arabic->jdToYmd(2373827), array(1201,5,30));
        $this->assertSame($arabic->ymdToJd(1201, 6, 29), 2373856);
        $this->assertSame($arabic->jdToYmd(2373856), array(1201,6,29));
        $this->assertSame($arabic->ymdToJd(1201, 7, 30), 2373886);
        $this->assertSame($arabic->jdToYmd(2373886), array(1201,7,30));
        $this->assertSame($arabic->ymdToJd(1201, 8, 29), 2373915);
        $this->assertSame($arabic->jdToYmd(2373915), array(1201,8,29));
        $this->assertSame($arabic->ymdToJd(1201, 9, 30), 2373945);
        $this->assertSame($arabic->jdToYmd(2373945), array(1201,9,30));
        $this->assertSame($arabic->ymdToJd(1201, 10, 29), 2373974);
        $this->assertSame($arabic->jdToYmd(2373974), array(1201,10,29));
        $this->assertSame($arabic->ymdToJd(1201, 11, 30), 2374004);
        $this->assertSame($arabic->jdToYmd(2374004), array(1201,11,30));
        $this->assertSame($arabic->ymdToJd(1201, 12, 29), 2374033);
        $this->assertSame($arabic->jdToYmd(2374033), array(1201,12,29));
        $this->assertSame($arabic->ymdToJd(1202, 1, 30), 2374063);
        $this->assertSame($arabic->jdToYmd(2374063), array(1202,1,30));
        $this->assertSame($arabic->ymdToJd(1202, 2, 28), 2374091);
        $this->assertSame($arabic->jdToYmd(2374091), array(1202,2,28));
        $this->assertSame($arabic->ymdToJd(1202, 3, 30), 2374122);
        $this->assertSame($arabic->jdToYmd(2374122), array(1202,3,30));
        $this->assertSame($arabic->ymdToJd(1202, 4, 29), 2374151);
        $this->assertSame($arabic->jdToYmd(2374151), array(1202,4,29));
        $this->assertSame($arabic->ymdToJd(1202, 5, 30), 2374181);
        $this->assertSame($arabic->jdToYmd(2374181), array(1202,5,30));
        $this->assertSame($arabic->ymdToJd(1202, 6, 29), 2374210);
        $this->assertSame($arabic->jdToYmd(2374210), array(1202,6,29));
        $this->assertSame($arabic->ymdToJd(1202, 7, 30), 2374240);
        $this->assertSame($arabic->jdToYmd(2374240), array(1202,7,30));
        $this->assertSame($arabic->ymdToJd(1202, 8, 29), 2374269);
        $this->assertSame($arabic->jdToYmd(2374269), array(1202,8,29));
        $this->assertSame($arabic->ymdToJd(1202, 9, 30), 2374299);
        $this->assertSame($arabic->jdToYmd(2374299), array(1202,9,30));
        $this->assertSame($arabic->ymdToJd(1202, 10, 29), 2374328);
        $this->assertSame($arabic->jdToYmd(2374328), array(1202,10,29));
        $this->assertSame($arabic->ymdToJd(1202, 11, 30), 2374358);
        $this->assertSame($arabic->jdToYmd(2374358), array(1202,11,30));
        $this->assertSame($arabic->ymdToJd(1202, 12, 30), 2374388);
        $this->assertSame($arabic->jdToYmd(2374388), array(1202,12,30));
    }

    /**
     * Test the conversion of calendar dates into Julian days, and vice versa, returns the same result.
     *
     * @covers \Fisharebest\ExtCalendar\ArabicCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\ArabicCalendar::ymdToJd
     *
     * @return void
     */
    public function testJdToYmdReciprocity()
    {
        $calendar = new ArabicCalendar();

        for ($jd = $calendar->jdStart(); $jd < min(2457755, $calendar->jdEnd()); $jd += 79) {
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
    public function testYmdToJdInvalidMonth()
    {
        $calendar = new ArabicCalendar();
        $calendar->ymdToJd(4, 14, 1);
    }
}
