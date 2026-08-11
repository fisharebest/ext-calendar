<?php

/**
 * Class SwedishCalendar - calculations for the Swedish calendar.
 *
 * This calendar was used from 1 March 1700 to 30 February 1712.
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

use InvalidArgumentException;

class SwedishCalendar extends JulianCalendar implements CalendarInterface
{
    /**
     * Determine the number of days in a specified month, allowing for leap years, etc.
     *
     * @param int $year
     * @param int $month
     *
     * @return int
     */
    public function daysInMonth($year, $month)
    {
        if ($year < 1700 || $year > 1712) {
            throw new InvalidArgumentException('Year ' . $year . ' is invalid for this calendar');
        }

        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException('Month ' . $month . ' is invalid for this calendar');
        }

        if ($year === 1700 && $month < 3 || $year === 1712 && $month > 2) {
            throw new InvalidArgumentException('Month ' . $month . ' is invalid for this calendar');
        }

        if ($month !== 2) {
            return parent::daysInMonth($year, $month);
        }

        if ($year === 1712) {
            return 30;
        }

        if ($year === 1700) {
            return 28;
        }

        return parent::daysInMonth($year, $month);
    }

    /**
     * The escape sequence used to indicate this calendar in GEDCOM files.
     *
     * @return string
     */
    public function gedcomCalendarEscape()
    {
        return '@#DSWEDISH@';
    }

    /**
     * Determine whether or not a given year is a leap-year.
     *
     * @param int $year
     *
     * @return bool
     */
    public function isLeapYear($year)
    {
        if ($year === 1700) {
            return false;
        }

        if ($year === 1712) {
            return true;
        }

        return parent::isLeapYear($year);
    }

    /**
     * What is the highest Julian day number that can be converted into this calendar.
     *
     * @return int
     */
    public function jdEnd()
    {
        return 2346425; // 30 FEB 1712 = 29 FEB 1712 (Julian)
    }

    /**
     * What is the lowest Julian day number that can be converted into this calendar.
     *
     * @return int
     */
    public function jdStart()
    {
        return 2342041; // 01 MAR 1700 = 28 FEB 1700 (Julian)
    }

    /**
     * Convert a Julian day number into a year/month/day.
     *
     * @param int $julian_day
     *
     * @return int[]
     */
    public function jdToYmd($julian_day)
    {
        if ($julian_day === $this->jdEnd()) {
            return array(1712, 2, 30);
        }

        return parent::jdToYmd($julian_day + 1);
    }

    /**
     * Convert a year/month/day to a Julian day number.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return int
     */
    public function ymdToJd($year, $month, $day)
    {
        $days_in_month = $this->daysInMonth($year, $month);

        if ($day < 1 || $day > $days_in_month) {
            throw new InvalidArgumentException('Day ' . $day . ' is invalid for this calendar');
        }

        if ($year === 1712 && $month === 2 && $day === 30) {
            return parent::ymdToJd(1712, 2, 29);
        }

        return parent::ymdToJd($year, $month, $day) - 1;
    }
}