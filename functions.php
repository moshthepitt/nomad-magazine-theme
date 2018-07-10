<?php
/**
 * Theme Functions
 *
 * Theme functions for Nomad Child Theme.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */
// Add parent theme style.css
add_action('wp_enqueue_scripts', 'enqueueParentStyles');
add_action('wp_enqueue_scripts', 'enqueueNomadStuff');

function enqueueParentStyles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    // remove this as it is not https safe
    wp_dequeue_style('fontawesome-stars');
    // add it back in, safely
    wp_enqueue_style(
        "fontawesome-stars-nomad",
        get_stylesheet_directory_uri() . "/assets/fontawesome-stars-o.css",
        false
    );
}

function enqueueNomadStuff()
{
    $post_type = get_post_type();

    if ($post_type == 'nomad-listing') {
        wp_enqueue_style(
            'bxslider',
            get_stylesheet_directory_uri() . '/assets/bxslider/jquery.bxslider.css'
        );
        wp_enqueue_script(
            'bxslider',
            get_stylesheet_directory_uri() . '/assets/bxslider/jquery.bxslider.min.js',
            array(),
            '1.0.0',
            true
        );
        wp_enqueue_script(
            'nomad',
            get_stylesheet_directory_uri() . '/assets/nomad.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'barrating',
            get_stylesheet_directory_uri() . '/assets/jquery.barrating.js',
            false
        );
    }
}

function nomadGetHierarchicalTerms($term_name, $term_ids = null, $separator = ', ')
{
    $term_tree_args = array(
        'taxonomy' => $term_name,
        'orderby' => 'name',
        'show_count' => false,
        'pad_counts' => false,
        'hierarchical' => true,
        'title_li' => '',
        'separator' => $separator,
        'style' => 'none',
        'echo' => false,
    );
    if ($term_ids) {
        $term_tree_args['include'] = $term_ids;
    }
    $term_tree = wp_list_categories($term_tree_args);
    $term_tree = rtrim(trim(str_replace($separator, $separator, $term_tree)), $separator);
    $term_tree = explode($separator, $term_tree);
    $term_tree = array_reverse($term_tree);
    $term_tree = implode($separator, $term_tree);
    return $term_tree;
}

function nomadSortArrayWithObjects($array, $property)
{
    usort($array, function ($a, $b) use ($property) {
        return strcmp($a->$property, $b->$property);
    });
    return $array;
}

// Add fields after default fields above the comment box, always visible

add_action('comment_form_logged_in_after', 'nomadtheme_additional_fields');
add_action('comment_form_after_fields', 'nomadtheme_additional_fields');

function nomadtheme_additional_fields()
{

    $post_type = get_post_type();

    if ($post_type == 'nomad-listing') {
        echo '<p class="comment-form-rating">' .
        '<label for="accomodation_rating">' . esc_html__('Accomodation', 'nomadtheme') . '</label>
		<span class="commentratingbox">
		<select id="accomodation_rating" name="accomodation_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }

        echo '</select></p>';

        echo '<p class="comment-form-rating">' .
        '<label for="destination_rating">' . esc_html__('Destination', 'nomadtheme') . '</label>
		<span class="commentratingbox">
		<select id="destination_rating" name="destination_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }

        echo '</select></p>';

        echo '<p class="comment-form-rating">' .
        '<label for="meals_rating">' . esc_html__('Meals', 'nomadtheme') . '</label>
		<span class="commentratingbox">
		<select id="meals_rating" name="meals_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }

        echo '</select></p>';

        echo '<p class="comment-form-rating">' .
        '<label for="transport_rating">' . esc_html__('Transport', 'nomadtheme') . '</label>
		<span class="commentratingbox">
		<select id="transport_rating" name="transport_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }

        echo '</select></p>';

        echo '<p class="comment-form-rating">' .
        '<label for="value_rating">' . esc_html__('Value For Money', 'nomadtheme') . '</label>
		<span class="commentratingbox">
		<select id="value_rating" name="value_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }

        echo '</select></p>';

        echo '<p class="comment-form-rating">' .
        '<label for="overall_rating">' . esc_html__('Overall', 'nomadtheme') . '</label>
		<span class="commentratingbox">
		<select id="overall_rating" name="overall_rating">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }

        echo '</select></p>';

        echo '<script>';
        echo 'jQuery(function() {
	      	jQuery("#accomodation_rating, #destination_rating, #meals_rating, #transport_rating, #value_rating, #overall_rating").barrating({
	        	theme: "fontawesome-stars-o",
	        	emptyValue: 0,
	        	allowEmpty: true
	      	});

	      	jQuery("#accomodation_rating, #destination_rating, #meals_rating, #transport_rating, #value_rating, #overall_rating").barrating("set", 0);
	    });';
        echo '</script>';
    }
}

