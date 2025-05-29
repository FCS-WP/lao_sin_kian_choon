<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package groffer
 */

get_header(); 

#Redux global variable
global $groffer_redux;

$class = "col-md-12";
$sidebar = "sidebar-1";

if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( $groffer_redux['groffer_blog_layout'] == 'groffer_blog_fullwidth' ) {
        $class = "col-md-12";
    }elseif ( $groffer_redux['groffer_blog_layout'] == 'groffer_blog_right_sidebar' or $groffer_redux['groffer_blog_layout'] == 'groffer_blog_left_sidebar') {
        $class = "col-md-9";
    }
    // Check if active sidebar
    $sidebar = $groffer_redux['groffer_blog_layout_sidebar'];
}else{
    $class = "col-md-9";
}
if (!is_active_sidebar( $sidebar )) {
    $class = "col-md-12";
}
?>

    <!-- Breadcrumbs -->
    <div class="groffer-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if(is_tag()){ ?>
                        <h1 class="page-title"><?php echo esc_html__( 'Tag: ', 'groffer' ) . single_tag_title( '', false ); ?></h1>
                    <?php }elseif(is_search()){ ?>
                        <h1 class="page-title"><?php echo esc_html__( 'Search Results for: ', 'groffer' ) . get_search_query(); ?></h1>
                    <?php }elseif(is_home()){ ?>
                        <h1 class="page-title"><?php echo esc_html__( 'From the Blog', 'groffer' ); ?></h1>
                    <?php }elseif(is_category()){ ?>
                        <h1 class="page-title"><?php echo esc_html__( 'Category: ', 'groffer' ) . single_cat_title( '', false ); ?></h1>
                    <?php }elseif(is_author() || is_archive()){ ?>
                        <h1 class="page-title"><?php echo get_the_archive_title() . get_the_archive_description(); ?></h1>
                    <?php }else{ ?>
                        <h1 class="page-title"><?php esc_html_e('From the Blog','groffer'); ?></h1>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="high-padding">
        <!-- Blog content -->
        <div class="container blog-posts">
            <div class="row">

                <?php if (  class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                    <?php if ( $groffer_redux['groffer_blog_layout'] == 'groffer_blog_left_sidebar' && is_active_sidebar( $sidebar )) { ?>
                        <div class="col-md-3 sidebar-content">
                            <?php dynamic_sidebar( $sidebar ); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="<?php echo esc_attr($class); ?> main-content">
                    <?php if ( have_posts() ) : ?>
                        <div class="row">
                            <?php /* Start the Loop */ ?>
                            <?php while ( have_posts() ) : the_post(); ?>

                                <?php
                                    /* Include the Post-Format-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                     */
                                    get_template_part( 'content', get_post_format() );
                                ?>

                            <?php endwhile; ?>

                            <div class="groffer-pagination pagination col-md-12">             
                                <?php groffer_pagination(); ?>
                            </div>
                        </div>

                    <?php else : ?>

                        <?php get_template_part( 'content', 'none' ); ?>

                    <?php endif; ?>
                </div>

                <?php if (  class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                    <?php if ( $groffer_redux['groffer_blog_layout'] == 'groffer_blog_right_sidebar' && is_active_sidebar( $sidebar )) { ?>
                        <div class="col-md-3 sidebar-content sidebar-content-right-side">
                            <?php  dynamic_sidebar( $sidebar ); ?>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <?php if ( is_active_sidebar( $sidebar )) { ?>
                        <div class="col-md-3 sidebar-content sidebar-content-right-side">
                            <?php  dynamic_sidebar( $sidebar ); ?>
                        </div>
                    <?php } ?>                    
                <?php } ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>