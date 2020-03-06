<?php
namespace Fisharebest\ExtCalendar;

use PHPUnit\Framework\TestCase;

/**
 * Test harness for the class JulianCalendar
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2014-2020 Greg Roach
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
class JulianCalendarTest extends TestCase
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
        $calendar = new JulianCalendar();

        $this->assertSame('@#DJULIAN@', $calendar->gedcomCalendarEscape());
        $this->assertSame(1, $calendar->jdStart());
        $this->assertSame(PHP_INT_MAX, $calendar->jdEnd());
        $this->assertSame(7, $calendar->daysInWeek());
        $this->assertSame(12, $calendar->monthsInYear());
    }

    /**
     * Test the leap year calculations.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::isLeapYear
     *
     * @return void
     */
    public function testIsLeapYear()
    {
        $julian = new JulianCalendar();

        $this->assertSame($julian->isLeapYear(-5), true);
        $this->assertSame($julian->isLeapYear(-4), false);
        $this->assertSame($julian->isLeapYear(-3), false);
        $this->assertSame($julian->isLeapYear(-2), false);
        $this->assertSame($julian->isLeapYear(-1), true);
        $this->assertSame($julian->isLeapYear(1500), true);
        $this->assertSame($julian->isLeapYear(1600), true);
        $this->assertSame($julian->isLeapYear(1700), true);
        $this->assertSame($julian->isLeapYear(1800), true);
        $this->assertSame($julian->isLeapYear(1900), true);
        $this->assertSame($julian->isLeapYear(1999), false);
        $this->assertSame($julian->isLeapYear(2000), true);
        $this->assertSame($julian->isLeapYear(2001), false);
        $this->assertSame($julian->isLeapYear(2002), false);
        $this->assertSame($julian->isLeapYear(2003), false);
        $this->assertSame($julian->isLeapYear(2004), true);
        $this->assertSame($julian->isLeapYear(2005), false);
        $this->assertSame($julian->isLeapYear(2100), true);
        $this->assertSame($julian->isLeapYear(2200), true);
    }

    /**
     * Test the calculation of Easter against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::easterDays
     *
     * @return void
     */
    public function testEasterDaysCoverage()
    {
        $julian = new JulianCalendar();

        foreach (array(2037, 2036, 2029, 1972, -4, -5, -9, -19, -20, -23, -175) as $year) {
            $this->assertSame($julian->easterDays($year), easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
        }
    }

    /**
     * Test the calculation of Easter against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::easterDays
     *
     * @return void
     */
    public function testEasterDaysModernTimes()
    {
        $julian = new JulianCalendar();

        for ($year = 1970; $year <= 2037; ++$year) {
            $this->assertSame($julian->easterDays($year), easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
        }
    }

    /**
     * Test the calculation of the number of days in each month against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::daysInMonth
     *
     * @return void
     */
    public function testDaysInMonth()
    {
        $julian = new JulianCalendar();

        foreach (array(-5, -4, -1, 1, 1500, 1600, 1700, 1800, 1900, 1999, 2000, 2001, 2002, 2003, 2004, 2005, 2100, 2200) as $year) {
            for ($month = 1; $month <= 12; ++$month) {
                $this->assertSame($julian->daysInMonth($year, $month), cal_days_in_month(CAL_JULIAN, $month, $year));
            }
        }
    }

    /**
     * Test the conversion of calendar dates into Julian days against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
     *
     * @return void
     */
    public function testYmdToJdDays()
    {
        $julian = new JulianCalendar();

        foreach (array(2012, 2014) as $year) {
            for ($day = 1; $day <= 28; ++$day) {
                $julian_day = JulianToJD(8, $day, $year);
                $ymd = $julian->jdToYmd($julian_day);

                $this->assertSame($julian->ymdToJd($year, 8, $day), $julian_day);
                $this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToJulian($julian_day));
            }
        }
    }

    /**
     * Test the conversion of calendar dates into Julian days against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
     *
     * @return void
     */
    public function testYmdToJdMonths()
    {
        $julian = new JulianCalendar();

        for ($month = 1; $month <= 12; ++$month) {
            foreach (array(2012, 2014) as $year) {
                $julian_day = JulianToJD($month, 9, $year);
                $ymd = $julian->jdToYmd($julian_day);

                $this->assertSame($julian->ymdToJd($year, $month, 9), $julian_day);
                $this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToJulian($julian_day));
            }
        }
    }

    /**
     * Test the conversion of calendar dates into Julian days against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
     *
     * @return void
     */
    public function testYmdToJdYears()
    {
        $julian = new JulianCalendar();

        for ($year = 1970; $year <= 2037; ++$year) {
            $julian_day = JulianToJD(8, 9, $year);
            $ymd = $julian->jdToYmd($julian_day);

            $this->assertSame($julian->ymdToJd($year, 8, 9), $julian_day);
            $this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToJulian($julian_day));
        }
    }

    /**
     * Test the conversion of calendar dates into Julian days against the reference implementation.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
     *
     * @return void
     */
    public function testYmdToJdYearsBc()
    {
        $julian = new JulianCalendar();

        for ($year = -5; $year <= 5; ++$year) {
            if ($year != 0) {
                $julian_day = JulianToJD(1, 1, $year);
                $ymd = $julian->jdToYmd($julian_day);

                $this->assertSame($julian->ymdToJd($year, 1, 1), $julian_day);
                $this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToJulian($julian_day));

                $julian_day = JulianToJD(12, 31, $year);
                $ymd = $julian->jdToYmd($julian_day);

                $this->assertSame($julian->ymdToJd($year, 12, 31), $julian_day);
                $this->assertSame($ymd[1] . '/' . $ymd[2] . '/' . $ymd[0], JDToJulian($julian_day));
            }
        }
    }

    /**
     * Test the conversion of calendar dates into Julian days, and vice versa, returns the same result.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::jdToYmd
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
     *
     * @return void
     */
    public function testJdToYmdReciprocity()
    {
        $calendar = new JulianCalendar();

        for ($jd = $calendar->jdStart(); $jd < min(2457755, $calendar->jdEnd()); $jd += 79) {
            list($y, $m, $d) = $calendar->jdToYmd($jd);
            $this->assertSame($jd, $calendar->ymdToJd($y, $m, $d));
        }
    }

    /**
     * Test the conversion of a YMD date to JD when the month is not a valid number.
     *
     * @covers \Fisharebest\ExtCalendar\JulianCalendar::ymdToJd
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Month 14 is invalid for this calendar
     */
    public function testYmdToJdInvalidMonth()
    {
        $calendar = new JulianCalendar();
        $calendar->ymdToJd(4, 14, 1);
    }
}
