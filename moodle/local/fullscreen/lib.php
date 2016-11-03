<?php
// This file is part of the local fullscreen plugin for Moodle
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
 * File containing code that requires the javascript for the fullscreen toggle button
 *
 * @package    local_fullscreen
 * @copyright  2014 onwards - University of Nottingham <www.nottingham.ac.uk>
 * @author     Barry Oosthuizen <barry.oosthuizen@nottingham.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $PAGE;
if (CLI_SCRIPT || AJAX_SCRIPT
        || $PAGE->pagelayout === 'login'
        || $PAGE->pagelayout === 'mydashboard'
        || $PAGE->pagelayout === 'embedded'
        || $PAGE->pagelayout === 'popup'
        || $PAGE->pagelayout === 'base'
        || $PAGE->pagelayout === 'redirect'
        || $PAGE->pagelayout === 'frametop') {
    return;
}
$fullscreen = get_user_preferences('fullscreenmode', false);
$PAGE->requires->yui_module('moodle-local_fullscreen-fullscreen', 'M.local_fullscreen.init_fullscreen',
        array(array('fullscreenmode' => $fullscreen)), null, true);
$PAGE->requires->string_for_js('togglefullscreenmode', 'local_fullscreen');
user_preference_allow_ajax_update('fullscreenmode', PARAM_BOOL);
