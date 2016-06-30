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

defined('MOODLE_INTERNAL') || die;

function block_graph_stats_graph_google($courseid) {
    global $DB, $COURSE;
    
    $cfg = get_config('block_graph_stats');
    
    // Number of day for the graph.
    if (isset($cfg->daysnb)) {
        $daysnb = $cfg->daysnb;
    } else {
        $daysnb = 30;
    }

    // Define type.
    if ($cfg->style == 'area') {
        $type1 = 'area';
        $type2 = 'area';
    } else {
        $type1 = 'bars';
        $type2 = 'line';
    }

    $days = array();
    $visits1 = array();
    $visits2 = array();

    $cache = cache::make('block_graph_stats', 'visits');
 
    // Let's get the datas.
    $a = 0;
    if ($courseid > 1) {
        for ($i = $daysnb; $i > -1; $i--) { // Days count.
            $time1 = usergetmidnight(time() - $i * 60 * 60 *24);
            $time2 = usergetmidnight(time() - ($i - 1) * 60 * 60 *24);
            $visits1[$a] = $cache->get('visits1_' . $courseid . '_' . $time1);
            if ($visits1[$a] === false) {
                $sql = "SELECT COUNT(DISTINCT(userid)) as countid 
                        FROM {logstore_standard_log}
                        WHERE timecreated >= :time1 AND timecreated < :time2 AND eventname = :eventname  AND courseid = :course";
                $params = array(
                    'time1' => $time1, 
                    'time2' => $time2, 
                    'eventname' => '\core\event\course_viewed', 
                    'course' => $COURSE->id);
                $visits1[$a] = $DB->get_field_sql($sql, $params);
                if ($i > 0) {
                    $cache->set('visits1_' . $courseid . '_' . $time1, $visits1[$a]);
                }
            }
            $days[$a] = userdate($time1, get_string('strftimedaydate', 'core_langconfig'));
            $a = $a + 1;
        }
    } else {
        for ($i = $daysnb; $i > -1; $i--) { // Days count.
            $time1 = usergetmidnight(time() - $i * 60 * 60 *24);
            $time2 = usergetmidnight(time() - ($i - 1) * 60 * 60 *24);
            $visits2[$a] = $cache->get('visits2_' . $courseid . '_' . $time1);
            if ($visits2[$a] === false) {
                $sql = "SELECT COUNT(DISTINCT(userid)) as countid 
                        FROM {logstore_standard_log}
                        WHERE timecreated >= :time1 AND timecreated < :time2 AND eventname = :eventname";
                $params = array(
                    'time1' => $time1, 
                    'time2' => $time2, 
                    'eventname' => '\core\event\user_loggedin');
                $visits2[$a] = $DB->get_field_sql($sql, $params);
                if ($i > 0) { // do not cache today, because visits count can change
                    $cache->set('visits2_' . $courseid . '_' . $time1, $visits2[$a]);
                }
            }

            if ($cfg->multi == 1) {
                $visits1[$a] = $cache->get('visits1_' . $courseid . '_' . $time1);
                if ($visits1[$a] === false) {
                    $sql = "SELECT COUNT(userid) as countid 
                            FROM {logstore_standard_log}
                            WHERE timecreated >= :time1 AND timecreated < :time2 AND eventname = :eventname";
                    $params = array(
                        'time1' => $time1, 
                        'time2' => $time2, 
                        'eventname' => '\core\event\user_loggedin');
                    $visits1[$a] = $DB->get_field_sql($sql, $params);
                    if ($i > 0) { // do not cache today, because visits count can change
                        $cache->set('visits1_' . $courseid . '_' . $time1, $visits1[$a]);
                    }
                }
            } else {
                $visits1[$a] = '';
            }
            
            $days[$a] = userdate($time1, get_string('strftimedaydate', 'core_langconfig'));
            $a = $a + 1;
        }
    }

    $graph = '
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Day");';
    if ($courseid > 1) {
        $graph .= 'data.addColumn("number", "'. get_string('visitors', 'block_graph_stats') . '");';
    } else {
        $graph .= 'data.addColumn("number", "'. get_string('visitors', 'block_graph_stats') . '");';
        $graph .= 'data.addColumn("number", "'. get_string('uniquevisitors', 'block_graph_stats') . '");';
    }

    $graph .= 'data.addRows([ ';
    $a = 0;
    for ($i = $daysnb; $i > -1; $i--) {
        if ($courseid > 1) {
            $graph .= '["' . $days[$a] . '",' . $visits1[$a] . '],';
        } else {
            $graph .= '["' . $days[$a] . '",' . $visits1[$a] . ',' . $visits2[$a] . '],';
        }
        $a++;
    }
    $graph .= ' ]);';
    
    $graph .= '
        var options = {
            legend: {position: "none"},
            backgroundColor: {
                fill: "' . $cfg->outer_background . '",
                stroke: "' . $cfg->inner_border . '",
                strokeWidth: "' . $cfg->border_width . '"
            },
            hAxis: {
                textPosition: "none"
            },
            vAxis: {
                gridlines: {
                    color: "' . $cfg->axis_colour . '"
                }
            },
            series: {
                0: {
                    color: "' . $cfg->color1 . '", 
                    type: "'. $type1. '"
                },
                1: {
                    color: "' . $cfg->color2 .'", 
                    type: "' . $type2 . '"
                }
            }
        };';

    $graph .= '
            var chart = new google.visualization.AreaChart(document.getElementById("chart_div"));
            chart.draw(data, options);
        }

        $(document).ready(function(){
            $(window).resize(function(){
                drawChart();
            });
        });
        </script>
        <div id="chart_div" style="width:100%; height:' . $cfg->graphheight .'"></div>';

    return $graph;
}