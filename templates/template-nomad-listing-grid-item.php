<?php
/**
 * Single Listings Grid Item Template
 *
 * Template file for a single nomad listings grid item.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */
$tax_base = 'nomad-';
$separator = ', ';
$prefix = 'nomad_';

$small_image_url = null;
$listing_id = get_the_ID();
if (has_post_thumbnail($listing_id, 'grandtour-gallery-grid')) {
    $image_id = get_post_thumbnail_id($listing_id);
    $small_image_url = wp_get_attachment_image_src(
        $image_id, array(380, 253), true
    );
}
$permalink_url = get_permalink($listing_id);

$locations = get_the_terms($post->ID, $tax_base . 'listing-item-location');
$locations_list = null;
if (is_array($locations)) {
    $locations_list = implode(
        $separator, array_map(
            function ($item) {
                return $item->name;
            }, $locations
        )
    );

    $location_terms = wp_get_object_terms(
        $post->ID,
        $tax_base . 'listing-item-location',
        array('fields' => 'ids')
    );
    $location_ids = implode(',', $location_terms);
    // locations tree
    $location_tree = nomadGetHierarchicalTerms(
        $term_name = $tax_base . 'listing-item-location',
        $term_ids = $location_ids,
        $separator = $separator
    );
} else {
    $location_tree = null;
}

$price = rwmb_meta($prefix . 'price');
$discount_price = rwmb_meta($prefix . 'discount_price');
?>
<div class="element grid classic3_cols nomad-listings-grid">
    <div class="one_third gallery3 classic static filterable portfolio_type themeborder" data-id="post-168">
        <?php if(!empty($small_image_url[0])) : ?>
        <a class="tour_image" href="<?php echo $permalink_url; ?>">
            <img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php the_title(); ?>">
            <?php if($price || $discount_price) : ?>
            <div class="tour_price has_discount">
                <span class="normal_price"><?php echo $price ?></span>
                <?php echo $discount_price ?>
            </div>
            <?php endif ?>
        </a>
        <?php endif ?>
        <div class="portfolio_info_wrapper">
            <a class="tour_link" href="<?php echo $permalink_url; ?>">
                <h4><?php the_title(); ?></h4>
            </a>
            <div class="tour_excerpt">
                <?php if ($locations_list) : ?>
                    <p class="nomad-location-tree"><?php echo $location_tree ?></p>
                <?php endif?>
            </div>
        </div>
    </div>
</div>
