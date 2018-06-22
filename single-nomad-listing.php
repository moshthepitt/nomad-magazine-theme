<?php
/**
 * Single Listing Template
 *
 * Template file for single nomad listings.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */
?>
<?php
// theme footer
get_header();
get_template_part("/templates/template-nomad-listing-header");
?>
    <div class="inner">
        <!-- Begin main content -->
        <div class="inner_wrapper">
            <?php
                // Include listing content
                get_template_part("/templates/template-nomad-listing-single-content");
            ?>
        </div>
        <!-- End main content -->
    </div>
    <?php get_template_part("/templates/template-nomad-listing-related"); ?>
<br class="clear"/>
</div>
<?php
// theme footer
get_footer();
?>