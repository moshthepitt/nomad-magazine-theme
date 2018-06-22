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
}

function enqueueNomadStuff() {
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
}


function nomadGetHierarchicalTerms($term_name, $term_ids=null, $separator=', ')
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