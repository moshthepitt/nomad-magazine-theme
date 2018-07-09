<?php
/**
 * Template Name: Nomad Listings Grid
 *
 * Template file for nomad listings listview.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */
/**
 *    Get Current page object
 **/
if (!is_null($post)) {
    $page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
 *    Get current page id
 **/

if (!is_null($post) && isset($page_obj->ID)) {
    $current_page_id = $page_obj->ID;
}

$grandtour_homepage_style = grandtour_get_homepage_style();

get_header();

$grandtour_page_content_class = grandtour_get_page_content_class();

//Include custom header feature
get_template_part("/templates/template-header");

//Include custom tour search feature
// get_template_part("/templates/template-tour-search");
?>

<!-- Begin content -->
<?php
//Get all listings for paging
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'nomad-listing',
    'post__not_in' => array($post->ID),
    'paged' => $paged,
    'ignore_sticky_posts' => 1,
    'orderby' => 'title',
);
$wp_query = new WP_Query($args);
$current_photo_count = $wp_query->post_count;
$all_photo_count = $wp_query->found_posts;
$i_post = 4;
?>

<div class="inner">

	<div class="inner_wrapper nopadding">

<?php
if (!empty($post->post_content) && empty($term)) {
    ?>
	    <div class="standard_wrapper"><?php echo grandtour_apply_content($post->post_content); ?></div><br class="clear"/><br/>
<?php
}
?>

	<div id="page_main_content" class="sidebar_content full_width fixed_column">

	<div class="standard_wrapper">

	<div id="portfolio_filter_wrapper" class="gallery grid four_cols portfolio-content section content clearfix" data-columns="4">

<?php while ($wp_query->have_posts()): ?>
    <?php $wp_query->the_post();?>
        <?php get_template_part("/templates/template-nomad-listing-grid-item");?>
				<?php
    $i_post++;
endwhile;
wp_reset_postdata();
?>

	</div>
	<br class="clear"/>
<?php
if ($wp_query->max_num_pages > 1) {
    if (function_exists("grandtour_pagination")) {
            grandtour_pagination($wp_query->max_num_pages);
    } else {
        ?>
	    	    <div class="pagination"><p><?php posts_nav_link(' ');?></p></div>
<?php
    }
    ?>
	    <div class="pagination_detail">
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    ?>
<?php esc_html_e('Page', 'grandtour');?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'grandtour');?> <?php echo esc_html($wp_query->max_num_pages); ?>
	     </div>
<?php
}
?>

	</div>
	</div>

</div>
</div>
</div>
<?php get_footer();?>
<!-- End content -->