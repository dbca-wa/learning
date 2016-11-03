<?php
// This file is part of the Fullscreen local plugin for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Steps definitions related to the Fullscreen local plugin.
 *
 * @package   local_fullscreen
 * @copyright 2015 onwards, University of Nottingham
 * @author    Barry Oosthuizen <barry.oosthuizen@nottingham.ac.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given;

/**
 * Fullscreen local plugin related steps definitions.
 *
 * @package    local_fullscreen
 * @copyright  2015 onwards, University of Nottingham
 * @author     Barry Oosthuizen<barr.oosthuizen@nottingham.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_local_fullscreen extends behat_base {

    /**
     * Step definition which enables the use of the Clean theme
     * @Given /^I use the clean theme$/
     */
    public function i_use_the_clean_theme() {
        set_config('theme', 'clean');
    }

}
