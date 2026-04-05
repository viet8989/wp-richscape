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
<div class="group relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3] md:aspect-[16/9] bg-darkblue cursor-pointer">
	<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>"
	     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-90 group-hover:opacity-100">
	<div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/90 to-transparent"></div>
	<div class="absolute bottom-6 left-6 right-6">
		<h3 class="text-2xl md:text-3xl font-black uppercase text-white tracking-wide"><?php the_title(); ?></h3>
		<a href="<?php the_permalink(); ?>"
		   class="inline-flex mt-3 text-teal items-center font-bold text-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
			Xem Dự Án
			<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
			</svg>
		</a>
	</div>
</div>
