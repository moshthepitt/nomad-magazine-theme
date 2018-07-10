<?php
/**
 * Listings Search Form Template
 *
 * Template file for a nomad listings search form.
 *
 * @category Theme
 * @package  Nomad_Magazine_Theme
 * @author   Kelvin Jayanoris <kelvin@jayanoris.com>
 * @license  https://github.com/moshthepitt/nomad-magazine-theme/blob/master/LICENSE GPL-2.0+
 * @link     https://github.com/moshthepitt/nomad-magazine-theme
 */

$tax_base = 'nomad-';
$location_terms = get_terms($tax_base . 'listing-item-location', array('hide_empty' => true));

$location_input = get_query_var('location', null);
$keyword_input = get_query_var('q', null);

$options_output = get_terms_hierarchical($location_terms, $output = '', $parent_id = 0, $level = 0, $selected = $location_input);
?>
<form id="tour_search_form" name="tour_search_form" method="get" action="" class="nomad-listings-search-form">
    <div class="tour_search_wrapper">
        <div class="one_third themeborder">
            <input
                id="keyword"
                name="q"
                type="text"
                autocomplete="off"
                placeholder="Ex: hotel, home, lodge"
                <?php if ($keyword_input) : ?>
                    value="<?php echo $keyword_input; ?>"
                <?php endif ?>
            >
            <span class="ti-search"></span>
            <div id="autocomplete" class="autocomplete" data-mousedown="false"></div>
        </div>
        <div class="one_third themeborder">
            <select id="location" name="location">
                <option value="">Any location</option>
                <?php echo $options_output; ?>
            </select>
            <span class="ti-angle-down"></span>
        </div>
        <div class="one_third last themeborder">
            <input id="tour_search_btn" type="submit" class="button" value="Search">
        </div>
    </div>
</form>