// Save the comment meta data along with comment

add_action('comment_post', 'nomadtheme_save_comment_meta_data');
function nomadtheme_save_comment_meta_data($comment_id)
{
    $obj_comment = get_comment($comment_id);
    $post_type = get_post_type($obj_comment->comment_post_ID);

    if ($post_type == 'nomad-listing') {
        if ((isset($_POST['accomodation_rating'])) && ($_POST['accomodation_rating'] != '')) {
            $rating = wp_filter_nohtml_kses($_POST['accomodation_rating']);
        }

        add_comment_meta($comment_id, 'accomodation_rating', $rating);

        if ((isset($_POST['destination_rating'])) && ($_POST['destination_rating'] != '')) {
            $rating = wp_filter_nohtml_kses($_POST['destination_rating']);
        }

        add_comment_meta($comment_id, 'destination_rating', $rating);

        if ((isset($_POST['meals_rating'])) && ($_POST['meals_rating'] != '')) {
            $rating = wp_filter_nohtml_kses($_POST['meals_rating']);
        }

        add_comment_meta($comment_id, 'meals_rating', $rating);

        if ((isset($_POST['transport_rating'])) && ($_POST['transport_rating'] != '')) {
            $rating = wp_filter_nohtml_kses($_POST['transport_rating']);
        }

        add_comment_meta($comment_id, 'transport_rating', $rating);

        if ((isset($_POST['value_rating'])) && ($_POST['value_rating'] != '')) {
            $rating = wp_filter_nohtml_kses($_POST['value_rating']);
        }

        add_comment_meta($comment_id, 'value_rating', $rating);

        if ((isset($_POST['overall_rating'])) && ($_POST['overall_rating'] != '')) {
            $rating = wp_filter_nohtml_kses($_POST['overall_rating']);
        }

        add_comment_meta($comment_id, 'overall_rating', $rating);

        //Calculate average rating
        $args = array(
            'status' => 'approve',
            'post_id' => $obj_comment->comment_post_ID, // use post_id, not post_ID
        );
        $tg_comments = get_comments($args);
        $count_comments = count($tg_comments);
        $rating_avg = 0;
        $rating_points = 0;

        if (!empty($tg_comments) && is_array($tg_comments)) {
            foreach ($tg_comments as $tg_comment) {
                $rating = get_comment_meta($tg_comment->comment_ID, 'overall_rating', true);
                $rating_points += $rating;
            }

            $rating_avg = $rating_points / $count_comments;
        }

        if (!empty($rating_avg)) {
            if (!get_post_meta($obj_comment->comment_post_ID, 'average_rating')) {
                add_post_meta($obj_comment->comment_post_ID, 'average_rating', $rating_avg);
            } else {
                update_post_meta($obj_comment->comment_post_ID, 'average_rating', $rating_avg);
            }
        }
    }
}

// Add the filter to check if the comment meta data has been filled or not

add_filter('preprocess_comment', 'nomadtheme_verify_comment_meta_data');
function nomadtheme_verify_comment_meta_data($commentdata)
{
    $post_type = get_post_type($commentdata['comment_post_ID']);

    if ($post_type == 'nomad-listing') {
        if (!isset($_POST['accomodation_rating']) or empty($_POST['accomodation_rating'])) {
            wp_die(esc_html__('Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with accomodation rating.', 'nomadtheme'));
        }

        if (!isset($_POST['destination_rating']) or empty($_POST['destination_rating'])) {
            wp_die(esc_html__('Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with destination rating.', 'nomadtheme'));
        }

        if (!isset($_POST['meals_rating']) or empty($_POST['meals_rating'])) {
            wp_die(esc_html__('Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with meals rating.', 'nomadtheme'));
        }

        if (!isset($_POST['transport_rating']) or empty($_POST['transport_rating'])) {
            wp_die(esc_html__('Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with transport rating.', 'nomadtheme'));
        }

        if (!isset($_POST['value_rating']) or empty($_POST['value_rating'])) {
            wp_die(esc_html__('Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with value for money rating.', 'nomadtheme'));
        }

        if (!isset($_POST['overall_rating']) or empty($_POST['overall_rating'])) {
            wp_die(esc_html__('Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with overall rating.', 'nomadtheme'));
        }

    }

    return $commentdata;
}

