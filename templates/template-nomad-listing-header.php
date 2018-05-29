<?php
/**
 * Single Listing Header Template
 *
 * Header template file for single nomad listings.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */
$page = get_page($post->ID);
if (!isset($current_page_id) && isset($page->ID)) {
    $current_page_id = $page->ID;
}
//Get page header display setting
$page_title = get_the_title();

$featured_image_url = '';
if (has_post_thumbnail($post->ID)) {
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
    $featured_image_url = $featured_image[0];
}

// get custom fields
$prefix = 'nomad_';

$price = rwmb_meta($prefix . 'price');
$discount_price = rwmb_meta($prefix . 'discount_price');
?>
	<div id="page_caption" class="hasbg parallax" style="background-image:url(<?php echo $featured_image_url; ?>)">
		<div class="single_tour_header_content">
			<div class="standard_wrapper">
				<?php if (($price && $price > 0) || ($discount_price && $discount_price > 0)) : ?>
				<div class="single_tour_header_price nomad-pricing">
				<?php if ($discount_price && $discount_price > 0) : ?>
					<span class="nomad-pricing-sm">Special Offer</span>
								<?php echo number_format($discount_price, 0, '', ','); ?>
				<?php else : ?>
								<?php echo number_format($price, 0, '', ','); ?>
				<?php endif ?>
				</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<!-- Begin content -->
<?php
$grandtour_page_content_class = grandtour_get_page_content_class();
?>
	<div id="page_content_wrapper" class="hasbg">