<?php
/**
 * The template for displaying archive pages.
 *
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
                <ol class="breadcrumb">
                    <?php groffer_breadcrumb(); ?>
                </ol>
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
                <div class="row">
                    <?php if ( have_posts() ) : ?>
              
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
                        
                        <div class="clearfix"></div>
                        <div class="groffer-pagination pagination col-md-12">             
                            <?php groffer_pagination(); ?>
                        </div>
                   
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                </div>
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