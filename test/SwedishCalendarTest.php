<?php

/**
 * Test harness for the class SwedishCalendar
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2014-2021 Greg Roach
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

namespace Fisharebest\ExtCalendar;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class SwedishCalendarTest extends TestCase
{
    /**
     * Create the shim functions, so we can run tests on servers which do
     * not have the ext/calendar library installed.  For example HHVM.
     *
     * @return void
     */
    public function set_up()
    {
        Shim::create();
    }

    /**
     * Test the class constants.
     *
     * @coversNothing
     *
     * @return void
     */
    public function testConstants()
    {
        $calendar = new SwedishCalendar();

        $this->assertSame('@#DSWEDISH@', $calendar->gedcomCalendarEscape());
        $this->assertSame(2342041, $calendar->jdStart());
        $this->assertSame(2346425, $calendar->jdEnd());
        $this->assertSame(7, $calendar->daysInWeek());
        $this->assertSame(12, $calendar->monthsInYear());
    }

    /**
     * Test the leap year calculations.
     *
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::isLeapYear
     *
     * @return void
     */
    public function testIsLeapYear()
    {
        $swedish = new SwedishCalendar();

        $this->assertSame($swedish->isLeapYear(1700), false);
        $this->assertSame($swedish->isLeapYear(1701), false);
        $this->assertSame($swedish->isLeapYear(1702), false);
        $this->assertSame($swedish->isLeapYear(1703), false);
        $this->assertSame($swedish->isLeapYear(1704), true);
        $this->assertSame($swedish->isLeapYear(1708), true);
        $this->assertSame($swedish->isLeapYear(1712), true);
    }

    /**
     * Test days in month including Swedish-specific edge cases.
     *
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::daysInMonth
     *
     * @return void
     */
    public function testDaysInMonth()
    {
        $swedish = new SwedishCalendar();

        $this->assertSame(31, $swedish->daysInMonth(1700, 3));
        $this->assertSame(29, $swedish->daysInMonth(1704, 2));
        $this->assertSame(29, $swedish->daysInMonth(1708, 2));
        $this->assertSame(28, $swedish->daysInMonth(1711, 2));
        $this->assertSame(30, $swedish->daysInMonth(1712, 2));
    }

    /**
     * Test conversion of calendar dates into Julian days.
     *
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::ymdToJd
     *
     * @return void
     */
    public function testYmdToJd()
    {
        $swedish = new SwedishCalendar();

        $this->assertSame(JulianToJD(2, 28, 1700), $swedish->ymdToJd(1700, 3, 1));
        $this->assertSame(JulianToJD(2, 28, 1712), $swedish->ymdToJd(1712, 2, 29));
        $this->assertSame(JulianToJD(2, 29, 1712), $swedish->ymdToJd(1712, 2, 30));

        $this->assertSame(array(1700, 3, 1), $swedish->jdToYmd(JulianToJD(2, 28, 1700)));
        $this->assertSame(array(1712, 2, 29), $swedish->jdToYmd(JulianToJD(2, 28, 1712)));
        $this->assertSame(array(1712, 2, 30), $swedish->jdToYmd(JulianToJD(2, 29, 1712)));
    }

    /**
     * Test the conversion of calendar dates into Julian days, and vice versa, returns the same result.
     *
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::ymdToJd
     *
     * @return void
     */
    public function testJdToYmdReciprocity()
    {
        $calendar = new SwedishCalendar();

        for ($jd = $calendar->jdStart(); $jd <= $calendar->jdEnd(); $jd++) {
            list($y, $m, $d) = $calendar->jdToYmd($jd);
            $this->assertSame($jd, $calendar->ymdToJd($y, $m, $d));
        }
    }

    /**
     * Test that months outside the Swedish usage period are invalid.
     *
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::daysInMonth
     */
    public function testDaysInMonthInvalidMonth()
    {
        $this->expectExceptionMessage('Month 2 is invalid for this calendar');
        $this->expectException('InvalidArgumentException');

        $calendar = new SwedishCalendar();
        $calendar->daysInMonth(1700, 2);
    }

    /**
     * Test that days outside month limits are rejected.
     *
     * @covers \Fisharebest\ExtCalendar\SwedishCalendar::ymdToJd
     */
    public function testYmdToJdInvalidDay()
    {
        $this->expectExceptionMessage('Day 31 is invalid for this calendar');
        $this->expectException('InvalidArgumentException');

        $calendar = new SwedishCalendar();
        $calendar->ymdToJd(1712, 2, 31);
    }
}