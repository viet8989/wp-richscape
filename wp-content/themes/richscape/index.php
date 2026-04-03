<?php
/**
 * The main template file
 * Default fallback template
 */

get_header(); ?>

<div class="container mx-auto px-4 py-16" style="margin-top: calc(41.11px + 96px);">
	<?php
	if ( have_posts() ) :
		// Start the loop.
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8' ); ?>>
				<header class="entry-header mb-4">
					<?php the_title( '<h1 class="entry-title text-3xl font-bold">', '</h1>' ); ?>
				</header>
				<div class="entry-content text-gray-300">
					<?php
					the_content();
					?>
				</div>
			</article>
			<hr class="border-white/10 my-10">
			<?php
		endwhile;
	else :
		echo '<p class="text-gray-400">Không tìm thấy nội dung.</p>';
	endif;
	?>
</div>

<?php
get_footer();
