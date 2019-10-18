<?php
/**
 * Template Name: Home
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() ) : ?>
  <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>
<div class="slider">
    <?php if( have_rows('slides') ): ?>
                <div id="carousel-home" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php
                        $active = 'active';
                        $num = 0;
                        while ( have_rows('slides') ) : the_row();
                            ?>
                            <li data-target="#carousel-home" data-slide-to="<?php echo $num ?>" class="<?php echo $active ?>"></li>
                            <?php
                            $active = '';
                            $num += 1;
                        endwhile; ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $active = 'active';
                        while ( have_rows('slides') ) : the_row();
                            ?>
                            <div class="carousel-item <?php echo $active ?>">
                                <?php 
                                $image = get_sub_field('imagen');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <h3><?php the_sub_field('titulo'); ?></h3>
                                    <p><?php the_sub_field('descripcion'); ?></p>
                                </div>
                            </div><!-- /item -->
                            <?php $active = '';
                        endwhile;
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-home" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-home" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
        </div><!-- /row -->
    <?php endif; ?>
</div>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>
                    <?php
                    $categories = get_categories('exclude=1', array(
                        'orderby' => 'name',
                        'order'   => 'ASC',
                        'hide_empty'=> true
                    ) );

                    foreach( $categories as $category ) {
                        $category_link = sprintf( 
                            '<a href="%1$s" alt="%2$s">%3$s</a>',
                            esc_url( get_category_link( $category->term_id ) ),
                            esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
                            esc_html( $category->name )
                        );

                        echo '<p>' . sprintf( esc_html__( 'Category: %s', 'textdomain' ), $category_link ) . '</p> ';
                        
                    } 
                    ?>
                
				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>
