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

$left = (!right_to_left());  // To know if to add 'pull-right' and 'desktop-first-column' classes in the layout for LTR.
$hasabovemain = $PAGE->blocks->region_has_content('above-main', $OUTPUT);
$hasbelowmain = $PAGE->blocks->region_has_content('below-main', $OUTPUT);

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
   <link href="https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php echo $OUTPUT->body_attributes('two-column'); ?>>

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


<div id="page">

    <header id="page-header" class="clearfix">
<div class="topmast fullWidth">
<div class="container-fluid">
<div class="row">
<div class="span8">
<?php echo $html->heading; ?>
</div>
<div class="span4 pull-right hidden-phone">

<form action="/course/search.php" method="get" class="inline" id="coursesearch1">
<fieldset class="coursesearchbox invisiblefieldset">
<div class="input-group custom-search-form input-append">
              <input type="text" name="search" class="form-control" value="Search courses..." onblur="if (this.value=='') this.value='Search courses...';" onfocus="if (this.value=='Search courses...') this.value='';">
              <button class="btn btn-inverse" type="submit">
              <i class="fa fa-search"></i>
             </button>
             <input type="hidden" name="task" value="search">
             </div>
</fieldset>
</form>


</div>
</div>
</div>
</div>
</header>

<!-- top nav -->
<div class="navbar fullWidth" id="topmainnav">
<div class="container-fluid">
  <div class="navbar-inner">
   
 
      <a class="btn btn-navbar" data-toggle="collapse" data-target="#second">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div id="second" class="nav-collapse">
         <?php echo $OUTPUT->custom_menu(); ?>
      </div>
 

  </div>
</div>
</div>
     
  
<!--// end top nav -->
<div class="under-feature fullWidth"></div>

<div class="container-fluid">
<div id="page-navbar" class="clearfix breadcrumb">
		<nav class="breadcrumb-nav"><?php echo $OUTPUT->navbar(); ?></nav>
		<div class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></div>
</div>
</div>

    <div class="container-fluid">
    <div id="page-content" class="row-fluid">
        <section id="region-main" class="span9<?php if ($left) { echo ' pull-left'; } ?>">
		<?php if ($hasabovemain) { ?>
		<?php echo $OUTPUT->blocks_for_region('above-main') ?>
              <hr>
		<?php } ?>

            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>
	<?php if ($hasbelowmain) { ?>
               <hr>
		 <?php echo $OUTPUT->blocks_for_region('below-main') ?>
		<?php } ?>
        </section>
        <?php
        $classextra = '';
        if ($left) {
            $classextra = ' float-right';
        }
        echo $OUTPUT->blocks('side-post', 'span3'.$classextra);
        ?>
    </div>
    </div>
    <footer id="page-footer" class="fullWidth">
	<div id="basePosition" class="text-center">
        <?php echo $OUTPUT->course_footer(); ?>
        <p class="helplink text-center"><?php echo $OUTPUT->page_doc_link(); ?></p>
        <?php
        echo $OUTPUT->login_info();
        //echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
	</div>
<div class="row-fluid footer-block">

<div class="row-fluid">
<div class="span2 link-wagov"><a href="http://www.wa.gov.au" title="Go to WA Government Online Entry Point">wa.gov.au</a></div>
<div class="span10"><?php echo $html->footnote; ?></div>

</div>
</footer>


    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</div>
</body>
</html>