//Add an edit option in comment edit screen

add_action('add_meta_boxes_comment', 'nomadtheme_extend_comment_add_meta_box');
function nomadtheme_extend_comment_add_meta_box($comment)
{
    $post_type = get_post_type($comment->comment_post_ID);

    if ($post_type == 'nomad-listing') {
        add_meta_box('title', esc_html__('Comment Metadata - Rating', 'nomadtheme'), 'nomadtheme_extend_comment_meta_box', 'comment', 'normal', 'high');
    }
}

function nomadtheme_extend_comment_meta_box($comment)
{
    $post_type = get_post_type($comment->comment_post_ID);

    if ($post_type == 'nomad-listing') {
        $accomodation_rating = get_comment_meta($comment->comment_ID, 'accomodation_rating', true);
        $destination_rating = get_comment_meta($comment->comment_ID, 'destination_rating', true);
        $meals_rating = get_comment_meta($comment->comment_ID, 'meals_rating', true);
        $transport_rating = get_comment_meta($comment->comment_ID, 'transport_rating', true);
        $value_rating = get_comment_meta($comment->comment_ID, 'value_rating', true);
        $overall_rating = get_comment_meta($comment->comment_ID, 'overall_rating', true);

        wp_nonce_field('nomadtheme_extend_comment_update', 'nomadtheme_extend_comment_update', false);
        ?>
    <p>
        <label for="accomodation_rating"><?php esc_html_e('Accomodation ', 'nomadtheme');?></label>
			<select id="accomodation_rating" name="accomodation_rating">
			<?php for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"';
            if ($accomodation_rating == $i) {
                echo ' selected';
            }

            echo '>' . $i . ' </option>';
        }
        ?>
			</select>
    </p>

    <p>
        <label for="destination_rating"><?php esc_html_e('Destination ', 'nomadtheme');?></label>
			<select id="destination_rating" name="destination_rating">
			<?php for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"';
            if ($destination_rating == $i) {
                echo ' selected';
            }

            echo '>' . $i . ' </option>';
        }
        ?>
			</select>
    </p>

    <p>
        <label for="meals_rating"><?php esc_html_e('Meals ', 'nomadtheme');?></label>
			<select id="meals_rating" name="meals_rating">
			<?php for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"';
            if ($meals_rating == $i) {
                echo ' selected';
            }

            echo '>' . $i . ' </option>';
        }
        ?>
			</select>
    </p>

    <p>
        <label for="transport_rating"><?php esc_html_e('Transport ', 'nomadtheme');?></label>
			<select id="transport_rating" name="transport_rating">
			<?php for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"';
            if ($transport_rating == $i) {
                echo ' selected';
            }

            echo '>' . $i . ' </option>';
        }
        ?>
			</select>
    </p>

    <p>
        <label for="value_rating"><?php esc_html_e('Value For Money ', 'nomadtheme');?></label>
			<select id="value_rating" name="value_rating">
			<?php for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"';
            if ($value_rating == $i) {
                echo ' selected';
            }

            echo '>' . $i . ' </option>';
        }
        ?>
			</select>
    </p>

    <p>
        <label for="overall_rating"><?php esc_html_e('Overall ', 'nomadtheme');?></label>
			<select id="overall_rating" name="overall_rating">
			<?php for ($i = 1; $i <= 5; $i++) {
            echo '<option value="' . $i . '"';
            if ($overall_rating == $i) {
                echo ' selected';
            }

            echo '>' . $i . ' </option>';
        }
        ?>
			</select>
    </p>
    <?php
echo '<script>';
        echo 'jQuery(function() {
	      	jQuery("#accomodation_rating, #destination_rating, #meals_rating, #transport_rating, #value_rating, #overall_rating").barrating({
	        	theme: "fontawesome-stars-o",
	        	emptyValue: 0,
	        	allowEmpty: true
	      	});
	    });';
        echo '</script>';
    }
}

