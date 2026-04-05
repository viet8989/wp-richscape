<?php
/**
 * Template Part: Single Page Hero Banner
 * Used in: single-projects.php, single-post.php
 * Context: inside the main loop (the_post() already called)
 */

$thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$img_url   = $thumb_url ?: 'https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=1920&auto=format&fit=crop';
?>
<div class="relative w-full overflow-hidden" style="height: 480px;">
	<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>"
	     class="w-full h-full object-cover">
	<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-black/10"></div>
	<div class="absolute bottom-10 left-0 right-0">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h1 class="text-4xl md:text-5xl font-black uppercase text-white tracking-wide drop-shadow-lg"><?php the_title(); ?></h1>
		</div>
	</div>
</div>
