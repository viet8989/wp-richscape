<?php
/**
 * Template Part: Project Item
 * Used in: front-page.php, archive-projects.php, page-projects.php, single-projects.php (related)
 * Context: inside a WP_Query loop (the_post() already called)
 */

$img_url = has_post_thumbnail()
	? get_the_post_thumbnail_url( get_the_ID(), 'large' )
	: 'https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop';
?>
<a href="<?php the_permalink(); ?>" class="group block">
	<div class="overflow-hidden rounded-sm aspect-[3/4]">
		<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>"
		     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
	</div>
	<h3 class="mt-4 text-center font-sans font-bold uppercase text-sm tracking-wide text-teal underline underline-offset-4 group-hover:text-darkblue transition-colors duration-300"><?php the_title(); ?></h3>
</a>
