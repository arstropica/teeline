<?php
/**
 * Teeline Theme content.php
 * 
 * PHP version 5
 * 
 * @category   Theme Template 
 * @package    WordPress
 * @author     ArsTropica <info@arstropica.com> 
 * @copyright  2014 ArsTropica 
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @version    1.0 
 * @link       http://pear.php.net/package/ArsTropica  Reponsive Framework
 * @subpackage Teeline Theme
 * @see        References to other sections (if any)...
 */
/**
 * Description for global
 * @global unknown 
 */
global $post, $theme_namespace;
$content_type = at_responsive_wp_content_type();
$layout_type = at_responsive_wp_template_type();
$grid_values = at_responsive_get_content_grid_values();
$grid_classes = at_responsive_get_content_grid_classes();

switch ($layout_type) {
    // Non-Static Homepage Post Entry
    case 'front_page' :
    case 'home' :
    default : {
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class("col-md-{$grid_values['home']} col-xs-{$grid_values['full']} {$grid_classes['home']}"); ?> itemtype="http://schema.org/BlogPosting" itemprop="blogPost" role="main">
                <div class="layout-wrapper">
                    <div class="content-wrapper">
                        <div class="col-md-12">
                            <div class="entry-header">
                                <?php at_responsive_post_title(); ?>
                                <div class="entry-meta">
                                    <?php echo at_responsive_post_entry(); ?>
                                </div>
                            </div>            
                        </div>            
                        <div class="col-md-12 entry-body">
                            <div class="entry-content" itemprop="text">
                                <?php at_responsive_post_excerpt(); ?>
                                <div style="width:100%; height: 0px; clear: both;"></div>
                            </div>
                        </div>
                        <div class="entry-meta col-md-12">
                            <?php at_responsive_post_meta(); ?>
                        </div>
                        <?php #at_responsive_post_social_sharing();  ?>
                        <?php if (!is_preview() && !at_responsive_is_customizer()) at_responsive_post_addthis(); ?>
                        <div style="clear: both; width: 100%; height: 0px;"></div>
                    </div>
                </div>
            </article>

            <?php
            break;
        }
    case 'search' :
    case 'date' :
    case 'archive' : {
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class("col-md-{$grid_values['archive']} col-xs-{$grid_values['full']} {$grid_classes['archive']}"); ?> itemtype="http://schema.org/BlogPosting" itemprop="blogPost" role="main">
                <div class="layout-wrapper">
                    <div class="content-wrapper">
                        <div class="col-md-12">
                            <div class="entry-header">
                                <?php at_responsive_post_title(); ?>
                                <div class="entry-meta">
                                    <?php echo at_responsive_post_entry(); ?>
                                </div>
                            </div>            
                        </div>            
                        <div class="col-md-12 entry-body">
                            <div class="entry-content" itemprop="text">
                                <?php at_responsive_post_excerpt(); ?>
                                <div style="width:100%; height: 0px; clear: both;"></div>
                            </div>
                        </div>
                        <div class="entry-meta col-md-12">
                            <?php at_responsive_post_meta(); ?>
                        </div>
                        <?php #at_responsive_post_social_sharing();  ?>
                        <?php if (!is_preview() && !at_responsive_is_customizer()) at_responsive_post_addthis(); ?>
                        <div style="clear: both; width: 100%; height: 0px;"></div>
                    </div>
                </div>
            </article>
            <?php
            break;
        }
    case 'singular' : {
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class("col-md-{$grid_values['single']} col-xs-{$grid_values['full']} {$grid_classes['single']}"); ?> itemtype="http://schema.org/BlogPosting" itemprop="blogPost" role="main">
                <div class="layout-wrapper">
                    <div class="content-wrapper">
                        <div class="entry-header row">
                            <div class="entry-heading col-sm-7">
                                <?php at_responsive_post_title(); ?>
                            </div>
                            <div class="entry-share col-sm-5">
                                <?php at_responsive_post_sharing(); ?>
                            </div>
                        </div>
                        <div class="entry-meta row">
                            <div class="col-md-12">
                                <?php echo at_responsive_post_entry(); ?>
                            </div>
                        </div>
                        <div class="entry-content" itemprop="text">
                            <?php
                            the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', $theme_namespace));
                            wp_link_pages(array(
                                'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', $theme_namespace) . '</span>',
                                'after' => '</div>',
                                'link_before' => '<span>',
                                'link_after' => '</span>',
                            ));
                            ?>
                            <div style="width:100%; height: 0px; clear: both;"></div>
                        </div><!-- .entry-content -->
                        <footer class="entry-meta">
                            <?php at_responsive_post_meta(); ?>
                        </footer>
                        <div style="clear: both; width: 100%; height: 0px;"></div>
                    </div>
                </div>
            </article>
            <?php
            break;
        }
    case '404' : {
            ?>
            <article id="post-404" class="<?php echo "col-md-{$grid_values['single']} col-xs-{$grid_values['full']} {$grid_classes['single']}"; ?> post-404" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" role="main">
                <div class="layout-wrapper">
                    <div class="content-wrapper">
                        <div class="entry-header row">
                            <div class="entry-heading col-sm-12">
                                <h1 class="entry-title" itemprop="headline"><span><?php _e('Nothing Found for "' . get_search_query() . '"', $theme_namespace); ?></span></h1>
                            </div>
                        </div>
                        <div class="entry-content" itemprop="text">
                            <?php locate_template('/templates/404.php', true, false); ?>
                        </div><!-- .entry-content -->
                        <div style="clear: both; width: 100%; height: 0px;"></div>
                    </div>
                </div>
            </article>
            <?php
            break;
        }
}
?>