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

?>
	<div id="page_caption" class="hasbg parallax" style="background-image:url(http://vccw.test/wp-content/uploads/2018/05/bf1202aedf2c5b6a57d379575619a488.jpg);">
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