// Update comment meta data from comment edit screen

add_action('edit_comment', 'nomadtheme_extend_comment_edit_metafields');
function nomadtheme_extend_comment_edit_metafields($comment_id)
{
    $obj_comment = get_comment($comment_id);
    $post_type = get_post_type($obj_comment->comment_post_ID);

    if ($post_type == 'nomad-listing') {
        if (!isset($_POST['nomadtheme_extend_comment_update']) || !wp_verify_nonce($_POST['nomadtheme_extend_comment_update'], 'nomadtheme_extend_comment_update')) {
            return;
        }

        if ((isset($_POST['accomodation_rating'])) && ($_POST['accomodation_rating'] != '')):
            $rating = wp_filter_nohtml_kses($_POST['accomodation_rating']);
            update_comment_meta($comment_id, 'accomodation_rating', $rating);
        else:
            delete_comment_meta($comment_id, 'accomodation_rating');
        endif;

        if ((isset($_POST['destination_rating'])) && ($_POST['destination_rating'] != '')):
            $rating = wp_filter_nohtml_kses($_POST['destination_rating']);
            update_comment_meta($comment_id, 'destination_rating', $rating);
        else:
            delete_comment_meta($comment_id, 'destination_rating');
        endif;

        if ((isset($_POST['meals_rating'])) && ($_POST['meals_rating'] != '')):
            $rating = wp_filter_nohtml_kses($_POST['meals_rating']);
            update_comment_meta($comment_id, 'meals_rating', $rating);
        else:
            delete_comment_meta($comment_id, 'meals_rating');
        endif;

        if ((isset($_POST['transport_rating'])) && ($_POST['transport_rating'] != '')):
            $rating = wp_filter_nohtml_kses($_POST['transport_rating']);
            update_comment_meta($comment_id, 'transport_rating', $rating);
        else:
            delete_comment_meta($comment_id, 'transport_rating');
        endif;

        if ((isset($_POST['value_rating'])) && ($_POST['value_rating'] != '')):
            $rating = wp_filter_nohtml_kses($_POST['value_rating']);
            update_comment_meta($comment_id, 'value_rating', $rating);
        else:
            delete_comment_meta($comment_id, 'value_rating');
        endif;

        if ((isset($_POST['overall_rating'])) && ($_POST['overall_rating'] != '')):
            $rating = wp_filter_nohtml_kses($_POST['overall_rating']);
            update_comment_meta($comment_id, 'overall_rating', $rating);
        else:
            delete_comment_meta($comment_id, 'overall_rating');
        endif;
    }
}

// Add the comment meta (saved earlier) to the comment text
// You can also output the comment meta values directly in comments template

