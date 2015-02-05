<?php

/**
* Teeline Theme
Functions.php
* 
* PHP versions 4 and 5
* 
* @category   Theme Functions 
* @package    WordPress
* @author     ArsTropica <info@arstropica.com> 
* @copyright  2014 ArsTropica 
* @license    http://opensource.org/licenses/gpl-license.php GNU Public License 
* @version    1.0 
* @link       http://pear.php.net/package/ArsTropica  Reponsive Framework
* @subpackage Teeline Theme
* @see        References to other sections (if any)...
*/
// Definitions

/* Define paths to theme directory */
if (!defined('child_template_directory'))
    define('child_template_directory', dirname(__FILE__));

if (!defined('child_template_url'))
    define('child_template_url', get_stylesheet_directory_uri());

// Actions

add_action('widgets_init', 'at_responsive_child_register_sidebars');

add_action('wp_print_styles', 'at_responsive_child_theme_styles');

/* Enqueue Theme Scripts */
add_action('wp_enqueue_scripts', 'at_responsive_child_theme_scripts');

/* Initialize Theme Building Functions */
add_action('init', 'at_responsive_child_theme_setup', 10);

/* Register Theme Sidebars */
add_action('widgets_init', 'at_responsive_child_register_sidebars');

/* Sidebar Widget Areas */
add_action('at_responsive_slim_deck', 'at_responsive_do_slim_deck_widget_area');

/* Related Posts on Single Posts */
add_action('at_responsive_loop_end', 'at_responsive_child_do_related_posts_single');

// Filters

/* Full width menu */
add_filter('nav_menu_css_class', 'at_responsive_child_fullwidth_dropdown_class', 10, 3);

/* Add fixed class to dropdown menu */
add_filter('at_responsive_dropdown_menu_classes', 'at_responsive_child_dropdown_menu_classes');

/* Add submenu-wrap span to submenu items */
add_filter('at_responsive_nav_menu_args', 'at_responsive_child_nav_menu_args', 10, 2);

/* Sidebar Grid Classes */
add_filter('at_responsive_content_grid_classes', 'at_responsive_child_grid_classes');

/* Dropdown Menu Wrapper */
// add_filter( 'at_responsive_child_menu_start_lvl', 'at_responsive_child_menu_dropdown_open', 10, 2);
// add_filter( 'at_responsive_child_menu_end_lvl', 'at_responsive_child_menu_dropdown_close', 10, 2);

add_filter('at_responsive_pagination_links', 'at_responsive_child_pagination_links');

// Functions

/**
* Enqueue Theme Stylesheets
* 
* @since 1.0
* @return void 
*/
function at_responsive_child_theme_styles() {
    // Load our main stylesheet.
    wp_enqueue_style('at-responsive-style', get_stylesheet_uri(), array('at-responsive-framework-style'));
    wp_enqueue_style('at-responsive-child-style', child_template_url . '/css/default.css', array('at-responsive-framework-style', 'at-common-style'));
    // Minified?
    wp_enqueue_style('at-responsive-child-style-min', child_template_url . '/css/default.css', array('at-reponsive-framework-minified-css-assets'));
}

/* Enqueue Theme Scripts */

/**
* Enqueue Theme Scripts
* 
* @since 1.0
* @return void 
*/
function at_responsive_child_theme_scripts() {
    // Silence
}

/**
* Setup Theme Building
* 
* @since 1.0
* @return void 
*/
function at_responsive_child_theme_setup() {
    global $at_theme_custom;
    // Add Image size(s) for Header and Thumbnail Images
    add_image_size('at-header', 1440, 460, true);
    add_image_size('entry-thumbnail', 953, 0, true);
    add_image_size('single-thumbnail', 276);


    // Init MastHead
    add_action('at_responsive_hero', 'at_responsive_child_masthead');

    // Setup Grid Variables
    at_responsive_set_content_grid_values(12, 8, 8, 8, 8, 4, 4, 8, 8, 8, 8, 12);

    // Setup Theme Settings Defaults
    $args = array(
    'stickynav' => false,
    'excerptlength' => 55,
    'homeexcerptlength' => 55,
    'postsperpage' => 9,
    'homepostsperpage' => 3,
    );
    at_responsive_set_theme_settings_default_values($args);
}

/* Register Theme Sidebars */

/**
* Register Theme Sidebars
* 
* @since 1.0
* @return void 
*/
function at_responsive_child_register_sidebars() {
    global $theme_namespace;
    /* register_sidebar( array(
    'name' => 'Footer Sidebar',
    'id' => 'footer_sidebar',
    'before_widget' => '<aside id="%1$s" class="at_widget %2$s" role="complementary">',
    'after_widget' => '</div></aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4><div class="widget-wrap">',
    ) ); */
    register_sidebar(array(
    'name' => 'Slim Deck',
    'id' => 'slim_deck',
    'description' => __('Full width sidebar that takes four small horizontal widgets.', $theme_namespace),
    'before_widget' => '<aside id="%1$s" class="col-md-4 widget at_widget %2$s" role="complementary"><div class="widget-frame eq-height">',
    'after_widget' => "</div></div></div></aside>",
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4><div class="widget-wrap"><div class="widget-content">',
    ));
}

