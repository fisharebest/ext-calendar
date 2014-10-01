<?php
namespace Fisharebest\ExtCalendar;

require __DIR__ . '/../vendor/autoload.php';

$FORMAT = "    %-32s %-32s %4.1f\n";
$ITERATIONS = 10000;
$gregorian = new GregorianCalendar;
$julian    = new JulianCalendar;
$french    = new FrenchCalendar;
$jewish    = new JewishCalendar;

$loop_overhead = microtime(true);
for ($i = 0; $i < $ITERATIONS; ++$i) { }
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
	$french->ymdToJd(12, 30, 14);
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

