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

$nomad_single_review = 1;
$tax_base = 'nomad-';
$separator = ', ';

// categories
$category_tree = nomadGetHierarchicalTerms($tax_base . 'listing-item-category', $separator);

// locations
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
}

// locations tree
$location_tree = nomadGetHierarchicalTerms($tax_base . 'listing-item-location', $separator);

// featutes
$features = get_the_terms($post->ID, $tax_base . 'listing-item-feature');
if ($features) {
    $features = nomadSortArrayWithObjects($features, 'name');
}

// amenities
$amenities = get_the_terms($post->ID, $tax_base . 'listing-item-amenity');
if ($amenities) {
    $amenities = nomadSortArrayWithObjects($amenities, 'name');
}

// get custom fields
$prefix = 'nomad_';

$email = rwmb_meta($prefix . 'email');
$website = rwmb_meta($prefix . 'website');
$phone_list = rwmb_meta($prefix . 'phone_number');
if (is_array($phone_list)) {
    $phone_numbers = implode(
        $separator, array_map(
            function ($item) {
                return $item[0];
            }, $phone_list
        )
    );
} else {
    $phone_numbers = null;
}

$facebook = rwmb_meta($prefix . 'facebook');
$twitter = rwmb_meta($prefix . 'twitter');
$instagram = rwmb_meta($prefix . 'instagram');
$linkedin = rwmb_meta($prefix . 'linkedin');
$display_social = $facebook || $twitter || $instagram || $linkedin;

$number_of_rooms = rwmb_meta($prefix . 'number_of_rooms');
$checkin_time = rwmb_meta($prefix . 'checkin_time');
$checkout_time = rwmb_meta($prefix . 'checkout_time');
$pricing = rwmb_meta($prefix . 'pricing');

$video = rwmb_meta($prefix . 'video');

$awards = rwmb_meta($prefix . 'awards');
$event_offers = rwmb_meta($prefix . 'events_offers');
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
        <?php the_post();?>
        <div class="sidebar_content ">
            <h1><?php the_title();?></h1>
            <p class="nomad-tax-below-title">
                <?php echo $category_tree ?>
            </p>

            <div class="single_tour_content">
                <?php the_content();?>
            </div>

            <br class="clear" />
            <hr>
            <br class="clear" />

            <h3>Contact & Info</h3>

            <div class="nomad-contact-info" style="margin:auto;width:100%">
                <div class="one_half">
                    <?php if ($locations_list) : ?>
                        <p class="nomad-location-tree"><strong>Location</strong><br/><?php echo $location_tree ?></p>
                    <?php endif?>
                    <?php if ($phone_numbers) : ?>
                        <p><strong>Phone</strong><br/><?php echo $phone_numbers; ?></p>
                    <?php endif?>
                    <?php if ($email) : ?>
                        <p><strong>Email</strong><br/><?php echo $email; ?></p>
                    <?php endif?>
                    <?php if ($website) : ?>
                        <p><strong>Website</strong><br/><?php echo $website; ?></p>
                    <?php endif?>
                    <?php if ($display_social) : ?>
                    <p><strong>Social Profiles</strong>
                    <div class="social_wrapper shortcode light small">
                        <ul>
                            <?php if ($facebook) : ?>
                            <li class="facebook">
                                <a target="_blank" title="Facebook" href="<?php echo $facebook; ?>">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <?php endif?>
                            <?php if ($twitter) : ?>
                            <li class="twitter">
                                <a target="_blank" title="Twitter" href="https://twitter.com/<?php echo $twitter; ?>">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <?php endif?>
                            <?php if ($instagram) : ?>
                            <li class="instagram">
                                <a target="_blank" title="Instagram" href="https://instagram.com/<?php echo $instagram; ?>">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <?php endif?>
                            <?php if ($linkedin) : ?>
                            <li class="linkedin">
                                <a target="_blank" title="Linked In" href="<?php echo $linkedin; ?>">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <?php endif?>
                        </ul>
                    </div>
                    <?php endif?>
                </div>
                <div class="one_half last">
                    <div style="margin:auto;width:100%">
                        <div class="one_half">
                            <p>
                                <?php if ($pricing) : ?>
                                    Price Range</br>
                                <?php endif?>
                                <?php if ($number_of_rooms) : ?>
                                    Number of rooms</br>
                                <?php endif?>
                                <?php if ($checkin_time) : ?>
                                    Check In</br>
                                <?php endif?>
                                <?php if ($checkout_time) : ?>
                                    Check Out</br>
                                <?php endif?>
                            </p>
                        </div>
                        <div class="one_half last">
                            <p>
                                <?php if ($pricing) : ?>
                                    <?php echo $pricing; ?></br>
                                <?php endif?>
                                <?php if ($number_of_rooms) : ?>
                                    <?php echo $number_of_rooms; ?></br>
                                <?php endif?>
                                <?php if ($checkin_time) : ?>
                                    <?php echo $checkin_time; ?></br>
                                <?php endif?>
                                <?php if ($checkout_time) : ?>
                                    <?php echo $checkout_time; ?></br>
                                <?php endif?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <br class="clear" />

            <?php if($amenities) : ?>
            <br class="clear" />
            <hr>
            <br class="clear" />
            <h3>Amenities</h3>
            <div class="nomad-amenities" style="margin:auto;width:100%">
                <br/>
                <ul class="<?php if(count($amenities) <= 4) { echo 'nomad-columnar-list1'; } elseif (count($amenities) > 4 && count($amenities) < 8) { echo 'nomad-columnar-list2'; } else { echo 'nomad-columnar-list3'; } ?>">
                <?php for($x = 1; $x <= count($amenities); $x++) : ?>
                    <li><i class="fa fa-image"></i> <?php echo $amenities[$x-1]->name ?></li>
                <?php endfor ?>
                </ul>
            </div>
            <?php endif ?>

            <?php if($video) : ?>
            <br class="clear" />
            <hr>
            <br class="clear" />
            <h3>Video</h3>
            <div class="nomad-video" style="margin:auto;width:100%">
                <br/>
                <?php echo $video; ?>
            </div>
            <?php endif ?>

            <?php if($awards) : ?>
            <br class="clear" />
            <hr>
            <br class="clear" />
            <h3>Awards</h3>
            <div class="nomad-awards" style="margin:auto;width:100%">
                <br/>
                <?php echo $awards; ?>
            </div>
            <?php endif ?>

            <?php if($event_offers) : ?>
            <br class="clear" />
            <hr>
            <br class="clear" />
            <h3>Events & Offers</h3>
            <div class="nomad-events-offers" style="margin:auto;width:100%">
                <br/>
                <?php echo $event_offers; ?>
            </div>
            <?php endif ?>

            <?php
            //Display listing comments
            if (comments_open($post->ID) && !empty($nomad_single_review)) {
            ?>
                <div class="fullwidth_comment_wrapper sidebar">
                    <?php comments_template('', true);?>
                </div>
            <?php
            }
            ?>
        </div>
    <?php endwhile;?>
<?php endif;?>