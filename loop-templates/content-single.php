<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->
	<aside id="related">
	<?php $orig_post = $post;
		global $post;
			$tags = wp_get_post_tags($post->ID);
			if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=>5, // Number of related posts that will be shown.
			'caller_get_posts'=>1
			);
			$my_query = new wp_query( $args );
			if( $my_query->have_posts() ) {

			echo '<div id="relatedposts"><h3>Related Posts</h3><ul>';

			while( $my_query->have_posts() ) {
			$my_query->the_post(); ?>

			<li><div class="relatedthumb"><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></div>
			<div class="relatedcontent">
			<h3><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<?php the_time('M j, Y') ?>
			</div>
			</li>
			<? }
			echo '</ul></div>';
			}
			}
			$post = $orig_post;
		wp_reset_query(); ?>
	</aside>

	<footer class="entry-footer">

		

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
