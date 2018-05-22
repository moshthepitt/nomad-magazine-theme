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

function enqueueParentStyles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

function nomadGetHierarchicalTerms($term_name, $separator)
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
    $term_tree = wp_list_categories($term_tree_args);
    $term_tree = rtrim(trim(str_replace($separator, $separator, $term_tree)), $separator);
    $term_tree = explode($separator, $term_tree);
    $term_tree = array_reverse($term_tree);
    $term_tree = implode($separator, $term_tree);
    return $term_tree;
}