add_filter('comment_text', 'nomadtheme_modify_comment');
function nomadtheme_modify_comment($text)
{
    $post_type = get_post_type();

    if ($post_type == 'nomad-listing') {
        $plugin_url_path = get_stylesheet_directory_uri();

        if ($accomodation_rating = get_comment_meta(get_comment_ID(), 'accomodation_rating', true)) {
            $text .= '<div class="comment_rating_wrapper">';
            $text .= '<div class="comment_rating_label">' . esc_html__('Accomodation', 'nomadtheme') . '</div>';

            $text .= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';

            for ($i = 1; $i <= $accomodation_rating; $i++) {
                $text .= '<a href="javascript:;" class="br-selected"></a>';
            }

            $empty_star = 5 - $accomodation_rating;

            if (!empty($empty_star)) {
                for ($i = 1; $i <= $empty_star; $i++) {
                    $text .= '<a href="javascript:;"></a>';
                }
            }

            $text .= '</div></div></div>';
        }

        if ($destination_rating = get_comment_meta(get_comment_ID(), 'destination_rating', true)) {
            $text .= '<div class="comment_rating_wrapper">';
            $text .= '<div class="comment_rating_label">' . esc_html__('Destination', 'nomadtheme') . '</div>';

            $text .= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';

            for ($i = 1; $i <= $destination_rating; $i++) {
                $text .= '<a href="javascript:;" class="br-selected"></a>';
            }

            $empty_star = 5 - $destination_rating;

            if (!empty($empty_star)) {
                for ($i = 1; $i <= $empty_star; $i++) {
                    $text .= '<a href="javascript:;"></a>';
                }
            }

            $text .= '</div></div></div>';
        }

        if ($meals_rating = get_comment_meta(get_comment_ID(), 'meals_rating', true)) {
            $text .= '<div class="comment_rating_wrapper">';
            $text .= '<div class="comment_rating_label">' . esc_html__('Meals', 'nomadtheme') . '</div>';

            $text .= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';

            for ($i = 1; $i <= $meals_rating; $i++) {
                $text .= '<a href="javascript:;" class="br-selected"></a>';
            }

            $empty_star = 5 - $meals_rating;

            if (!empty($empty_star)) {
                for ($i = 1; $i <= $empty_star; $i++) {
                    $text .= '<a href="javascript:;"></a>';
                }
            }

            $text .= '</div></div></div>';
        }

        if ($transport_rating = get_comment_meta(get_comment_ID(), 'transport_rating', true)) {
            $text .= '<div class="comment_rating_wrapper">';
            $text .= '<div class="comment_rating_label">' . esc_html__('Transport', 'nomadtheme') . '</div>';

            $text .= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';

            for ($i = 1; $i <= $transport_rating; $i++) {
                $text .= '<a href="javascript:;" class="br-selected"></a>';
            }

            $empty_star = 5 - $transport_rating;

            if (!empty($empty_star)) {
                for ($i = 1; $i <= $empty_star; $i++) {
                    $text .= '<a href="javascript:;"></a>';
                }
            }

            $text .= '</div></div></div>';
        }

        if ($value_rating = get_comment_meta(get_comment_ID(), 'value_rating', true)) {
            $text .= '<div class="comment_rating_wrapper">';
            $text .= '<div class="comment_rating_label">' . esc_html__('Value For Money', 'nomadtheme') . '</div>';

            $text .= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';

            for ($i = 1; $i <= $value_rating; $i++) {
                $text .= '<a href="javascript:;" class="br-selected"></a>';
            }

            $empty_star = 5 - $value_rating;

            if (!empty($empty_star)) {
                for ($i = 1; $i <= $empty_star; $i++) {
                    $text .= '<a href="javascript:;"></a>';
                }
            }

            $text .= '</div></div></div>';
        }

        if ($overall_rating = get_comment_meta(get_comment_ID(), 'overall_rating', true)) {
            $text .= '<div class="comment_rating_wrapper">';
            $text .= '<div class="comment_rating_label">' . esc_html__('Overall', 'nomadtheme') . '</div>';

            $text .= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';

            for ($i = 1; $i <= $overall_rating; $i++) {
                $text .= '<a href="javascript:;" class="br-selected"></a>';
            }

            $empty_star = 5 - $overall_rating;

            if (!empty($empty_star)) {
                for ($i = 1; $i <= $empty_star; $i++) {
                    $text .= '<a href="javascript:;"></a>';
                }
            }

            $text .= '</div></div></div>';
        }
    }

    return $text;
}

function get_terms_hierarchical($terms, $output = '', $parent_id = 0, $level = 0, $selected = null) {
    //Out Template
    $outputTemplate = '<option value="%ID%" %SELECTED%>%PADDING%%NAME%</option>';

    foreach ($terms as $term) {
        if ($parent_id == $term->parent) {
            //Replacing the template variables
            $itemOutput = str_replace('%ID%', $term->term_id, $outputTemplate);
            $itemOutput = str_replace('%PADDING%', str_pad('', $level*12, '&nbsp;&nbsp;'), $itemOutput);
            $itemOutput = str_replace('%NAME%', $term->name, $itemOutput);

            if ($selected && (int)$selected == $term->term_id) {
                $itemOutput = str_replace('%SELECTED%', "selected=selected", $itemOutput);
            } else {
                $itemOutput = str_replace('%SELECTED%', "", $itemOutput);
            }

            $output .= $itemOutput;
            $output = get_terms_hierarchical($terms, $output, $term->term_id, $level + 1, $selected = $selected);
        }
    }
    return $output;
}

function add_query_vars_filter($vars) {
    $vars[] = "location";
    $vars[] = "q";
    return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');