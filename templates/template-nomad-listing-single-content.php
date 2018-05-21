<?php
/**
 * Single Listing Template
 *
 * Template file for single nomad listings.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE Apache 2.0
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */

$nomad_single_review = 1;
$tax_base = 'nomad-';

// locations
$locations = get_the_terms($post->ID, $tax_base . 'listing-item-location');
$locations_list = null;
if (is_array($locations)) {
    $locations_list = implode(
        ', ', array_map(
            function ($item) {
                return $item->name;
            }, $locations
        )
    );
}


// get custom fields
$prefix = 'nomad_';

$email = rwmb_meta($prefix . 'email');
$website = rwmb_meta($prefix . 'website');
$phone_list = rwmb_meta($prefix. 'phone_number');
if (is_array($phone_list)) {
    $phone_numbers = implode(
        ', ', array_map(
            function ($item) {
                return $item[0];
            }, $phone_list
        )
    );
} else {
    $phone_numbers = null;
}
?>
<div class="sidebar_wrapper">
    <div class="sidebar_top"></div>
    <div class="sidebar">
        <div class="content">
            <div class="single_tour_header_price">
                <div class="single_tour_price">
                    <span class="normal_price">
                        $2,000 </span>
                    $1,500 </div>
                <div class="single_tour_per_person">
                    Per Person </div>
            </div>
            <div class="single_tour_booking_wrapper themeborder external">
                <div class="single_tour_booking_external_wrapper">
                    Some text goes here
                    <a href="http://example.com" class="button" target="_blank">
                        Book This Tour
                    </a>
                </div>
            </div>

            <?php if (is_active_sidebar('single-nomad-listings-sidebar')) : ?>
                <br/>
                <ul class="sidebar_widget">
                    <?php dynamic_sidebar('single-nomad-listings-sidebar');?>
                </ul>
            <?php endif;?>
        </div>
    </div>
    <br class="clear" />
    <div class="sidebar_bottom"></div>
</div>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <div class="sidebar_content ">
            <h1><?php the_title(); ?></h1>
            <br class="clear" />
            <div class="single_tour_content">
                <?php the_content(); ?>
            </div>

            <br class="clear" />
            <hr>
            <br class="clear" />

            <h3>Contact Information</h3>

            <div style="margin:auto;width:100%">
                <div class="one_third">
                    <?php if($locations_list) : ?>
                        <p><strong>Location</strong><br/><?php echo $locations_list; ?></p>
                    <?php endif ?>
                    <?php if ($phone_numbers) : ?>
                        <p><strong>Phone</strong><br/><?php echo $phone_numbers; ?></p>
                    <?php endif ?>
                </div>
                <div class="one_third">
                    <?php if ($email) : ?>
                        <p><strong>Email</strong><br/><?php echo $email; ?></p>
                    <?php endif ?>
                    <?php if ($website) : ?>
                        <p><strong>Website</strong><br/><?php echo $website; ?></p>
                    <?php endif ?>
                </div>
                <div class="one_third">

                </div>
            </div>

            <?php
            //Display listing comments
            if (comments_open($post->ID) && !empty($nomad_single_review)) {
            ?>
                <div class="fullwidth_comment_wrapper sidebar">
                    <?php comments_template('', true); ?>
                </div>
            <?php
            }
            ?>
        </div>
    <?php endwhile;?>
<?php endif;?>