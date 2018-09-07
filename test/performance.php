<?php
namespace Fisharebest\ExtCalendar;

/**
 * Compare the performance of the native PHP functions with our implementation.
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
require __DIR__ . '/../vendor/autoload.php';

$FORMAT = "    %-32s %-32s %4.1f\n";
$ITERATIONS = 10000;
$gregorian = new GregorianCalendar();
$julian    = new JulianCalendar();
$french    = new FrenchCalendar();
$jewish    = new JewishCalendar();
$arabic    = new ArabicCalendar();
$persian   = new PersianCalendar();

$loop_overhead = microtime(true);
for ($i = 0; $i < $ITERATIONS; ++$i) {
}
$loop_overhead = microtime(true) - $loop_overhead;

// JDToFrench

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    explode('/', JDToFrench(2380947));
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $french->jdToYmd(2380947);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'JDToFrench()', 'FrenchCalendar->jdToYmd()', $t2 / $t1);

// JDToGregorian

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    explode('/', JDToGregorian(2380947));
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $gregorian->jdToYmd(2380947);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'JDToGregorian()', 'GregorianCalendar->jdToYmd()', $t2 / $t1);

// jdtojewish

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    explode('/', jdtojewish(2380947));
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $jewish->jdToYmd(2380947);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'jdtojewish()', 'JewishCalendar->jdToYmd()', $t2 / $t1);

// JDToJulian

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    explode('/', JDToJulian(2380947));
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $julian->jdToYmd(2380947);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'JDToJulian()', 'JulianCalendar->jdToYmd()', $t2 / $t1);

// FrenchToJD

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    FrenchToJD(12, 31, 2014);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $french->ymdToJd(31, 12, 14);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'FrenchToJD()', 'FrenchCalendar->ymdToJd()', $t2 / $t1);

// GregorianToJD

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    GregorianToJD(12, 31, 2014);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $gregorian->ymdToJd(2014, 12, 31);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'GregorianToJD()', 'GregorianCalendar->ymdToJd()', $t2 / $t1);

// jewishtojd

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    jewishtojd(13, 29, 2014);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $jewish->ymdToJd(2014, 13, 29);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'jewishtojd()', 'JewishCalendar->ymdToJd()', $t2 / $t1);

// JulianToJD

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    JulianToJD(12, 31, 2014);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $julian->ymdToJd(2014, 12, 31);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'JulianToJD()', 'JulianCalendar->ymdToJd()', $t2 / $t1);

// cal_days_in_month(CAL_FRENCH)

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    cal_days_in_month(CAL_FRENCH, 13, 13);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $french->daysInMonth(13, 13);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'cal_days_in_month(CAL_FRENCH)', 'FrenchCalendar->daysInMonth()', $t2 / $t1);

// cal_days_in_month(CAL_GREGORIAN)

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    cal_days_in_month(CAL_GREGORIAN, 2, 2014);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $gregorian->daysInMonth(2014, 2);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'cal_days_in_month(CAL_GREGORIAN)', 'GregorianCalendar->daysInMonth()', $t2 / $t1);

// cal_days_in_month(CAL_JEWISH)

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    cal_days_in_month(CAL_JEWISH, 2, 5714);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $jewish->daysInMonth(5714, 2);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'cal_days_in_month(CAL_JEWISH)', 'JewishCalendar->daysInMonth()', $t2 / $t1);

// cal_days_in_month(CAL_JULIAN)

$t1 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    cal_days_in_month(CAL_JULIAN, 2, 2014);
}
$t1 = microtime(true) - $t1 - $loop_overhead;

$t2 = microtime(true); for ($i = 0; $i < $ITERATIONS; ++$i) {
    $julian->daysInMonth(2014, 2);
}
$t2 = microtime(true) - $t2 - $loop_overhead;

printf($FORMAT, 'cal_days_in_month(CAL_JULIAN)', 'JulianCalendar->daysInMonth()', $t2 / $t1);

// Average calculation times

printf(PHP_EOL);
printf('Average calculation time (in ns)' . PHP_EOL);

$today_jd = gregoriantojd(date('m'), date('d'), date('Y'));
$FORMAT2 = '    %-24s %8d %8d %8d' . PHP_EOL;
printf('    %-24s %8s %8s %8s' . PHP_EOL, 'Calendar', 'Elements', 'jdToYmd', 'ymdToJd');

function testAverageTime(CalendarInterface $calendar, $end_jd, $nb_iterations, $format)
{
    $rand_jd = range($calendar->jdStart(), min($end_jd, $calendar->jdEnd()));
    $nb_elements = min($nb_iterations, count($rand_jd));
    $rand_jd_keys = array_rand($rand_jd, $nb_elements);
    $rand_ymd = array();

    $t1 = microtime(true);
    foreach ($rand_jd_keys as $key) {
        $rand_ymd[] = $calendar->jdToYmd($rand_jd[$key]);
    }
    $t1 = microtime(true) - $t1;

    $t2 = microtime(true);
    foreach ($rand_ymd as $ymd) {
        $calendar->ymdToJd($ymd[0], $ymd[1], $ymd[2]);
    }
    $t2 = microtime(true) - $t2;

    printf(
        $format,
        (new \ReflectionClass($calendar))->getShortName(),
        $nb_elements,
        (1000000 * $t1) / $nb_elements,
        (1000000 * $t2) / $nb_elements
    );
}

testAverageTime($gregorian, $today_jd, $ITERATIONS, $FORMAT2);
testAverageTime($julian, $today_jd, $ITERATIONS, $FORMAT2);
testAverageTime($jewish, $today_jd, $ITERATIONS, $FORMAT2);
testAverageTime($french, $today_jd, $ITERATIONS, $FORMAT2);
testAverageTime($arabic, $today_jd, $ITERATIONS, $FORMAT2);
testAverageTime($persian, $today_jd, $ITERATIONS, $FORMAT2);
