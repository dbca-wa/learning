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

// Get the HTML for the settings bits.
$html = theme_parksboot2_get_html_for_settings($OUTPUT, $PAGE);
$hasabovemain = $PAGE->blocks->region_has_content('above-main', $OUTPUT);
$hasbelowmain = $PAGE->blocks->region_has_content('below-main', $OUTPUT);
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div role="banner" class="navbar navbar-fixed-top<?php echo $html->navbarclass ?> moodle-has-zindex">
    <div class="navbar-inner">
    
            	<ul class="nav related-nav pull-left">
          	<li><a class="related-nav-item" href="http://www.dpaw.wa.gov.au" title="Visit the main Parks and Wildlife website" >DPaW</a></li>
          	<li class="active"><a class="related-nav-item" href="<?php echo $CFG->wwwroot;?>"><?php echo $SITE->shortname; ?></a></li>
        	</ul>
         
                            <?php //echo $OUTPUT->custom_menu(); ?>
                <ul class="nav pull-right">
                    <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                    <li class="navbar-text"><?php echo $OUTPUT->login_info() ?></li>
                </ul>
          
  
    </div>
</div>


<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
        <?php echo $html->heading; ?>
    </header>

    <div id="page-content" class="row-fluid">
        <div id="region-bs-main-and-pre" class="span9">
            <div class="row-fluid">
                <section id="region-main" class="span8 pull-right">


		<?php if ($hasabovemain) { ?>
		<?php echo $OUTPUT->blocks_for_region('above-main') ?>
		<hr>
		<?php } ?>

            <?php
            echo $OUTPUT->main_content();
            ?>
		<?php if ($hasbelowmain) { ?>
		<hr>
		<?php echo $OUTPUT->blocks_for_region('below-main') ?>
		<?php } ?>

                </section>
                <?php echo $OUTPUT->blocks('side-pre', 'span4 desktop-first-column'); ?>
            </div>
        </div>
        <?php echo $OUTPUT->blocks('side-post', 'span3'); ?>
    </div>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>