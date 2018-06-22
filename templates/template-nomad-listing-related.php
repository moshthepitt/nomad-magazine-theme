<?php
/**
 * Related Listings Template
 *
 * Template file for related nomad listings.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */
$tax_base = 'nomad-';
$items = 3;
$cats = wp_get_object_terms(
    $post->ID,
    $tax_base . 'listing-item-category',
    array('fields' => 'ids')
);

if ($cats) {
    $cat_ids = implode(',', $cats);
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => $tax_base . 'listing-item-category',
                'field' => 'id',
                'terms' => $cat_ids
            )
        ),
        'post_type' => 'nomad-listing',
        'post__not_in' => array($post->ID),
        'showposts' => $items,
        'ignore_sticky_posts' => 1,
        'orderby' => 'rand'
    );
    $i_post = 3;
    $my_query = new WP_Query($args);
?>
    <?php if($my_query->have_posts()) : ?>
        <br class="clear"/>
        <div class="tour_related nomad-related">
        <br class="clear" />
            <h3 class="sub_title">Similar Listings</h3>
            <?php if (have_posts()) : ?>
                <div id="portfolio_filter_wrapper" class="gallery classic three_cols portfolio-content section content clearfix" data-columns="3">
                <?php while ($my_query->have_posts()) : ?>
                    <?php $my_query->the_post(); ?>
                    <?php get_template_part("/templates/template-nomad-listing-grid-item"); ?>
                <?php
                    $i_post++;
                endwhile;
                wp_reset_postdata();
                ?>
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
<?php } ?>