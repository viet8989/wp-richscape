<?php
/**
 * Template Part: Service Card
 * Used in: front-page.php, archive-services.php
 * Context: inside a WP_Query loop (the_post() already called)
 * Receives: service_count via set_query_var('service_count', $n)
 */

$count    = (int) get_query_var( 'service_count', 1 );
$icon     = function_exists( 'get_field' ) ? get_field( 'service_icon' ) : null;
$icon_url = $icon['url'] ?? '';
$desc     = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 25 );

$fallback_imgs = array(
	'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop',
	'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&auto=format&fit=crop',
	'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=600&auto=format&fit=crop',
	'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600&auto=format&fit=crop',
);
$img_url = has_post_thumbnail()
	? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
	: $fallback_imgs[ ( $count - 1 ) % 4 ];
?>
<div class="group relative overflow-hidden flex flex-col h-full transition-transform duration-300 hover:-translate-y-1"
     style="background: linear-gradient(180deg, #1A2251 0%, #2A9D8F 100%); border-radius: 32px; height: 100%; border: 1px solid rgba(95,217,195,0.25);">

	<!-- Top: title left, icon+number right -->
	<div class="relative pt-7 px-6 pb-2">
		<h3 class="text-white font-sans font-bold uppercase leading-tight"
		    style="min-height: 90px; padding-right: 80px; font-size: 1.35rem;">
			<?php the_title(); ?>
		</h3>
		<!-- Number badge -->
		<div class="absolute" style="top: 14px; right: 10px; line-height: 1; z-index: 1;">
			<span class="font-sans font-bold"
			      style="font-size: 72px; color: #5FD9C3; line-height: 1;"><?php echo $count; ?></span>
		</div>
		<?php if ( $icon_url ) : ?>
		<!-- Icon PNG — sits to the left of the number -->
		<div class="absolute" style="top: 20px; right: 55px; width: 38px; z-index: 2;">
			<img src="<?php echo esc_url( $icon_url ); ?>"
			     alt=""
			     style="width: 38px; height: auto; max-height: 38px; object-fit: contain;">
		</div>
		<?php endif; ?>
	</div>

	<!-- Description -->
	<div class="px-6 pt-1 pb-5">
		<p class="text-white/85 font-body text-xs leading-relaxed"><?php echo esc_html( $desc ); ?></p>
	</div>

	<!-- Photo -->
	<div class="mx-4 mb-6 rounded-2xl overflow-hidden" style="height: 325px; margin-top: auto;">
		<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>"
		     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
	</div>

	<!-- CTA -->
	<div class="flex justify-center pb-6">
		<a href="<?php the_permalink(); ?>"
		   class="font-sans font-bold text-[11px] uppercase tracking-widest px-5 py-1.5 rounded-full border transition-colors duration-300"
		   style="border-color: #5FD9C3; color: #5FD9C3; background-color: transparent;">
			DỰ ÁN LIÊN QUAN
		</a>
	</div>
</div>
