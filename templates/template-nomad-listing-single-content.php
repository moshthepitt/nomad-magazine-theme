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