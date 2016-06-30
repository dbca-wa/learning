<?php

// This file is part of Moodle - http://moodle.org/
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
 * This file is used to setting the block allover the site
 *
 * @package    block
 * @subpackage graph_stats
 * @copyright  2011 Éric Bugnet with help of Jean Fruitet
 * @copyright  2014 Wesley Ellis, Code Improvements.
 * @copyright  2014 Vadim Dvorovenko
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");

$today = usergetmidnight(time());

$url = new moodle_url('/block/graph_stats/details.php');

$courseid = optional_param('course_id', 1, PARAM_INT);
require_course_login($courseid);

$context = context_course::instance($courseid);
$PAGE->set_pagelayout('standard');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title(get_string('connectedtodaytitle', 'block_graph_stats'));
$PAGE->set_heading($COURSE->fullname);

echo $OUTPUT->header();

if (has_capability('report/log:view', $context)) {
    echo html_writer::start_tag('h2', array('class' => 'main'));
    echo get_string('connectedtodaytitle', 'block_graph_stats');
    echo html_writer::end_tag('h2');
    if ($COURSE->id > 1) {
        $id = $COURSE->id;
    } else {
        $id = 0;
    }
    echo html_writer::link(
            new moodle_url('/report/log/index.php', array('chooselog' => 1, 'showusers' => 1, 'showcourses' => 1, 'id' => $id, 'date' => $today, 'edulevel' => -1, 'logreader' => 'logstore_standard')), 
            get_string('moredetails', 'block_graph_stats'));

    list($sort, $sortparams) = users_order_by_sql('u');
    if ($COURSE->id > 1) {
        $query = "
            SELECT DISTINCT
                u.id, " . get_all_user_name_fields(true, 'u') . "
            FROM
                {logstore_standard_log} l, {user} u
            WHERE
                l.userid = u.id AND
                l.timecreated >= :time AND
                l.eventname = :eventname AND
                l.courseid = :course
            ORDER BY
                " . $sort;
        $params = array(
            'time' => $today, 
            'eventname' => '\core\event\course_viewed',
            'course' => $COURSE->id);
    } else {
        $query = "
            SELECT DISTINCT
                u.id, " . get_all_user_name_fields(true, 'u') . "
            FROM
                {logstore_standard_log} l, {user} u
            WHERE
                l.userid = u.id AND
                l.timecreated >= :time AND
                l.eventname = :eventname
            ORDER BY
                " . $sort;
        $params = array(
            'time' => $today, 
            'eventname' => '\core\event\user_loggedin');
    }

    echo html_writer::start_tag('ul');
    $users = $DB->get_records_sql($query, $params);
    foreach ($users as $user) {
        echo html_writer::start_tag('li');
        echo fullname($user);
        echo html_writer::end_tag('li');
    }
    echo html_writer::end_tag('ul');
    
}
echo $OUTPUT->footer();