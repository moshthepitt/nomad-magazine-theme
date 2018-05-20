<?php
/**
 *    Nomad Listing header
 **/
$page = get_page($post->ID);
if (!isset($current_page_id) && isset($page->ID)) {
    $current_page_id = $page->ID;
}
//Get page header display setting
$page_title = get_the_title();

if (has_post_thumbnail($post->ID)) {
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
}
?>
	<div id="page_caption" class="hasbg parallax" style="background-image:url(<?php if (isset($featured_image)) { echo $featured_image[0]; } ?>)">
		<div class="single_tour_header_content">
			<div class="standard_wrapper">
				<div class="single_tour_header_price">
					<div class="single_tour_price">
						<span class="normal_price">$2,000</span>$1,500
					</div>
					<div class="single_tour_per_person">Per Person</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Begin content -->
	<?php
$grandtour_page_content_class = grandtour_get_page_content_class();
?>
	<div id="page_content_wrapper" class="hasbg">