/**
* Handle Sidebar Widgets
* 
* @since 1.0
* @return void 
*/
function at_responsive_do_slim_deck_widget_area() {
    at_responsive_do_sidebar('Slim Deck', 'col-md-12');
}

/**
* Full width Nav dropdown class
* 
* @param array   $classes Parameter 
* @param object $item    Parameter 
* @param object  $args    Parameter 
* @since 1.0
* @return array   Return 
*/
function at_responsive_child_fullwidth_dropdown_class($classes, $item, $args) {
    if (@$args->has_children)
        $classes[] = 'hlayout';

    return $classes;
}

/**
* Related Posts on Single Pages
* 
* @since 1.0
* @return unknown Return 
*/
function at_responsive_child_do_related_posts_single() {
    global $at_theme_custom, $at_related_posts;
    if (is_single()) {
        $enable_plugin = $at_theme_custom->get_option('settings/enableyarpp', false);
        if ($enable_plugin) {
            if (!$at_related_posts && class_exists('at_related_posts')) {
                $at_related_posts = new at_related_posts();
            } elseif (!class_exists('at_related_posts')) {
                return;
            }
            if (!$at_related_posts->has_related_posts()) {
                return;
            }
            $at_related_posts->do_related_posts_widget(true);
        }
    }
}

/**
* Add extra classes to dropdown menu
* 
* @param array $c Parameter 
* @since 1.0
* @return array Return 
*/
function at_responsive_child_dropdown_menu_classes($c) {
    $c[] = 'fixed';
    return $c;
}

/**
* Add centering <span> tag to menu items
* 
* @param object $args Parameter 
* @param object $item Parameter 
* @since 1.0
* @return object Return 
*/
function at_responsive_child_nav_menu_args($args, $item) {
    if ($item->menu_item_parent && is_object($args)) {
        if (isset($args->link_before) && !stristr($args->link_before, '<span class="submenu-wrap">'))
            $args->link_before .= ' <span class="submenu-wrap">';
        else
            $args->link_before = '<span class="submenu-wrap">';

        if (isset($args->link_after) && !stristr($args->link_after, '</span>'))
            $args->link_after .= ' </span>';
        else
            $args->link_after = '</span>';
    }
    return $args;
}

/**
* Classes for Left Sidebar Layout
* 
* @param array $classes Parameter 
* @since 1.0
* @return array Return 
*/
function at_responsive_child_grid_classes($classes) {
    if (!is_array($classes))
        $classes = array();

    if (!isset($classes['full']))
        $classes['full'] = '';
    if (!isset($classes['home']))
        $classes['home'] = '';
    if (!isset($classes['row']))
        $classes['row'] = '';
    if (!isset($classes['single']))
        $classes['single'] = '';
    if (!isset($classes['archive']))
        $classes['archive'] = '';
    if (!isset($classes['loop_start']))
        $classes['loop_start'] = '';
    if (!isset($classes['loop_end']))
        $classes['loop_end'] = '';
    if (!isset($classes['pagination']))
        $classes['pagination'] = '';
    if (!isset($classes['comments']))
        $classes['comments'] = '';
    if (!isset($classes['featured']))
        $classes['featured'] = '';

    $grid_values = at_responsive_get_content_grid_values();
    $push = intval((12 - $grid_values['row']) / 2);

    $classes['full'] .= " col-md-push-0 col-xs-push-0";
    $classes['row'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['home'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['single'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['archive'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['loop_start'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['loop_end'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['pagination'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['comments'] .= " col-md-push-{$push} col-xs-push-0";
    $classes['featured'] .= "";
    return $classes;
}

/**
* Blog Title Banner
* 
* @since 1.0
* @return void 
*/
function at_responsive_child_masthead() {
    $logo = get_bloginfo('name');
    $output = "";
    $output .= '<div class="logo-placeholder">' . "\n";
    $output .= '    <div class="container">' . "\n";
    $output .= '        <div class="business-logo row">' . "\n";
    $output .= '            <a title="' . get_bloginfo('name') . '" href="' . site_url() . '" target="_blank">' . $logo . '</a>' . "\n";
    $output .= '        </div>' . "\n";
    $output .= '    </div>' . "\n";
    $output .= '</div>' . "\n";
    echo $output;
}

/**
* Dropdown Wrap Open
* 
* @param string  $output Parameter 
* @param string $indent Parameter 
* @since 1.0
* @return string  Return 
*/
function at_responsive_child_menu_dropdown_open($output, $indent) {
    $output = "\n{$indent}<div class=\"dropdown-wrapper\">" . $output;
    return $output;
}

/**
* Dropdown Wrap Close
* 
* @param string  $output Parameter 
* @param string $indent Parameter 
* @since 1.0
* @return string  Return 
*/
function at_responsive_child_menu_dropdown_close($output, $indent) {
    $output .= "\n{$indent}</div>";
    return $output;
}

/* Pagination Links */

/**
* Pagination Links
* 
* @param string $links Parameter 
* @since 1.0
* @return string  Return 
*/
function at_responsive_child_pagination_links($links) {
    return str_replace('glyphicon-chevron', 'glyphicon-arrow', $links);
}
