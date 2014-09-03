<?php
namespace Fisharebest\ExtCalendar;

/**
 * class JewishCalendar - calculations for the Jewish calendar.
 *
 * Hebrew characters in this file have UTF-8 encoding.
 *
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2014 Greg Roach
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
class JewishCalendar extends Calendar implements CalendarInterface{
	/** The earliest Julian Day number that can be converted into this calendar. */
	const JD_START = 347998;

	/** The latest Julian Day number that can be converted into this calendar. */
	const JD_END = 324542846;

	/** The maximum number of days in any month. */
	const MAX_DAYS_IN_MONTH = 30;

	/** The maximum number of months in any year. */
	const MAX_MONTHS_IN_YEAR = 13;

	/** Place this symbol before the final letter of a sequence of numerals. */
	const GERSHAYIM = '״';

	/** Place this symbol after a single numeral. */
	const GERESH = '׳';

	/** Word for thousand. */
	const ALAFIM = 'אלפים';

	/** A year that is one day shorter than normal. */
	const DEFECTIVE_YEAR  = -1;

	/** A year that has the normal number of days. */
	const REGULAR_YEAR  = 0;

	/** A year that is one day longer than normal. */
	const COMPLETE_YEAR  = 1;

	/** The conversion functions need to refer to specific years. */
	const TISHRI = 1;
	const HESHVAN = 2;
	const KISLEV = 3;
	const TEVET = 4;
	const SHEVAT = 5;
	const ADAR_1 = 6;
	const ADAR_2 = 7;
	const NISAN = 8;
	const IYAR = 9;
	const SIVAN = 10;
	const TAMMUZ = 11;
	const AV = 12;
	const ELUL = 13;

	/**
	 * Hebrew numbers are represented by letters, similar to roman numerals.
	 *
	 * @var string[]
	 */
	private static $HEBREW_NUMERALS = array(
		9000 => 'ט',
		8000 => 'ח',
		7000 => 'ז',
		6000 => 'ו',
		5000 => 'ה',
		4000 => 'ד',
		3000 => 'ג',
		2000 => 'ב',
		1000 => 'א',
		400 => 'ת',
		300 => 'ש',
		200 => 'ר',
		100 => 'ק',
		90 => 'צ',
		80 => 'פ',
		70 => 'ע',
		60 => 'ס',
		50 => 'נ',
		40 => 'מ',
		30 => 'ל',
		20 => 'כ',
		16 => 'טז',
		15 => 'טו',
		10 => 'י',
		9 => 'ט',
		8 => 'ח',
		7 => 'ז',
		6 => 'ו',
		5 => 'ה',
		4 => 'ד',
		3 => 'ג',
		2 => 'ב',
		1 => 'א',
	);

	/**
	 * Some numerals take a different form when they appear at the end of a number.
	 *
	 * @var string[]
	 */
	private static $HEBREW_NUMERALS_FINAL = array(
		90 => 'צ',
		80 => 'פ',
		70 => 'ע',
		60 => 'ס',
		50 => 'נ',
		40 => 'מ',
		30 => 'ל',
		20 => 'כ',
		10 => 'י',
	);

	/**
	 * Determine whether a year is a leap year.
	 *
	 * @param  int  $year
	 * @return bool
	 */
	public function leapYear($year) {
		return (7 * $year + 1) % 19 < 7;
	}

	/**
	 * Convert a Julian day number into a year.
	 *
	 * @param int $jd
	 *
	 * @return int;
	 */
	protected function jdToY($jd) {
		// Generate an approximate year - may be out by one either way.  Add one to it.
		$year = (int)(($jd - 347998) / 365) + 1;

		// Adjust by subtracting years;
		while ($this->yToJd($year) > $jd) {
			$year--;
		}

		return $year;
	}

	/**
	 * Convert a Julian day number into a year/month/day.
	 *
	 * @param int $jd
	 *
	 * @return int[];
	 */
	public function jdToYmd($jd) {
		// Find the year
		$year = $this->jdToY($jd);

		// Add one month at a time, to use up the remaining days.
		$month = 1;
		$day = $jd - $this->yToJd($year) + 1;

		while ($day > $this->daysInMonth($year, $month)) {
			$day -= $this->daysInMonth($year, $month);
			$month += 1;
		}

		// PHP 5.4 and earlier converted non leap-year Adar into month 6, instead of month 7.
		$month -= (Shim::emulateBug54254() && $month == 7 && !$this->leapYear($year)) ? 1 : 0;

		return array($year, $month, $day);
	}

	/**
	 * Calculate the Julian Day number of the first day in a year
	 *
	 * @param  int $year
	 *
	 * @return int
	 */
	protected function yToJd($year) {
		$div19 = (int)(($year - 1) / 19);
		$mod19 = ($year - 1) % 19;
		$months = 235 * $div19 + 12 * $mod19 + (int)((7 * $mod19 + 1) / 19);
		$parts = 204 + 793 * ($months % 1080);
		$hours = 5 + 12 * $months + 793 * (int)($months / 1080) + (int)($parts / 1080);
		$conjunction = 1080 * ($hours % 24) + ($parts % 1080);
		$jd = 1 + 29 * $months + (int)($hours / 24);

		if ($conjunction >= 19440 || $jd % 7 == 2 && $conjunction >= 9924 && !$this->leapYear($year) || $jd % 7 == 1 && $conjunction >= 16789 && $this->leapYear($year - 1)) {
			$jd++;
		}

		switch ($jd % 7) {
			case 0:
			case 3:
			case 5:
				return $jd + 347998;
			default:
				return $jd + 347997;
		}
	}

	/**
	 * Convert a year/month/day into a Julian day number
	 *
	 * @param int $year
	 * @param int $month
	 * @param int $day
	 *
	 * @return int
	 */
	public function ymdToJd($year, $month, $day) {
		// Assume each month has 29 days, and then add extra day for each 30 day month.
		$jd = $this->yToJd($year) + 29 * ($month - 1);
		if ($month > self::TISHRI) {
			// Tishri has 30 days.
			$jd++;
			if ($month > self::HESHVAN) {
				$year_type = $this->yearType($year);
				// Heshvan has 30 days in complete years.
				if ($year_type === self::COMPLETE_YEAR) {
					$jd++;
				}
				if ($month > self::KISLEV) {
					// Kislev has 30 days in regular and complete years.
					if ($year_type !== self::DEFECTIVE_YEAR) {
						$jd++;
					}
					if ($month > self::SHEVAT) {
						// Shevat has 30 days.
						$jd++;
						if ($month > 6) {
							// Adar I has 30 days, but exists only in leap years.
							if ($this->leapYear($year)) {
								$jd++;
							} else {
								$jd -= 29;
							}
							if ($month > self::NISAN) {
								// Nisan has 30 days.
								$jd++;
								if ($month > self::SIVAN) {
									// Sivan has 30 days.
									$jd++;
									if ($month > self::AV) {
										// Av has 30 days.
										$jd++;
									}
								}
							}
						}
					}
				}
			}
		}

		return $jd + $day - 1;
	}

	/**
	 * Determine whether a year is normal, defective or complete.
	 *
	 * @param $year
	 *
	 * @return int defective (-1), normal (0) or complete (1)
	 */
	private function yearType($year) {
		$year_length = $this->yToJd($year + 1) - $this->yToJd($year);

		if ($year_length === 353 || $year_length === 383) {
			return self::DEFECTIVE_YEAR;
		} elseif ($year_length === 355 || $year_length === 385) {
			return self::COMPLETE_YEAR;
		} else {
			return self::REGULAR_YEAR;
		}
	}

	/**
	 * Calculate the number of days in Heshvan.
	 *
	 * @param int $year
	 *
	 * @return int
	 */
	private function daysInMonthHeshvan($year) {
		if ($this->yearType($year) == self::COMPLETE_YEAR) {
			return 30;
		} else {
			return 29;
		}
	}

	/**
	 * Calculate the number of days in Kislev.
	 *
	 * @param int $year
	 *
	 * @return int
	 */
	private function daysInMonthKislev($year) {
		if ($this->yearType($year) == self::DEFECTIVE_YEAR) {
			return 29;
		} else {
			return 30;
		}
	}

	/**
	 * Calculate the number of days in Adar I.
	 *
	 * @param int $year
	 *
	 * @return int
	 */
	private function daysInMonthAdarI($year) {
		if ($this->leapYear($year)) {
			return 30;
		} else {
			return 0;
		}
	}

	/**
	 * Calculate the number of days in a given month.
	 *
	 * @param  int $year
	 * @param  int $month
	 *
	 * @return int
	 */
	public function daysInMonth($year, $month) {
		if ($year == 0 || $month < 1 || $month > 13) {
			return trigger_error('invalid date.', E_USER_WARNING);
		} elseif ($month == 1 || $month == 5 || $month == 8 || $month == 10 || $month == 12) {
			return 30;
		} elseif ($month == 4 || $month == 7 || $month == 9 || $month == 11 || $month == 13) {
			return 29;
		} elseif ($month == 6) {
			return $this->daysInMonthAdarI($year);
		} elseif ($month == 2) {
			return $this->daysInMonthHeshvan($year);
		} else { // $month == 3
			return $this->daysInMonthKislev($year);
		}
	}

	/**
	 * Month names.
	 *
	 * @link https://bugs.php.net/bug.php?id=54254
	 *
	 * @return string[]
	 */
	public function monthNames() {
		return array(
			1 => 'Tishri', 'Heshvan', 'Kislev', 'Tevet', 'Shevat',
			Shim::emulateBug54254() ? 'AdarI' : 'Adar I',
			Shim::emulateBug54254() ? 'AdarII' : 'Adar II',
			'Nisan', 'Iyyar', 'Sivan', 'Tammuz', 'Av', 'Elul',
		);
	}

	/**
	 * Calculate the name of a month, for a specified Julian Day number.
	 *
	 * @param  $jd
	 *
	 * @return string
	 */
	public function jdMonthName($jd) {
		list($year, $month) = $this->jdToYmd($jd);
		$months = $this->monthNames();

		if (!$this->leapYear($year) && ($month==6 || $month == 7)) {
			return Shim::emulateBug54254() ? 'AdarI' : 'Adar';
		} else {
			return $months[$month];
		}
	}

	/**
	 * Calculate the name of a month, for a specified Julian Day number.
	 *
	 * @param  int $jd
	 *
	 * @return string
	 */
	public function jdMonthNameAbbreviated($jd) {
		return $this->jdMonthName($jd);
	}


	/**
	 * Hebrew month names.
	 *
	 * @link https://bugs.php.net/bug.php?id=54254
	 *
	 * @param int $year
	 *
	 * @return string[]
	 */
	protected function hebrewMonthNames($year) {
		$leap_year = $this->leapYear($year);

		return array(
			1 => 'תשרי', 'חשון', 'כסלו', 'טבת', 'שבט',
			$leap_year ? 'אדר א׳' : '',
			$leap_year ? 'אדר ב׳' : 'אדר',
			'ניסן', 'אייר', 'סיוון', 'תמוז', 'אב', 'אלול',
		);
	}

	/**
	 * The Hebrew name of a given month.
	 *
	 * @param int $year
	 * @param int $month
	 *
	 * @return string
	 */
	protected function hebrewMonthName($year, $month) {
		$months = $this->hebrewMonthNames($year);

		return $months[$month];
	}

	/**
	 * Convert a number into Hebrew numerals.
	 * 
	 * @param int $number
	 * @param bool $alafim_garesh
	 * @param bool $alafim
	 * @param bool $gereshayim
	 *
	 * @return string
	 */
	protected function numToHebrew($number, $alafim_garesh, $alafim, $gereshayim) {
		$hebrew = '';
		while ($number > 0) {
			foreach (self::$HEBREW_NUMERALS_FINAL as $n => $h) {
				if ($number == $n) {
					$hebrew .= $h;
					break 2;
				}
			}
			foreach (self::$HEBREW_NUMERALS as $n => $h) {
				if ($number >= $n) {
					$hebrew .= $h;
					$number -= $n;
				}
			}
		}
		return $hebrew;
	}

	/**
	 * Convert a Julian Day number into a Hebrew date.
	 *
	 * @param int  $jd
	 * @param bool $alafim_garesh
	 * @param bool $alafim
	 * @param bool $gereshayim
	 *
	 * @return string $string
	 */
	public function jdToHebrew($jd, $alafim_garesh, $alafim, $gereshayim) {
		list($year, $month, $day) = $this->jdToYmd($jd);

		return
			$this->numToHebrew($day, $alafim_garesh, $alafim, $gereshayim) . ' ' .
			$this->hebrewMonthName($year, $month) . ' ' .
			$this->numToHebrew($year, $alafim_garesh, $alafim, $gereshayim);
	}
}
