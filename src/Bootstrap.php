<?php
namespace Fisharebest\ExtCalendar;

/**
 * class Bootstrap - create global functions to emulate the calendar extension in PHP.
 *
 * Some PHP installations do not include the ext-calendar extension, which provides
 * functions for working with, and converting between, various calendars such as
 * Gregorian, Julian and Jewish.
 *
 * If you are writing applications that may be installed on such a system,
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
class Bootstrap {
	public static function init() {
		if (!extension_loaded('calendar')
		defined('CAL_GREGORIAN') || define('CAL_GREGORIAN', 0);
		defined('CAL_JULIAN') || define('CAL_JULIAN', 1);
		defined('CAL_JEWISH') || define('CAL_JEWISH', 2);
		defined('CAL_FRENCH') || define('CAL_FRENCH', 3);
		defined('CAL_NUM_CALS') || define('CAL_NUM_CALS', 4);
		defined('CAL_DOW_DAYNO') || define('CAL_DOW_DAYNO', 0);
		defined('CAL_DOW_SHORT') || define('CAL_DOW_SHORT', 1);
		defined('CAL_DOW_LONG') || define('CAL_DOW_LONG', 2);
		defined('CAL_MONTH_GREGORIAN_SHORT') || define('CAL_MONTH_GREGORIAN_SHORT', 0);
		defined('CAL_MONTH_GREGORIAN_LONG') || define('CAL_MONTH_GREGORIAN_LONG', 1);
		defined('CAL_MONTH_JULIAN_SHORT') || define('CAL_MONTH_JULIAN_SHORT', 2);
		defined('CAL_MONTH_JULIAN_LONG') || define('CAL_MONTH_JULIAN_LONG', 3);
		defined('CAL_MONTH_JEWISH') || define('CAL_MONTH_JEWISH', 4);
		defined('CAL_MONTH_FRENCH') || define('CAL_MONTH_FRENCH', 5);
		defined('CAL_EASTER_DEFAULT') || define('CAL_EASTER_DEFAULT', 0);
		defined('CAL_EASTER_ROMAN') || define('CAL_EASTER_ROMAN', 1);
		defined('CAL_EASTER_ALWAYS_GREGORIAN') || define('CAL_EASTER_ALWAYS_GREGORIAN', 2);
		defined('CAL_EASTER_ALWAYS_JULIAN') || define('CAL_EASTER_ALWAYS_JULIAN', 3);
		defined('CAL_JEWISH_ADD_ALAFIM_GERESH') || define('CAL_JEWISH_ADD_ALAFIM_GERESH', 2);
		defined('CAL_JEWISH_ADD_ALAFIM') || define('CAL_JEWISH_ADD_ALAFIM', 4);
		defined('CAL_JEWISH_ADD_GERESHAYIM') || define('1 CAL_JEWISH_ADD_GERESHAYIM ', 8);
	}
}
