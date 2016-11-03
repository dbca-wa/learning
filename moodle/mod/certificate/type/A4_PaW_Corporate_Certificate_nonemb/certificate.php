<?php

// This file is part of the Certificate module for Moodle - http://moodle.org/
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
 * A4_non_embedded certificate type
 *
 * @package    mod
 * @subpackage certificate
 * @copyright  Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from view.php
}

$pdf = new PDF($certificate->orientation, 'mm', 'A4', true, 'UTF-8', false);

//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
$pdf->SetDisplayMode('real');
//display pictures in original dimensions, with no blur.
$pdf->setImageScale(1.53);
$pdf->setJPEGQuality(100);
$pdf->SetTitle($certificate->name);
$pdf->SetProtection(array('modify'));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false, 0);
$pdf->AddPage();




// Define variables
// Landscape
if ($certificate->orientation == 'L') {
    $x = 10;
    $y = 30;
    $sealx = 40;
    $sealy = 160;
    $sigx = 162;
    $sigy = 161;
    $custx = 160;
    $custy = 155;
    $wmarkx = 40;
    $wmarky = 31;
    $wmarkw = 212;
    $wmarkh = 148;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 297;
    $brdrh = 210;
    $codey = 175;
} else { // Portrait
    $x = 10;
    $y = 40;
    $sealx = 150;
    $sealy = 220;
    $sigx = 30;
    $sigy = 240;
    $custx = 30;
    $custy = 256;
    $wmarkx = 26;
    $wmarky = 58;
    $wmarkw = 158;
    $wmarkh = 170;
    $brdrx = 0;
    $brdry = 0;
    $brdrw = 210;
    $brdrh = 297;
    $codey = 280;
}

// Add images and lines
certificate_print_image($pdf, $certificate, CERT_IMAGE_BORDER, $brdrx, $brdry, $brdrw, $brdrh);
certificate_draw_frame($pdf, $certificate);
// Set alpha to semi-transparency
$pdf->SetAlpha(0.2);
certificate_print_image($pdf, $certificate, CERT_IMAGE_WATERMARK, $wmarkx, $wmarky, $wmarkw, $wmarkh);
$pdf->SetAlpha(1);
certificate_print_image($pdf, $certificate, CERT_IMAGE_SEAL, $sealx, $sealy, '', '');
certificate_print_image($pdf, $certificate, CERT_IMAGE_SIGNATURE, $sigx, $sigy, '', '');

// Add text
//$pdf->SetTextColor(0, 81, 137); // set to blue
//certificate_print_text($pdf, $x, $y + 10, 'C', 'Helvetica', '', 24, get_string('erpatttitle', 'certificate'));
$pdf->SetTextColor(0, 0, 0); // set text to black
certificate_print_text($pdf, $x, $y + 28, 'C', 'Helvetica', '', 14, get_string('erpcertify', 'certificate'));
certificate_print_text($pdf, $x, $y + 54, 'C', 'loversquarrel', '', 50, fullname($USER));
certificate_print_text($pdf, $x, $y + 93, 'C', 'Helvetica', '', 14, get_string('erpstatement', 'certificate'));
certificate_print_text($pdf, $x, $y + 116, 'C', 'Helvetica', '', 20, $course->fullname);
certificate_print_text($pdf, $x, $y + 146, 'C', 'Helvetica', '', 14, certificate_get_date($certificate, $certrecord, $course));
certificate_print_text($pdf, $x, $y + 160, 'C', 'Helvetica', '', 10, certificate_get_grade($certificate, $course));
certificate_print_text($pdf, $x, $y + 170, 'C', 'Helvetica', '', 10, certificate_get_outcome($certificate, $course));
/*
if ($USER->profile['Tradingname']) {
certificate_print_text($pdf, $x + 20, $y + 183, 'L', 'Helvetica', '', 12, $USER->profile['Tradingname']);
}
*/
if ($certificate->printhours) {
    certificate_print_text($pdf, $x, $y + 122, 'C', 'Times', '', 10, get_string('credithours', 'certificate') . ': ' . $certificate->printhours);
}
$pdf->SetTextColor(200, 200, 200); // set text to light grey
certificate_print_text($pdf, $x, $codey, 'C', 'Helvetica', '', 8, certificate_get_code($certificate, $certrecord));
$i = 0;
if ($certificate->printteacher) {
    $context = context_module::instance($cm->id);
    if ($teachers = get_users_by_capability($context, 'mod/certificate:printteacher', '', $sort = 'u.lastname ASC', '', '', '', '', false)) {
        foreach ($teachers as $teacher) {
            $i++;
            certificate_print_text($pdf, $sigx, $sigy + ($i * 4), 'L', 'Times', '', 12, fullname($teacher));
        }
    }
}
$pdf->SetTextColor(0, 0, 0); // set text to black
certificate_print_text($pdf, $custx, $custy, 'L', null, null, null, $certificate->customtext);
?>