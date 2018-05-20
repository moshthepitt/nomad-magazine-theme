<?php
/**
 * Template file for displaying a single Nomad listing.
 *
 * @package WordPress
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
<br class="clear"/>
</div>
<?php
// theme footer
get_footer();
?>